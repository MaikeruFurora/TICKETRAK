@extends('layout.app')

@section('content')
<div class="page-header mt-1">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">Update Your Profile</h2>
            <div class="text-muted mt-2 mb-3">
                Keep your profile details up to date to ensure smooth communication 
                and account security. You can update your name, email, phone number, 
                profile picture, and even change your password if needed.
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title ">Edit Your Profile</h4>
                 
                
                <form action="{{ route('auth.account.profile.update') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <!-- Personal Info -->
                    <br><div class="hr-text my-5">Personal Information</div>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', auth()->user()->name) }}" 
                               required>
                        <small class="form-text text-muted">Displayed on your profile and communications.</small>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Representative Name</label>
                        <input type="text" 
                               name="name" 
                               class="form-control @error('representative') is-invalid @enderror" 
                               value="{{ old('representative', auth()->user()->representative) }}" 
                               required>
                        <small class="form-text text-muted">Representative</small>
                        @error('representative')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', auth()->user()->email) }}" 
                               required>
                        <small class="form-text text-muted">Used for login and account notifications.</small>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                   <div class="my-3">
                        <label class="form-label">Username</label>
                        <input type="text" 
                            name="username" 
                            class="form-control @error('username') is-invalid @enderror" 
                            value="{{ old('username', auth()->user()->username) }}">
                        <small class="form-text text-muted">
                            This will be your unique identifier for logging in or displaying in your profile.
                        </small>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <!-- Security -->
                   <br><div class="hr-text my-5">Security</div>
                    <div class="mb-3 ">
                        <label class="form-label">New Password (optional)</label>
                        <input type="password" 
                               name="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Leave blank to keep your current password">
                        <small class="form-text text-muted">
                            Use at least 8 characters, including numbers and special symbols, for better security.
                        </small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" 
                               name="password_confirmation" 
                               class="form-control" 
                               placeholder="Re-enter your new password">
                        <small class="form-text text-muted">This ensures your new password was typed correctly.</small>
                    </div>

                    <!-- Submit -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div> 
    </div>

    <!-- Extra Information Section -->
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Why keep your profile updated?</h5>
                <p class="text-muted small mb-3">
                    Keeping your profile current ensures better communication and account security. 
                    Here’s why it matters:
                </p>
                <ul class="mb-0 ps-3">
                    <li>✔ Receive important updates and notifications.</li>
                    <li>✔ Be reachable in case of account issues.</li>
                    <li>✔ Improve your account security and recovery.</li>
                    <li>✔ Look more professional with a profile photo.</li>
                </ul>
            </div>
        </div>
    </div>

</div>

@endsection
