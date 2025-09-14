<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketHistoryController extends Controller
{
    public function show(Ticket $ticket)
{
    // Eager load histories and user
    $ticket->load('histories.user');
    $events = [];

    $events[] = [
        'date' => 'Start',
        'content' => "Ticket created by {$ticket->user?->name} <small>{$ticket->created_at->format('M d, Y h:i A')}</small>"
    ];

    // Start event
    if ($ticket->status == 'open') {
        $events[] = [
            'date' => 'Opened',
            'content' => "Ticket opened <small>{$ticket->created_at->format('M d, Y h:i A')}</small>"
        ];
    }

    // Initial assignment (if ticket has a user assigned initially)
    if ($ticket->assigned_to_id) {
        $assignedUser = $ticket->assignedTo?->name ?? 'System';
        $events[] = [
            'date' => 'Assigned',
            'content' => "Ticket initially assigned to {$assignedUser} <small>{$ticket->created_at->format('M d, Y h:i A')}</small>"
        ];
    }

    // Add histories
    foreach ($ticket->histories as $history) {
       if ($history->type === 'assigned') {
            $events[] = [
                'date' => 'Assigned',
                'content' => "Assigned to {$history->new_value} <small>by {$history->user?->name} on {$history->created_at->format('M d, Y h:i A')}</small>"
            ];
        }
    }

    // Add replies
    foreach ($ticket->replies as $reply) {
        $events[] = [
            'date' => 'In Progress',
            'content' => "Replied by {$reply->user?->name} <small>{$reply->created_at->format('M d, Y h:i A')}</small>"
        ];
    }

    // Add Closed as the end event
    if ($ticket->status === 'Closed') {
        $lastClosed = $ticket->histories->where('new_value', 'Closed')->last();
        $events[] = [
            'date' => 'Closed',
            'content' => "Ticket closed by {$lastClosed?->user?->name} <small>{$lastClosed?->created_at->format('M d, Y h:i A')}</small>"
        ];
    }



    
    return view('tickets.history', compact('ticket', 'events'));
}


}
