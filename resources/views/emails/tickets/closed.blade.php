@extends('emails.layouts.base')

@section('title', '✅ Ticket Closed')
@section('headerColor', '#002E5D')
@section('buttonColor', '#447795')

@section('content')
<p>Hello <strong>{{ $user->name }}</strong>,</p>
<p>Your ticket has been closed. If you still need help, you may reopen it.</p>

<div class="ticket-details">
  <p><strong>Ticket Code:</strong> {{ $ticket->code }}</p>
  <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
  <p><strong>Status:</strong> Closed</p>
</div>

<a href="{{ route('auth.tickets.show', $ticket->id) }}" class="btn">Reopen Ticket</a>
@endsection
