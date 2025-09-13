@extends('layout.app')
@section('style')
<link rel="stylesheet" href="{{ asset('dist/scripts/roadmap/roadmap.css') }}?v={{ time() }}"   type="text/css" />
@endsection
@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">Ticket Logs #{{ $ticket->code ?? 'N/A' }}</h2>
            <div class="text-muted my-2">
                 Here you can see all actions and status changes for this ticket, including assignments, closures, and reopenings.
            </div>
        </div>
        <div class="col-auto ms-auto">
            <div class="btn-list">
                <a href="{{ route('auth.tickets.show', ['ticket' => $ticket->id]) }}" class="btn d-sm-inline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                         class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M5 12h14M5 12l6 6M5 12l6 -6" />
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">
        <h3 class="card-title">Ticket History Table</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
            <table class="table table-hover table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Old Value</th>
                        <th>New Value</th>
                        <th>By</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ticket->histories as $index => $history)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ ucfirst($history->type) }}</td>
                            <td>{{ $history->old_value ?? '-' }}</td>
                            <td>{{ $history->new_value ?? '-' }}</td>
                            <td>{{ $history->user?->name ?? 'System' }}</td>
                            <td>{{ $history->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    @endforeach
                    @if($ticket->histories->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-muted">No history yet.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="my-roadmap" class="roadmap"></div>

@endsection

@section('scripts')
<!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>

  <script src="{{ asset('dist/scripts/roadmap/roadmap.js') }}?v={{ time() }}"></script>
  <script>
    $(document).ready(function(){
    let events = {!! json_encode($events) !!}; // Pass from controller as JSON

    $('#my-roadmap').roadmap(events, {
        eventsPerSlide: 6,
        slide: 1,
        prevArrow: `<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
        nextArrow: `<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
        onBuild: function() {
            console.log('Roadmap built');
        }
    });
});
  </script>
@endsection
