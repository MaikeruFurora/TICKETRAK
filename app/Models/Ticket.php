<?php

namespace App\Models;

use Hamcrest\Description;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded=[];

    const PRORITIES = [
        ['description' => 'Low'],
        ['description' => 'Medium'],
        ['description' => 'High'],
    ];

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class)
                    ->whereNull('ticket_reply_id');
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function histories()
    {
        return $this->hasMany(TicketHistory::class)->latest(); // newest first
    }


    public function latestClosedHistory()
    {
        return $this->hasOne(TicketHistory::class)
                    ->where('new_value', 'Closed')
                    ->latestOfMany() // gets the latest record
                    ->with('user');
    }

    
}
