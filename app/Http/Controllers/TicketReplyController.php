<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\TicketAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request, Ticket $ticket)
   {
        $validated = $request->validate([
            'description'   => 'nullable|string|max:1000|required_without:attachments',
            'attachments'   => 'nullable|required_without:description',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:2048',
        ], [
            'description.required_without' => 'Please enter a description or upload at least one attachment.',
            'attachments.required_without' => 'Please upload a file or provide a description.',
        ]);

        $description = $validated['description'] ?? null;

        if (!$description && $request->hasFile('attachments')) {
            $description = 'File(s) attached';
        }
        
        DB::transaction(function () use ($request, $ticket, $validated, $description) {
             $reply = TicketReply::create([
                 'ticket_id' => $ticket->id,
                 'user_id' => auth()->user()->id,
                 'description' => $description,
             ]); 
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    TicketAttachment::create([
                        'ticket_id' => $ticket->id,
                        'ticket_reply_id' => $reply->id,
                        'file_path' => $file->store('attachments', 'public'),
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                }
            }
        });

        return redirect()->route('auth.tickets.show', $ticket->id)
                        ->with('message', 'Reply added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TicketReply  $ticketReply
     * @return \Illuminate\Http\Response
     */
    public function show(TicketReply $ticketReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TicketReply  $ticketReply
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketReply $ticketReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TicketReply  $ticketReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketReply $ticketReply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TicketReply  $ticketReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketReply $ticketReply)
    {
        //
    }
}
