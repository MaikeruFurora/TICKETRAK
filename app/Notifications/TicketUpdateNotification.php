<?php

namespace App\Notifications;

use App\Mail\TicketNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketUpdateNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $ticket;
    protected $type;
    protected $messageBody;

    public function __construct($ticket, $type = 'reply', $messageBody = null)
    {
        $this->ticket = $ticket;
        $this->type = $type;
        $this->messageBody = $messageBody;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    

    public function toMail($notifiable)
    {
        return (new TicketNotification(
            $this->type === 'assigned' ? 'Ticket Assigned' : 'New Reply',
            $this->messageBody ?? 'There is an update on your ticket.',
            route('auth.tickets.show', $this->ticket->id),
            $this->type === 'assigned' ? 'View Ticket' : 'View Reply'
        ));
    }


    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->id,
            'title' => $this->type === 'assigned' ? 'Ticket Assigned' : 'New Reply',
            'message' => $this->messageBody ?? 'You have an update on your ticket.',
            'type' => $this->type,
        ];
    }
}
