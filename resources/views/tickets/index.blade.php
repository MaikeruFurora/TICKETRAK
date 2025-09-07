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
    <div class="card card-md mt-3">
    <div class="card-body">
        <table class="table table-responsive table-hover table-bordered align-middle" id="example">
        <thead>
            <tr>
            <th>#</th>
            <th class="text-nowrap">Ticket No</th>
            <th class="text-nowrap">Subject</th>
            <th class="text-nowrap">Created at</th>
            <th class="text-nowrap">Description</th>
            <th class="text-nowrap">Status</th>
            <th class="text-nowrap">Action</th> 
            </tr>
        </thead>
        <tbody>
            <tr>
            <th>1</th>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td> 
            </tr>
            <tr>
            <th>2</th>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            <td>Cell</td>
            </tr>
        </tbody>
        </table>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            $('#example').DataTable({
                "responsive": true,
                "autoWidth": false,
                "dom":"<'row mb-3'<'col-sm-6'l><'col-sm-6'f>>" +"<'row'<'col-sm-12'tr>>" +"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection

