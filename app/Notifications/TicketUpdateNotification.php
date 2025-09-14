<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Mail\TicketNotification as TicketMail;

class TicketUpdateNotification extends Notification implements ShouldQueue
{
    use Queueable;

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

    public function via($notifiable)
    {
        return ['mail', 'database']; // ✅ email + db
    }

    public function toMail($notifiable)
    {
        // ✅ Use your custom mailable instead of MailMessage
        return (new TicketMail(
            $this->title,
            $this->msg,
            $this->actionUrl,
            $this->actionText,
            $this->ticket
        ))->to($notifiable->email);
    }

    public function toDatabase($notifiable)
    {
        // ✅ Keep database notifications working
        return new DatabaseMessage([
            'title' => $this->title,
            'msg' => $this->msg,
            'url' => $this->actionUrl,
            'action_text' => $this->actionText,
            'ticket' => $this->ticket,
        ]);
    }
}
