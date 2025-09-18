<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketUpdateNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTicketNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $user;
    protected $ticket;
    protected $title;
    protected $message;
    protected $linkText;
    protected $linkUrl;

    public function __construct(User $user, Ticket $ticket, $title, $message, $linkUrl = null, $linkText = null)
    {
        $this->user = $user;
        $this->ticket = $ticket;
        $this->title = $title;
        $this->message = $message;
        $this->linkText = $linkText;
        $this->linkUrl = $linkUrl;
    }

    public function handle()
    {
        $this->user->notify(new TicketUpdateNotification(
            $this->title,
            $this->message,
            $this->linkUrl,
            $this->linkText,
            $this->ticket
        ));
    }

}
