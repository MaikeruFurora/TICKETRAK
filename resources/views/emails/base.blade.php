<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>sasa</title>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f9f9f9; padding: 20px; }
        .card { max-width: 600px; margin: auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 0 15px rgba(0,0,0,0.1);}
        .btn { display: inline-block; background: #002E5D; color: #fff; padding: 12px 20px; text-decoration: none; border-radius: 6px;}
    </style>
</head>
<body>
    <div class="card">
        <h2 style="color:#002E5D;">{{ $title }}</h2>
        {{-- <p>{{ $message }}</p>

        @if(!empty($actionUrl))
            <a href="{{ $actionUrl }}" class="btn">{{ $actionText ?? 'View' }}</a>
        @endif --}}
    </div>
</body>
</html>
