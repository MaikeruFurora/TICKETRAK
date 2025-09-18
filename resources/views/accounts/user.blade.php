@extends('layout.app')
@section('content')
    <div class="page-header mt-1">
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
    <script src="{{ asset('dist/scripts/accounts.user.js') }}?v={{ time() }}"></script>
@endsection

