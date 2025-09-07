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

</style>
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">Ticket #TCK000001</h2>
            <div class="text-muted my-2">Need help? We're here to assist! Please provide as much detail as possible so we can resolve your issue quickly and efficiently.</div>
        </div>
        <div class="col-auto ms-auto">
        <div class="btn-list">
            <span class=" d-sm-inline">
            <a href="{{  route('auth.tickets.index') }}" class="btn"> 
              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
            Back </a>
            </span>
              <a href="#" class="btn btn-primary d-none d-sm-inline-block"
          data-bs-toggle="modal" data-bs-target="#modal-report">
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
        <a href="#" class="btn btn-primary d-sm-none btn-icon"
          data-bs-toggle="modal" data-bs-target="#modal-report"
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
    <div class="card card-md mt-3">
        <div class="card-body">
                {{-- <p class="text-muted">
                Fill out the form below to submit a new support ticket. Please provide as many details as possible so we can resolve your issue quickly.
            </p> --}}
                <div class="row mb-2">
            <div class="col-sm-2">Ticket Number:</div>
            <div class="col-sm-10 text-muted"><strong>#1001</strong></div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-2">Subject:</div>
            <div class="col-sm-10 text-muted">Login Issue</div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-2">Description:</div>
            <div class="col-sm-10 text-muted">
            I have already tried clearing my browser cache, logging out and back in, and attempting the report generation from both Chrome and Edge, but the issue persists. Other reports (daily and weekly) seem to generate without any problems, so it looks like this issue is specific to the monthly report.
            </div>
        </div>
         <div class="row mb-2">
            <div class="col-sm-2">Created at:</div>
            <div class="col-sm-10 text-muted">{{ date('Y-m-d') }}</div>
        </div>
        <div class="hr-text text-grey">Response</div>
         <div class="mt-5">
                <p class="form-label text-muted">Reply to this ticket</p>    
                <textarea class="form-control" rows="3" maxlength="1000" placeholder="Please describe your issue in detail." name="description"></textarea>
        </div>   
            <div class="mt-3 mb-5">
                <button type="submit" class="btn btn-primary btn-sm"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-send"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>Submit</button>
            </div>
        <div class="mb-3">
            <div class="timeline-cointainer" style="max-height: 500px; overflow-y: auto;">
                <ul class="timeline">
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-x-lt"><!-- Download SVG icon from http://tabler.io/icons/icon/brand-x -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M4 4l11.733 16h4.267l-11.733 -16z" /><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" /></svg></div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <div class="text-secondary float-end">10 hrs ago</div>
                                <h4>+1150 Followers</h4>
                                <p class="text-secondary">You’re getting more and more followers, keep it up!</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon"><!-- Download SVG icon from http://tabler.io/icons/icon/briefcase -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" /><path d="M12 12l0 .01" /><path d="M3 13a20 20 0 0 0 18 0" /></svg></div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <div class="text-secondary float-end">2 hrs ago</div>
                                <h4>+3 New Products were added!</h4>
                                <p class="text-secondary">Congratulations!</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon"><!-- Download SVG icon from http://tabler.io/icons/icon/check -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M5 12l5 5l10 -10" /></svg></div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <div class="text-secondary float-end">1 day ago</div>
                                <h4>Database backup completed!</h4>
                                <p class="text-secondary">Download the <a href="#">latest backup</a>.</p>
                            </div>
                        </div>
                    </li>
                    <li class="timeline-event">
                        <div class="timeline-event-icon bg-facebook-lt"><!-- Download SVG icon from http://tabler.io/icons/icon/brand-facebook -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-1"><path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg></div>
                        <div class="card timeline-event-card">
                            <div class="card-body">
                                <div class="text-secondary float-end">1 day ago</div>
                                <h4>+290 Page Likes</h4>
                                <p class="text-secondary">This is great, keep it up!</p>
                            </div>
                        </div>
                    </li> 
                </ul>
            </div>

        </div>
    </div>
</div>
</div> 
@endsection