@extends('layout.app')
@section('content')
<style>
    .timeline-container {
  max-height: 500; /* adjust based on how tall ~5 items are */
  overflow-y: auto;
  padding-right: 5px; /* space for scrollbar */
}

.timeline-container::-webkit-scrollbar {
  width: 6px;
}
.timeline-container::-webkit-scrollbar-thumb {
  background-color: #ccc;
  border-radius: 4px;
}

.timeline {
  list-style: none;
  padding: 0;
  margin: 0;
  position: relative;
}

</style>
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">Ticket #{{ $ticket->code ?? 'N/A' }}</h2>
            <div class="text-muted my-2">Need help? We're here to assist! Please provide as much detail as possible so we can resolve your issue quickly and efficiently.</div>
        </div>
        <div class="col-auto ms-auto">
        <div class="btn-list">
            <span class=" d-sm-inline">
            <a href="{{  route('auth.tickets.index') }}" class="btn"> 
              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            Back </a>
            </span>
              <a href="{{ route('auth.tickets.create') }}" class="btn btn-info d-none d-sm-inline-block" >
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
            height="24" viewBox="0 0 24 24" stroke-width="2"
            stroke="currentColor" fill="none" stroke-linecap="round"
            stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
          </svg>
          Submit New Ticket
        </a>
        <a href="{{ route('auth.tickets.create') }}" class="btn btn-info d-sm-none btn-icon" 
          aria-label="Create new report">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
        </a> 
        </div>
        </div>
    </div>
</div>  

