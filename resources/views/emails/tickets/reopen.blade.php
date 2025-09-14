@extends('emails.layouts.base')

@section('title', '🔄 Ticket Reopened')
@section('headerColor', '#073A5E')
@section('buttonColor', '#002E5D')

@section('content')
<p>Hello <strong>{{ $user->name }}</strong>,</p>
<p>Your ticket has been reopened for further assistance.</p>

<div class="ticket-details">
  <p><strong>Ticket Code:</strong> {{ $ticket->code }}</p>
  <p><strong>Subject:</strong> {{ $ticket->subject }}</p>
  <p><strong>Status:</strong> Reopened</p>
</div>

<a href="{{ route('auth.tickets.show', $ticket->id) }}" class="btn">View Ticket</a>
@endsection
