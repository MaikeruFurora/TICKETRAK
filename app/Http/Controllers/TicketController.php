<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use Illuminate\Support\Facades\DB;
use App\Services\DataTableService;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    protected $dataTable;

    public function __construct(DataTableService $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tickets.index');
    }



    /**
     * Get a list of all users.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request) {

        $columns = ['id', 'name', 'email', 'created_at'];

        $query = Ticket::query();

        $data = $this->dataTable->handle($request, $query, $columns, [
            'action' => function ($user) {
                return '<a href="/users/'.$user->id.'/edit" class="btn btn-sm btn-primary">Edit</a>';
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
        return view('tickets.create');
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
        'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
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
                $filename = uniqid() . '_' . $file->getClientOriginalName();
                
                // Move to public/attachments
                $file->move(public_path('attachments'), $filename);

                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'file_path' => 'attachments/' . $filename, // relative path
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }


        
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
        //
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

    public function reply() {
     
        return view('tickets.reply');
    
    }
}
