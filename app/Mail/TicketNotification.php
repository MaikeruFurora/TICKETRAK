<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketNotification extends Mailable
{
    use Queueable, SerializesModels;

  use Queueable, SerializesModels;

    public $title;
    public $messageBody;
    public $actionUrl;
    public $actionText;

    public function __construct($title='Title', $messageBody='Test', $actionUrl = null, $actionText = null)
    {
        $this->title = $title;
        $this->messageBody = $messageBody;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
    }

    public function build()
    {
        return $this->subject($this->title)
                    ->view('emails.base')
                    ->with([
                        'title' => $this->title,
                        'message' => $this->messageBody,
                        'actionUrl' => $this->actionUrl,
                        'actionText' => $this->actionText,
                    ]);
    }

}

 

