@extends('emails.layouts.base')

@section('title', '👤 Ticket Assigned')
@section('headerColor', '#447795')
@section('buttonColor', '#073A5E')

@section('content')
<p>Hello <strong>{{ $user->name }}</strong>,</p>
<p>Your ticket has been assigned to <strong>{{ $ticket->assignedUser->name }}</strong>.</p>

<div class="ticket-details">
  <p><strong>Ticket Code:</strong> {{ $ticket->code }}</p>
  <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
  <p><strong>Status:</strong> Assigned</p>
</div>

<a href="{{ route('auth.tickets.show', $ticket->id) }}" class="btn">View Ticket</a>
@endsection