<div class="col-sx-12 col-xl-12">
    <div class="card card-md mt-3 bg-gray">
        <div class="card-body ">
                {{-- <p class="text-muted">
                Fill out the form below to submit a new support ticket. Please provide as many details as possible so we can resolve your issue quickly.
            </p> --}}
        <div class="row mb-2">
            <div class="col-sm-2 strong">Ticket Number:</div>
            <div class="col-sm-10 text-muted"><strong>{{ $ticket?->code ?? 'N/A' }}</strong></div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-2 strong">Subject:</div>
            <div class="col-sm-10 text-muted">{{ $ticket?->subject ?? 'N/A' }}</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-2 strong">Description:</div>
            <div class="col-sm-10 text-muted">{{ $ticket?->description ?? 'N/A' }}</div>
        </div>
         <div class="row mb-2">
            <div class="col-sm-2 strong">Created at:</div>
            <div class="col-sm-10 text-muted">{{ date('M d Y', strtotime($ticket?->created_at)) ?? 'N/A' }}</div>
        </div>
        <div class="row mb-1">
            <div class="col-sm-2 strong">Attachments:</div>
            <div class="col-sm-10 text-muted">
                @if($ticket->attachments->count())
                    <div class="d-flex flex-wrap mt-1">
                        @foreach($ticket->attachments as $attachment)
                            @php
                                $ext = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
                                $url = asset('storage/' . $attachment->file_path);
                                $icon = match($ext) {
                                    'jpg','jpeg','png','gif' => $url,
                                    'pdf' => asset('file/pdf.png'),
                                    'doc','docx' => asset('file/doc.png'),
                                    'xls','xlsx' => asset('file/xls.png'),
                                    default => asset('file/file.png')
                                };
                            @endphp
                            <a href="{{ $url }}" target="_blank" class="me-2 mb-2 d-inline-block text-center" style="width:30px;">
                                <div class=" " style="width:30px; height:30px; background-image:url('{{ $icon }}'); background-size:cover; background-position:center;"></div>
                                <small class="d-block text-truncate" style="max-width:60px;">{{ $attachment->file_name }}</small>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-2 strong">More info:
            </div>
            <div class="col-sm-10 text-muted">
                @if (in_array(auth()->user()->role, $role_code))
                <div class="col-4 mt-1">
                    <span class="text-muted">{{  $ticket->assignedUser ? 'Assigned to: ' . $ticket->assignedUser->name : 'Unassigned' }} </span>
                    <select id="user-select" 
                        data-ticket-id="{{ $ticket->id }}"
                        data-assigned-by-id="{{  auth()->user()->id }}"
                        class="form-select select2 form-select-sm">
                    </select>
                </div>
                @endif
                <form class="mt-3" action="{{ route('auth.tickets.status', ['ticket' => $ticket->id]) }}" method="GET">
                    <button type="submit" id="submitBtn" class="btn {{ $ticket->status=='Open' ? 'btn-success' : 'btn-secondary' }} btn-secondary btn-sm d-flex align-items-center">{{ $ticket->status=='Open' ? 'Close' : 'Reopen' }} Ticket</button>
                </form>
            </div>
        </div>
        <div class="hr-text text-grey my-5">Response</div>
        <form action="{{ route('auth.tickets.reply', ['ticket' => $ticket->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data" id="replyForm">
            @csrf 
            <div class="mt-5">
                <p class="form-label text-muted">Reply to this ticket</p>    
                <textarea class="form-control" rows="4" maxlength="1000" placeholder="Please describe your issue in detail." name="description"></textarea>
                @error('description')
                    <div class="text-danger mt-1">{{ $message }}</div> 
                @enderror
                  @error('attachments.*')
                    <div class="text-danger mt-1">{{ $message }}</div> 
                @enderror
            </div>  
            <div class="row mb-5 mt-2">
                <div class="col-6">  
                    <button {{ $ticket->status=='Closed' ? 'disabled' : '' }} type="submit" id="submitBtn" class="btn btn-info d-flex align-items-center"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-send"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>Submit</button>
                </div>
               <div class="col-6">
                    <div class="d-flex justify-content-end align-items-center">
                        <div id="dropzone" class="border rounded bg-light d-inline-flex align-items-center justify-content-center me-2"
                            style="width: 250px; height: 45px; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="me-1 text-primary">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 18.004h-5.343c-2.572 -.004 -4.657 -2.011 -4.657 -4.487c0 -2.475 2.085 -4.482 4.657 -4.482
                                        c.393 -1.762 1.794 -3.2 3.675 -3.773c1.88 -.572 3.956 -.193 5.444 1c1.488 1.19 2.162 3.007 1.77 4.769h.99
                                        c1.38 0 2.57 .811 3.128 1.986" />
                                <path d="M19 22v-6" />
                                <path d="M22 19l-3 -3l-3 3" />
                            </svg>
                            <span class="small text-muted fw-bold" style="font-size: 10px">Choose files <span id="fileCount"></span></span> 
                        </div>

                        <!-- X button (hidden until files selected) -->
                        <button id="clearFiles" type="button" class="btn btn-outline-danger d-none">
                        ✕
                        </button>

                        <input type="file" class="d-none" id="fileInput" multiple name="attachments[]"> 
                    </div>
                    <!-- file list preview -->
                    <ul id="fileList" class="mt-2 d-none"></ul>
                </div>


            </div> 
        </form>
        <div class="mb-3">
            <div class="timeline-cointainer" style="max-height: 500px; overflow-y: auto;">
                <ul class="timeline">
                    @forelse($ticket->replies->reverse() as $reply)
                     <li class="timeline-event">
                        <div class="timeline-event-icon bg-x-lt">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="70"  height="70"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M9 12l2 2l4 -4" /></svg>
                        </div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <div class="text-secondary float-end">{{ date('M d, Y h:i A', strtotime($reply->created_at)) }}</div>
                                <h4>{{ $reply->user->name }}</h4>
                                <p class="text-secondary">{{ $reply->description }}</p>
                                 <!-- Attachments -->
                                @if($reply->attachments->count())
                                    <div class="d-flex flex-wrap mt-2">
                                        @foreach($reply->attachments as $attachment)
                                            @php
                                                $ext = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
                                                $url = asset('storage/' . $attachment->file_path);
                                                $icon = match($ext) {
                                                    'jpg','jpeg','png','gif' => $url,
                                                    'pdf' => asset('file/pdf.png'),
                                                    'doc','docx' => asset('file/doc.png'),
                                                    'xls','xlsx' => asset('file/xls.png'),
                                                    default => asset('file/file.png')
                                                };
                                            @endphp
                                            <a href="{{ $url }}" target="_blank" class="me-2 mb-2 d-inline-block text-center" style="width:30px;">
                                                <div class=" " style="width:30px; height:30px; background-image:url('{{ $icon }}'); background-size:cover; background-position:center;"></div>
                                                <small class="d-block text-truncate" style="max-width:60px;">{{ $attachment->file_name }}</small>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div> 
                           
                        </div>
                    </li>
                    @empty
                    {{-- <li class="timeline-item">
                        <div class="timeline-content">
                            <p class="text-muted">No replies yet.</p>
                        </div>
                    </li> --}}
                    @endforelse
                </ul>
            </div>
        </div> 
    </div>
</div>
</div> 
@endsection
@section('scripts')
<script src="{{ asset('dist/scripts/tickets.show.js') }}?v={{ time() }}"></script>
@endsection