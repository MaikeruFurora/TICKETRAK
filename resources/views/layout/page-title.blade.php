<div class="page-header">
  <div class="row align-items-center">
    <div class="col">
      {{-- <div class="page-pretitle">Welcome</div> --}}
      <h2 class="page-title">{{ $title }}</h2>
    </div>
    <div class="col-auto ms-auto">
      <div class="btn-list">
        <span class=" d-sm-inline">
          <a href="{{  route('auth.tickets.create') }}" class="btn"> 
              <svg
            xmlns="http://www.w3.org/2000/svg"
            class="icon"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
          </svg>
          Create Ticket </a>
        </span>
         
      </div>
    </div>
  </div>
</div>