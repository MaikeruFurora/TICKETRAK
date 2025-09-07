<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Ticketrak</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/css/tabler.min.css" />
    <style>
        body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f8f9fa;
        font-family: 'Poppins', sans-serif;
        }
        .login-card {
        width: 100%;
        max-width: 400px;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
        background: #fff;
        }
    </style>
</head>
<body> 
    <div class="login-card">
        <h3 class="text-center mb-4">Login</h3>
        @if (session('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
        @endif
        <form autocomplete="off" action="{{ route('login.store') }}" method="POST">
        @csrf 
        <div class="form-group mb-3">
            <label for="email">Email address</label>
            <input type="text" class="form-control" id="email" placeholder="Enter email" name="username">
            @error('username')
            <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
            @error('password')
            <small class="form-text text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
  <script
    src="https://cdn.jsdelivr.net/npm/@tabler/core@1.4.0/dist/js/tabler.min.js">
  </script>
</body>
</html>