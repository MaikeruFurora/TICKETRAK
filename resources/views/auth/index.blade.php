<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Login - Ticket System</title>
    <!-- In your layout.app inside <head> -->
    <link rel="icon" href="{{ asset('dist/images/logo.svg') }}" type="image/x-icon">

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet"/>
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/login.css') }}" rel="stylesheet"/>
  </head>
  <body>
    <div class="container-fluid g-0">
      <div class="row g-0 min-vh-100">

       <!-- LEFT: Ticket Support Info -->
        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center text-white info-panel">
        <div class="ps-5" style="max-width: 500px;">
            <img src="{{  asset('dist/images/logo.svg') }}" height="370" width="370" alt="Logo" class="mb-4">
            <h1 class="fw-bold" style="font-size: 2.2rem">{{ config('app.name') }}</h1>
            <p class="mt-3 fs-15">
            Manage and track your issues with ease.  
            Our team is here to <br>assist you.
            </p>
            <ul class="list-unstyled mt-4 fs-9">
              <li>✔ Submit tickets in seconds</li>
              <li>✔ Track updates in real-time</li>
              <li>✔ Support Without Boundaries</li>
            </ul>
        </div>
          <!-- Footer / Year Info -->
          <div class="ps-5 mb-3 mt-5" style="font-size: 0.75rem; opacity: 0.8;">
              &copy; {{ date('Y') .' '. config('app.name') }}. All rights reserved.
          </div>
        </div>


      <div class="col-lg-6 d-flex align-items-center justify-content-center p-4 bg-light">
        
        <div class="card shadow-lg w-100" style="max-width: 400px; border-radius: 20px;">
              <div class="card-body p-5">
                
                <!-- Gradient Heading -->
                <h2 class="card-title text-center mt-2 fw-bold"
                    style="background: linear-gradient(90deg, #447795, #002E5D); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.3rem;">
                  Sign in to Continue
                </h2>
                
                <!-- Subtext -->
                <small class="d-block text-center text-muted mb-5">
                  Sign in to access your support tickets and securely
                </small>

                <!-- Session Message -->
                @if (session('message'))
                  <div class="alert alert-danger">
                    {{ session('message') }}
                  </div>
                @endif

                <!-- Login Form -->
                <form autocomplete="off" action="{{ route('login.store') }}" method="POST">
                  @csrf

                  <div class="mb-3">
                    <label class="form-label fw-semibold">Email or Username</label>
                    <input type="text" name="username" class="form-control rounded-pill border-2" placeholder="Enter your email or username" required>
                    @error('username')
                      <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control rounded-pill border-2" placeholder="Enter your password" required>
                    @error('password')
                      <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="form-footer mt-4">
                    <button type="submit" class="btn w-100 rounded-pill"
                            style="background-color:#002E5D; color:white; font-weight: 600; transition: 0.3s;">
                      Login
                    </button>
                  </div>

                  <!-- Optional: Forgot Password -->
                  <div class="text-center mt-3">
                    <a href="{{ route('forgot') }}" class="text-decoration-none text-primary small">Forgot Password?</a>
                  </div>
                </form>
              </div>
            </div>
 
      </div>

      </div>
    </div>

    <!-- Tabler JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
  </body>
</html>
