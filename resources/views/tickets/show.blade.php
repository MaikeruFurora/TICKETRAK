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

/* Make the select look plain but keep text visible */
/* .plain-select {
    appearance: none;         
    -webkit-appearance: none;
    -moz-appearance: none;
    border: none;             
    background: transparent;  
    font-size: 14px;          
    color: #000;              
    padding: 4px 8px;
    cursor: pointer;
    outline: none;            
} */

/* Optional: remove focus outline but add subtle underline */
/* .plain-select:focus {
    border-bottom: 1px solid #aaa;
} */
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
        <div class="row mb-3">
            <div class="col-sm-2 strong text-muted">Ticket Number:</div>
            <div class="col-sm-10 text-muted">
                    <div class="row mb-1 align-items-center">
                    <div class="col-sm-12 d-flex justify-content-between">
                        <div class="text-muted strong">
                            <strong>{{ $ticket?->code ?? 'N/A' }}</strong>
                        </div>
                        <div class="d-none d-md-block">
                              @if (in_array(auth()->user()->role, $role_code))
                                <a href="{{ route('auth.tickets.history.show', ['ticket' => $ticket->id]) }}" class="text-secondary small">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-restore"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3.06 13a9 9 0 1 0 .49 -4.087" /><path d="M3 4.001v5h5" /><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg> Logs
                                </a>
                              @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-2 strong text-muted">Subject:</div>
            <div class="col-sm-10 text-muted">{{ $ticket?->subject ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-2 strong text-muted">Description:</div>
            <div class="col-sm-10 text-muted">{{ $ticket?->description ?? 'N/A' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-2 strong text-muted">Created at:</div>
            <div class="col-sm-10 text-muted">{{ date('M d Y', strtotime($ticket?->created_at)) ?? 'N/A' }}</div>
        </div>
        @if($ticket->attachments->count())
        <div class="row mb-3">
            <div class="col-sm-2 strong text-muted">Attachments:</div>
            <div class="col-sm-10 text-muted">
                    <div class="d-flex flex-wrap mt-1">
                        @foreach($ticket->attachments as $attachment)
                            @php
                                $ext = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));
                                $url = asset('storage/' . $attachment->file_path);
                                $icon = match($ext) {
                                    'jpg','jpeg','png','gif' => $url,
                                    'pdf' => asset('dist/images/file/pdf.png'),
                                    'doc','docx' => asset('dist/images/file/doc.png'),
                                    'xls','xlsx' => asset('dist/images/file/xls.png'),
                                    default => asset('dist/images/file/file.png')
                                };
                            @endphp
                            <a href="{{ $url }}" target="_blank" class="me-2 mb-2 d-inline-block text-center" style="width:30px;">
                                <div class=" " style="width:30px; height:30px; background-image:url('{{ $icon }}'); background-size:cover; background-position:center;"></div>
                                <small class="d-block text-truncate" style="max-width:60px;font-size:10px">{{ $attachment->file_name }}</small>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
            
        <div class="row mb-3">
            <div class="col-sm-2 strong text-muted">Status:</div>
            <div class="col-sm-10 text-muted">
                 {{-- <form id="status-form p-0" data-status="{{ $ticket->status }}" action="{{ route('auth.tickets.status', ['ticket' => $ticket->id]) }}" method="GET">
                    <button type="submit" id="" class="btn-link btn-sm d-flex align-items-center">{{ $ticket->status=='Open' ? 'Close' : 'Reopen' }} Ticket</button>
                </form> --}}
                <a data-status="{{ $ticket->status }}" href="{{ route('auth.tickets.status', ['ticket' => $ticket->id]) }}" 
                class="btn-link btn-sm d-flex align-items-center">
                {{ $ticket->status=='Open' ? 'Close' : 'Reopen' }} Ticket
                </a>

            </div>
        </div>

        @if ($ticket->status!='Open')
            <div class="row mb-3">
                <div class="col-sm-2 strong text-muted">Closed at:</div>
                <div class="col-sm-10 text-muted">{{ $ticket?->latestClosedHistory?->created_at->format('Y-m-d') ?? 'N/A' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-2 strong text-muted">Closed By:</div>
                <div class="col-sm-10 text-muted">{{ $ticket?->latestClosedHistory?->user?->name ?? 'N/A' }}</div>
            </div>
        @endif
        @if (in_array(auth()->user()->role, $role_code))

            <div class="mt-0">
                {{-- Toggle Line --}}
                <div class="d-flex justify-content-between align-items-center">
                    <hr class="flex-grow-0 my-0">
                    <a class="ms-2" data-bs-toggle="collapse" href="#ticketOptions" 
                    role="button" aria-expanded="false" aria-controls="ticketOptions">
                    More Options
                    {{-- Plus SVG --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="currentColor"
                        class="icon icon-tabler icons-tabler-filled icon-tabler-circle-plus collapse-show">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M4.929 4.929a10 10 0 1 1 14.141 14.141a10 10 0 0 1 -14.14 -14.14zm8.071 4.071a1 1 0 1 0 -2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0 -2h-2v-2z" />
                    </svg>

                    {{-- Minus SVG (hidden by default) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="currentColor"
                        class="icon icon-tabler icons-tabler-filled icon-tabler-square-rounded-minus collapse-hide d-none">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 2l.324 .001l.318 .004l.616 .017l.299 .013l.579 .034l.553 .046c4.785 .464 6.732 2.411 7.196 7.196l.046 .553l.034 .579c.005 .098 .01 .198 .013 .299l.017 .616l.005 .642l-.005 .642l-.017 .616l-.013 .299l-.034 .579l-.046 .553c-.464 4.785 -2.411 6.732 -7.196 7.196l-.553 .046l-.579 .034c-.098 .005 -.198 .01 -.299 .013l-.616 .017l-.642 .005l-.642 -.005l-.616 -.017l-.299 -.013l-.579 -.034l-.553 -.046c-4.785 -.464 -6.732 -2.411 -7.196 -7.196l-.046 -.553l-.034 -.579a28.058 28.058 0 0 1 -.013 -.299l-.017 -.616c-.003 -.21 -.005 -.424 -.005 -.642l.001 -.324l.004 -.318l.017 -.616l.013 -.299l.034 -.579l.046 -.553c.464 -4.785 2.411 -6.732 7.196 -7.196l.553 -.046l.579 -.034c.098 -.005 .198 -.01 .299 -.013l.616 -.017c.21 -.003 .424 -.005 .642 -.005zm3 9h-6l-.117 .007a1 1 0 0 0 .117 1.993h6l.117 -.007a1 1 0 0 0 -.117 -1.993z" />
                    </svg>
                    </a>
                </div>

                {{-- Hidden Content --}}
                <div class="collapse mt-1" id="ticketOptions" 
                    data-bs-parent="">
                    
                    {{-- Priority --}}
                    <div class="row mb-3">
                        <div class="col-sm-2 strong text-muted">Priority:</div>
                        <div class="col-sm-10 text-muted">
                            <div class="col-3"> 
                                <select id="priority-status" 
                                        class="form-select form-select-sm " style="width: 250px"  
                                        data-ticket-id="{{ $ticket->id }}">
                                    <option></option>
                                    @forelse ($priorities as $priority)
                                        <option {{ $ticket->priority===$priority['description'] ? 'selected' : '' }} value="{{ $priority['description'] }}">{{ $priority['description'] }}</option>
                                    @empty
                                        <option>No available</option>
                                    @endforelse
                                </select>
                                <span class="text-muted small priority-status-text"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Assign To --}}
                    <div class="row mb-3">
                        <div class="col-sm-2 strong text-muted">Assign to:</div>
                        <div class="col-sm-10 text-muted">
                            <div class="col-4 mt-2"> 
                                <select id="user-select" style="width: 250px" 
                                        data-ticket-id="{{ $ticket->id }}"
                                        data-assigned-by-id="{{ auth()->user()->id }}"
                                        data-assigned-to-id="{{ $ticket->assignedUser?->id }}"
                                        data-assigned-to-name="{{ $ticket->assignedUser?->name }}"
                                        class="form-select select2 form-select-sm">
                                </select>
                            </div>
                            <span class="text-muted small user-select-text"></span>
                        </div>
                    </div>

                </div>
            </div>

        @endif
        
            
        <div class="hr-text text-grey my-5">Response</div>
        <form action="{{ route('auth.tickets.reply', ['ticket' => $ticket->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data" id="replyForm">
            @csrf 
            <div class="mt-5">
                <p class="strong text-muted">Reply to this ticket</p>    
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
                                                    'pdf' => asset('dist/images/file/pdf.png'),
                                                    'doc','docx' => asset('dist/images/file/doc.png'),
                                                    'xls','xlsx' => asset('dist/images/file/xls.png'),
                                                    default => asset('dist/images/file/file.png')
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