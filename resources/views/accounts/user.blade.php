@extends('layout.app')
@section('content')
    <div class="page-header">
    <div class="row align-items-center">
       <div class="col">
            <h2 class="page-title">Account User</h2>
            <div class="text-muted my-2">Manage user profiles, roles, and permissions</div>
        </div>
        <div class="col-auto ms-auto">
        <div class="btn-list">
            <span class=" d-sm-inline">
            <a href="{{  route('auth.account.user.create') }}" class="btn"> 
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
            </svg> Create User </a>
            </span>
            
        </div>
        </div>
    </div>
    </div>
    <div class="card card-md mt-3">
    <div class="card-body">
        <table  
                class="table table-sm table-responsive table-hover table-bordered align-middle" 
                id="accountUser" 
                data-role-url="{{ route('auth.account.user.update-role') }}" 
                data-table-url="{{ route('auth.account.user.list') }}"
            >
            <thead>
                <tr>
                <th>#</th>
                <th class="text-nowrap">Name</th>
                <th class="text-nowrap">usernmae</th>
                <th class="text-nowrap">email</th>
                <th class="text-nowrap">Status</th>
                <th class="text-nowrap">Created at</th>
                <th class="text-nowrap">Role</th> 
                <th class="text-nowrap">Action</th> 
                </tr>
            </thead> 
        </table>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            let tableURL = $('#accountUser').data('table-url');
            let roleUrl = $('#accountUser').data('role-url');

            $('#accountUser').DataTable({
                processing: true,   // show "Processing..." indicator
                serverSide: true,   // use server-side processing
                responsive: true,
                autoWidth: false,
                ajax: tableURL, // <-- route to your controller
                columns: [
                    { data: "id", name: "id" },
                    { data: "name", name: "name" },
                    { data: "username", name: "username" },
                    { data: "email", name: "email" },
                    { data: "is_active", name: "is_active" },
                    { data: "created_at", name: "created_at" },
                    { data: "role", name: "role" },
                    { data: "action", name: "action", orderable: false, searchable: false }
                ],
                dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
                error: function (xhr) {
                    if (xhr.status === 401) { 
                        alertify.error("Your session has expired. Please login again.");
                        window.location.href = "/";
                    }
                }
            });

         $('#accountUser').on('change', '.user-role', function () {
            let userId = $(this).data('id');
            let newRole = $(this).val();
            let $select = $(this);

            $select.prop('disabled', true);

            $.ajax({
                url: roleUrl,
                type: 'POST', // or POST if you want
                data: {
                    id: userId,
                    role: newRole,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    if (res.success) {
                        alertify.success("Role updated successfully!");
                    } else {
                        alertify.error("Failed to update role!");
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 401) {
                        alertify.error("Session expired! Please login again.");
                        window.location.href = '/';
                    } else {
                        alertify.error("Something went wrong!");
                    }
                },
                complete: function () {
                    $select.prop('disabled', false);
                }
            });
        });

        });
    </script>
@endsection

