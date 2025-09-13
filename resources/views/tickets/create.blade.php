@extends('layout.app')

@section('content')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">Submit a Support Ticket</h2>
            <div class="text-muted my-2">
                Need help? We're here to assist! Please provide as much detail as possible so we can resolve your issue quickly and efficiently.
            </div>
        </div>
        <div class="col-auto ms-auto">
            <div class="btn-list">
                <a href="{{ route('auth.tickets.index') }}" class="btn d-sm-inline">
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

<div class="row">
    <!-- LEFT: Ticket Form -->
    <div class="col-sx-12 col-xl-8">
        @if (session('message'))
            <div class="alert alert-info">
                {{ session('message') }}
            </div>
        @endif

        <div class="card card-md mt-3">
            <div class="card-body">
               <form id="ticketForm" action="{{ route('auth.tickets.store') }}" 
                    method="POST" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">

                    <!-- Subject -->
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" maxlength="120" 
                            placeholder="What's the main issue" name="subject">
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Describe your issue in detail</label>
                        <textarea class="form-control" rows="5" maxlength="1000" 
                                placeholder="Please describe your issue in detail." 
                                name="description"></textarea>
                    </div>

                    <!-- Attachments -->
                    <div class="mb-4">
                        <label for="fileInput" class="form-label">
                            Attachment Screenshot or relevant file (optional)
                        </label>
                        <div id="dropzone" class="dropzone dz-clickable text-center p-2 border border-dashed rounded bg-light">
                            <div class="dz-message">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" 
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                    class="icon icon-tabler icon-tabler-cloud-upload mb-2 text-primary">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 18h-5.343c-2.572 0 -4.657 -2.011 -4.657 -4.487 
                                            0 -2.475 2.085 -4.482 4.657 -4.482 
                                            .393 -1.762 1.794 -3.2 3.675 -3.773 
                                            1.88 -.572 3.956 -.193 5.444 1 
                                            1.488 1.19 2.162 3.007 1.77 4.769h.99 
                                            c1.38 0 2.57 .811 3.128 1.986"/>
                                    <path d="M19 22v-6" />
                                    <path d="M22 19l-3 -3l-3 3" />
                                </svg>
                                <p class="text-muted mb-0">
                                    Drag and drop files here or 
                                    <span class="text-primary fw-bold">click to browse</span>
                                </p>
                                <p id="fileCount" class="mt-1 text-secondary small"></p>
                                <ul id="fileList" class="list-unstyled small text-center mt-1 mb-1"></ul>
                                <button type="button" id="clearFiles" 
                                        class="btn-link d-none" tabindex="-1" style="font-size: 10px;">
                                    Clear attachments
                                </button>
                            </div>
                        </div>
                        <input type="file" class="d-none" id="fileInput" multiple name="attachments[]">
                    </div>

                    <!-- Submit -->
                    <div class="mb-1">
                        <button type="submit" id="submitBtn" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                stroke-width="1" stroke-linecap="round" stroke-linejoin="round" 
                                class="icon icon-tabler icons-tabler-outline icon-tabler-send me-1">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10 14l11 -11" />
                                <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                            </svg>
                            <span id="submitText">Submit</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- RIGHT: Sidebar -->
    <div class="col-sx-12 col-xl-4 mt-3">
        <!-- What happens next -->
        <div class="card mb-3">
            <div class="card-body">
                <p>What happens next?</p>
                <p class="text-muted">
                    Once you submit a support ticket, our support team will get in touch with you to resolve your issue.
                </p>
            </div>
        </div>

        <!-- Recent Tickets -->
        <div class="card mt-3">
            <div class="card-header">
                <p>Recent Tickets</p>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($tickets as $ticket)
                        <li class="list-group-item">
                            <a href="{{ route('auth.tickets.show', $ticket->id) }}" 
                               class="text-decoration-none">
                                {{ $ticket->subject }}
                            </a>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No recent tickets</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
  <script src="{{ asset('dist/scripts/tickets.create.js') }}?v={{ time() }}"></script>
@endsection
