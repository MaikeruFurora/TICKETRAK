<?php

namespace App\Http\Controllers;

use App\Mail\TicketNotification;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketHistory;
use App\Models\TicketReply;
use App\Models\User;
use App\Notifications\TicketUpdateNotification;
use Illuminate\Support\Facades\DB;
use App\Services\DataTableService;
use App\Services\ChunkUploadService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{

    protected $dataTable;
    protected $chunkUploadService;

    public function __construct(DataTableService $dataTable, ChunkUploadService $chunkUploadService)
    {
        $this->dataTable = $dataTable;
        $this->chunkUploadService = $chunkUploadService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $role_code = array_column(User::ROLES_ONE, 'code');
 
        $ticket = [
            'open'     => $this->formatNumberShort(Ticket::where('status', 'Open')->count()),
            'closed'   => $this->formatNumberShort(Ticket::where('status', 'Closed')->count()),
            'total'    => $this->formatNumberShort(Ticket::count()),
            'critical' => $this->formatNumberShort(Ticket::where('status', 'Open')
                                ->where('created_at', '<', Carbon::now()->subDays(7))
                                ->count()),
        ]; 
        return view('tickets.index',compact('ticket','role_code'));
    }



    /**
     * Get a list of all users.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
   public function list(Request $request)
    {
        $columns = [
            'code',
            'subject',
            'description',
            'status',
            'created_at',
        ];

        $role_code = array_column(User::ROLES_ONE, 'code');

        if (in_array(auth()->user()->role, $role_code)) {
            $query = Ticket::with(['attachments', 'latestClosedHistory']);
        } else {
            $query = auth()->user()->tickets()->getQuery()->with(['attachments', 'latestClosedHistory']);
        }

 
        // ✅ Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59',
            ]);
        }

        $data = $this->dataTable->handle($request, $query, $columns, [
            'status' => function ($ticket) {
                return $ticket->status === 'Open' ? '<span class="badge text-white bg-warning">Open</span>' : '<span class="badge text-white bg-success">Closed</span>';
            },
            'attachment_count' => function ($ticket) {
                return $ticket->attachments->count() > 1
                    ? $ticket->attachments->count().' file(s)'
                    : ' ';
            },
            'subject' => function ($ticket) {
                return \Illuminate\Support\Str::limit(
                    $ticket->description,
                    50,
                    ' <a href="/auth/tickets/show/'.$ticket->id.'" style="font-size: 10px;">more</a>'
                );
            },
            'description' => function ($ticket) {
                return \Illuminate\Support\Str::limit(
                    $ticket->description,
                    50,
                    ' <a href="/auth/tickets/show/'.$ticket->id.'" style="font-size: 10px;">more</a>'
                );
            },
           'created_by' => function ($ticket) {
                return $ticket->user->name;
            },
            'closed_at' => function ($ticket) {
                return $ticket->latestClosedHistory
                    ? $ticket->latestClosedHistory->created_at->format('Y-m-d')
                    : '-';
            },
            'closed_by' => function ($ticket) {
                return $ticket->latestClosedHistory && $ticket->latestClosedHistory->user
                    ? $ticket->latestClosedHistory->user->name
                    : '-';
            },
            'action' => function ($ticket) {
                return '<a href="/auth/tickets/show/'.$ticket->id.'" class="btn btn-sm btn-primary w-100">View</a>';
            }
        ]);

        return response()->json($data);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tickets = auth()->user()->tickets()->take(5)->get();
        return view('tickets.create',compact('tickets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'subject' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:2048',
            ]);

            DB::transaction(function () use ($request, $validated) {
                // Generate ticket code
                $lastTicket = Ticket::latest('id')->first();
                $nextId = $lastTicket ? $lastTicket->id + 1 : 1;
                $ticketCode = 'TCK-' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

                $ticket = Ticket::create([
                    'code'        => $ticketCode, // make sure you add column in migration
                    'user_id'     => $validated['user_id'],
                    'subject'     => $validated['subject'],
                    'description' => $validated['description'],
                ]);

                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        // Store file in "storage/app/public/attachments"
                        $path = $file->store('attachments', 'public');

                        TicketAttachment::create([
                            'ticket_id' => $ticket->id,
                            'file_path' => $path, // this is relative to storage/app/public
                            'file_name' => $file->getClientOriginalName(),
                        ]);
                    }
                }

                TicketHistory::create([
                    'ticket_id' => $ticket->id,
                    'user_id'   => $ticket->user_id,
                    'type'      => 'created',
                    'old_value' => null,  // probably 'Closed'
                    'new_value' => 'Open',
                ]);

                DB::afterCommit(function () use ($ticket) {
                    // Send notification (queued for speed)
                    $users = User::where('role', 'ticket_manager')->get();
                    foreach ($users as $user) {
                        $user->notify(
                            (new TicketUpdateNotification(
                                'New Ticket',
                                'A new support ticket (#'. $ticket->code .') has been submitted by '. $ticket->user->name. '. Please review and respond accordingly.',
                                route('auth.tickets.show', $ticket->id),
                                'View Ticket',
                                $ticket
                            ))->delay(now()->addMinutes(1)) // Delay by 1 minute
                        );
                    }
                        
                    // $emails = User::where('role','ticket_manager')->pluck('email')->toArray();
                    // Mail::to($emails)->send(new TicketNotification(
                    //     'New Ticket',
                    //     'A new support ticket (#'. $ticket->code .') has been submitted by '. $ticket->user->name. '. Please review and respond accordingly.',
                    //     route('auth.tickets.show', $ticket->id),
                    //     'View Ticket'
                    // ));
                });
            
            });
            
            return redirect()->route('auth.tickets.create')->with('message', 'Ticket created successfully ');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $priorities  =  Ticket::PRORITIES; 
        $ticket->load('attachments', 'replies', 'replies.attachments', 'replies.user','assignedUser');
        $role_code = array_column(User::ROLES_ONE, 'code');
        return view('tickets.show', compact('ticket','role_code','priorities'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function changeStatus(Request $request, Ticket $ticket)
    {
       DB::transaction(function () use ($ticket, $request) {

            $oldStatus = $ticket->status; // store old status

            $oldStatus = $ticket->status;

            // Toggle ticket status
            $ticket->status = $ticket->status === 'Open' ? 'Closed' : 'Open';
            $ticket->save();

            if ($ticket->status === 'Closed') {
                $description = $ticket->user_id === auth()->id()
                    ? 'You closed your ticket.'
                    : 'Your support ticket has been successfully resolved and closed. Thank you for reaching out, and feel free to contact us if you need further assistance.';
            } else { // reopened
                $description = 'Your support ticket has been reopened. Our team will review it and respond as soon as possible.';
            }

            // Create reply
            TicketReply::create([
                'ticket_id'   => $ticket->id,
                'user_id'     => auth()->id(),
                'description' => $description,
            ]);

            // Create history
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id'   => auth()->id(),
                'type'      => 'status',
                'old_value' => $oldStatus,
                'new_value' => $ticket->status,
            ]);

            $user = User::findorfail($ticket->user_id);

             // Send notifications after the transaction is committed
            DB::afterCommit(function () use ($user,$description, $ticket) {
                
                // Send notification (queued for speed)
                $user->notify(
                    (new TicketUpdateNotification(
                        'Ticket '.$ticket->status,
                        $description. ' (#'. $ticket->code .')',
                        null,
                        null,
                        $ticket
                    ))->delay(now()->addMinutes(1)) // Delay by 1 minute
                );
                    
                // Mail::to($user->email)->send(new TicketNotification(
                //     'Ticket '.$ticket->status,
                //     $description. ' (#'. $ticket->code .')',
                //     null,
                //     null,
                //     $ticket
                // ));
            });

        });


        return redirect()
            ->route('auth.tickets.show', ['ticket' => $ticket->id])
            ->with('message', 'Ticket status updated successfully.');
    }

    public function uploadChunk(Request $request, ChunkUploadService $service)
    {
        return response()->json($service->handle($request));
    }

    public  function formatNumberShort($number) {
        if ($number >= 1000000000) {
            return round($number / 1000000000, 1) . 'B';
        } elseif ($number >= 1000000) {
            return round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        } else {
            return (string) $number;
        }
    }

      
    public function updatePriorityStatus(Request $request){

        $validated = $request->validate([
            'priority' => 'required|string|max:20',
            'ticket_id' => 'required|exists:tickets,id',
        ]);

        $ticket = Ticket::findOrFail($validated['ticket_id']);
        $old_priority = $ticket->priority;
        $ticket->priority = $validated['priority'];
        $ticket->save();

        TicketHistory::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'type'      => 'priority',
            'old_value' => $old_priority,
            'new_value' => $validated['priority'],
        ]);

        return response()->json(['success' => true,'message' => 'Priority successfully changed to '.$validated['priority']]);
    }

}
