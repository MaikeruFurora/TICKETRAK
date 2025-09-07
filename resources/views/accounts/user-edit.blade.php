@extends('layout.app')
@section('content')

{{-- Page Header --}}
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title"> Account User</h2>
        <div class="text-muted">Create and manage account users</div>
      </div>
      <div class="col-auto ms-auto">
        <a href="{{ route('auth.account.user') }}" class="btn btn-outline-secondary">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" 
               width="20" height="20" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
               fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M5 12h14" />
            <path d="M5 12l6 6" />
            <path d="M5 12l6 -6" />
          </svg>
          Back
        </a>
      </div>
    </div>
  </div>
</div>

{{-- Main Card --}}
<div class="page-body">
  <div class="container-xl">
      @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
      <form action="{{ route('auth.account.user.update',['id' => $user->id]) }}" method="POST" autocomplete="off">
        <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Create New User</h3>
        </div>
        <div class="card-body">
          @csrf
          <div class="row g-3">

            {{-- Name --}}
            <div class="col-md-6">
              <label class="form-label">Name <span class="text-danger">*</span></label>
              <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Enter full name">
              @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Username --}}
            <div class="col-md-6">
              <label class="form-label">Username <span class="text-danger">*</span></label>
              <input type="text" name="username" value="{{ $user->username }}" class="form-control" placeholder="Enter username">
              @error('username') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Email --}}
            <div class="col-md-6">
              <label class="form-label">Email <span class="text-danger">*</span></label>
              <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Enter email address">
              @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            {{-- Password --}}
            
            {{-- Role --}}
            <div class="col-md-6">
                <label class="form-label">Role <span class="text-danger">*</span></label>
                <select name="role" class="form-select">
                    @forelse ($roles as $role)
                    <option value="{{ $role['code'] }}" {{ $user->role == $role['code'] ? 'selected' : '' }}>{{ $role['description'] }}</option>
                    @empty
                    <option value="">No Role Found</option>
                    @endforelse
                </select>
            </div>
            
            {{-- Status --}}
            <div class="col-md-6">
                <label class="form-label">Status <span class="text-danger">*</span></label>
                <select name="is_active" class="form-select">
                    <option value="1" {{ $user->is_active == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $user->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            
            <div class="col-md-6">
              <label class="form-label">Password <span class="text-danger">*</span></label>
              <input type="password" name="password" class="form-control" placeholder="Enter password">
              @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

          </div>
        </div>
        <div class="card-footer py-2 text-end">
            <button type="submit" class="btn btn-primary">
                Update User
            </button>
        </div>
    </form>
    </div>
  </div>
</div>
@endsection
