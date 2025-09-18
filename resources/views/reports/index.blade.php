@extends('layout.app')
@section('content')
<div class="page-header mt-1">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">Report</h2>
            <div class="text-muted my-2">Generate Report</div>
        </div>
        <div class="col-auto ms-auto">
          <div class="btn-list">
              <span class=" d-sm-inline">
              <a href="{{  route('auth.tickets.index') }}" class="btn"> 
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
              Back </a>
              </span>
                <button id="downloadReportBtn" data-generate-report="{{ route('auth.report.generate.report') }}" class="btn btn-info d-none d-sm-inline-block" >
                  Download Report
                </button>
          </div>
        </div>
    </div>
</div>  
@php
    $today = now()->format('Y-m-d');
    $lastMonth = now()->subMonth()->format('Y-m-d');
@endphp
<div class="col-sx-12 col-xl-12">
    <div class="card card-md mt-3 bg-gray">
      <div class="card-body"> 
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
                            <input type="date" id="fromDate" class="form-control form-control-sm" value="{{ $lastMonth  }}">
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
        <div id="ticketTableBody" class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table table-bordered table-hover table-striped mb-0" data-report-list-url="{{ route('auth.report.list') }}">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Ticket No.</th>
                        <th>Subject</th>
                        <th>Representative</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Closed At</th>
                        <th>Closed By</th>
                        <th>Resolved Days</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table> 
        </div>
      </div>
    </div>
</div> 
@endsection 
@section('scripts')
<script src="{{ asset('dist/scripts/tickets.report.js') }}?v={{ time() }}"></script>
@endsection