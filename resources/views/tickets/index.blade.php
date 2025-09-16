@extends('layout.app')
 
@section('content')
    <div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">Manage Ticket</h2>
            <div class="text-muted my-2">Here you can manage and track all your tickets efficiently.</div>
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
    
   {{-- Only show on medium and larger screens --}}
    <div class="d-none d-md-block">
        @if (in_array(auth()->user()->role, $role_code))
            @include('tickets.partials.admin-stats', ['ticket' => $ticket])
        @endif
    </div>
 
    <div class="card shadow-sm mt-3 border-0">
        <div class="card-body p-4">

            @php
                $today = now()->format('Y-m-d');
                $lastMonth = now()->subMonth()->format('Y-m-d');
            @endphp
    

            {{-- Filters --}}
           <div class="row mb-3">
                <div class="col-xl-8 col-lg-8 col-12">
                    <div class="row g-3 mb-4 align-items-end">
                        <!-- Status -->
                        <div class="col-12 col-sm-4 col-md-2">
                            <label class="form-label small text-muted mb-0" style="font-size: 12px">Status</label>
                            <select id="statusFilter" class="form-select form-select-sm">
                                {{-- <option value="">All</option> --}}
                                <option value="Open">Open</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>

                        <!-- From Date -->
                        <div class="col-6 col-sm-4 col-md-2">
                            <label class="form-label small text-muted mb-0" style="font-size: 12px">From</label>
                            <input type="date" id="fromDate" class="form-control form-control-sm" value="{{ $lastMonth }}">
                        </div>

                        <!-- To Date -->
                        <div class="col-6 col-sm-4 col-md-2">
                            <label class="form-label small text-muted mb-0" style="font-size: 12px">To</label>
                            <input type="date" id="toDate" class="form-control form-control-sm" value="{{ $today }}">
                        </div>

                        <!-- Filter Button -->
                        <div class="col-12 col-sm-4 col-md-2">
                            <button id="filterBtn" class="btn btn-primary w-100 btn-sm">Filter</button>
                        </div>
                    </div>
                </div>
            </div>
 
            {{-- Tickets Table --}}
            {{-- <div class="table-responsive"> --}}
                <table class="table table-bordered table-responsive table-sm table-hover align-middle w-10" 
                    id="ticketsTable"
                    data-table-url="{{ route('auth.tickets.list') }}">
                    <thead class="table-light" style="font-size: 9px">
                        <tr>
                            <th></th>
                            <th class="text-nowrap">Ticket #</th>
                            <th>Subject</th> 
                            <th>Created By</th> 
                            <th class="text-nowrap">Created At</th>
                            <th>Closed At</th>
                            <th>Closed By</th>
                            <th class="text-nowrap">Action</th>
                        </tr>
                    </thead>
                </table>
            {{-- </div> --}}
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('dist/scripts/tickets.index.js') }}?v={{ time() }}"></script>
@endsection