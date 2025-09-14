@extends('emails.layouts.base')

@section('title', '🎫 Ticket Created')
@section('headerColor', '#073A5E')
@section('buttonColor', '#447795')

@section('content')
<p>Hello <strong>{{ $user->name }}</strong>,</p>
<p>A new ticket has been created.</p>

<div class="ticket-details">
  <p><strong>Ticket Code:</strong> {{ $ticket->code }}</p>
  <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
  <p><strong>Status:</strong> Created</p>
</div>

<a href="{{ route('auth.tickets.show', $ticket->id) }}" class="btn">View Ticket</a>
@endsection
