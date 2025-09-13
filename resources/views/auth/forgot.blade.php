<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Forgot Password - Ticket System</title>
    <link rel="icon" href="{{ asset('dist/images/logo.svg') }}" type="image/x-icon">

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tabler CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet"/>
    <style>
      body {
        font-family: 'Poppins', sans-serif;
        background-color: #F2FAFB;
      }
      .info-panel {
        background: linear-gradient(135deg, #204b6f, #85b9dc); /* lighter blue gradient */
        color: #fff;
        min-height: 100vh;      
        display: flex;          
        justify-content: flex-start;
        align-items: center;    
        text-align: left;
      }

      /* Hover effect for button */
      .btn:hover {
        background-color: #447795 !important;
      }

      /* Focus effect for inputs */
      .form-control:focus {
        border-color: #447795;
        box-shadow: 0 0 0 0.2rem rgba(68, 119, 149, 0.25);
      }
    </style>
  </head>
  <body>
    <div class="container-fluid g-0">
      <div class="row g-0 min-vh-100">

        <!-- LEFT: Ticket Support Info -->
        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center text-white info-panel">
          <div class="ps-5" style="max-width: 500px;">
            <img src="{{ asset('dist/images/logo.svg') }}" height="356" width="356" alt="Logo" class="mb-4">
            <h1 class="fw-bold" style="font-size: 2.2rem">Support Ticket System</h1>
            <p class="mt-3 fs-15">
              Manage and track your issues with ease.  
              Our team is here to assist you.
            </p>
            <ul class="list-unstyled mt-4 fs-10">
              <li>✔ Submit tickets in seconds</li>
              <li>✔ Track updates in real-time</li>
              <li>✔ Fast resolution guaranteed</li>
            </ul>
          </div>
        </div>

        <!-- RIGHT: Forgot Password Form -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center p-4 bg-light">
          <div class="card shadow-lg w-100" style="max-width: 400px; border-radius: 20px;">
            <div class="card-body p-5">

              <!-- Gradient Heading -->
              <h2 class="card-title text-center mt-2 fw-bold"
                  style="background: linear-gradient(90deg, #447795, #002E5D); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.5rem;">
                Forgot Password
              </h2>

              <!-- Subtext -->
              <small class="d-block text-center text-muted mb-4">
                Enter your email address and we will send you a password reset link
              </small>

              <!-- Session Message -->
              @if (session('message'))
                <div class="alert alert-success">
                  {{ session('message') }}
                </div>
              @endif

              <!-- Forgot Password Form -->
              <form autocomplete="off" action="{{ route('forgot.sendResetLink') }}" method="POST">
                @csrf

                <div class="mb-3">
                  <label class="form-label fw-semibold">Email Address</label>
                  <input type="email" name="email" class="form-control rounded-pill border-2" placeholder="Enter your email" required>
                  @error('email')
                    <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
                </div>

                <div class="form-footer mt-4">
                  <button type="submit" class="btn w-100 rounded-pill"
                          style="background-color:#002E5D; color:white; font-weight: 600; transition: 0.3s;">
                    Send Reset Link
                  </button>
                </div>

                <!-- Optional: Back to Login -->
                <div class="text-center mt-3">
                  <a href="{{ route('login.index') }}" class="text-decoration-none text-primary small">Back to Login</a>
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
