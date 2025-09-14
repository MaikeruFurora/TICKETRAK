<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $msg;
    public $actionUrl;
    public $actionText;
    public $ticket;

    public function __construct($title, $msg, $actionUrl = null, $actionText = null, $ticket = [])
    {
        $this->title = $title;
        $this->msg = $msg;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
        $this->ticket = $ticket;
    }

    public function build()
    {
        return $this->subject($this->title)
            ->view('emails.tickets.index') // ✅ custom blade view
            ->with([
                'title' => $this->title,
                'msg' => $this->msg,
                'actionUrl' => $this->actionUrl,
                'actionText' => $this->actionText,
                'ticket' => $this->ticket,
            ]);
    }
}
