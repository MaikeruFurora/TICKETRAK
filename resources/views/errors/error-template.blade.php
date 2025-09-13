{{-- resources/views/errors/error-template.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $code ?? 'Error' }} - {{ $message ?? 'Something went wrong' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/css/tabler.min.css" rel="stylesheet"/>
    <style>
        body, html { min-height: 100vh; display: flex; justify-content: center; align-items: center; }
        .error-page { text-align: center; padding: 1rem; }
        .error-page svg { width: 100px; height: 100px; margin-bottom: 1rem; stroke-width:2; }
    </style>
</head>
<body>
    <div class="error-page">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-circle" viewBox="0 0 24 24" fill="none" stroke="#206bc4" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <circle cx="12" cy="12" r="9" />
            <line x1="12" y1="8" x2="12" y2="12" />
            <line x1="12" y1="16" x2="12.01" y2="16" />
        </svg>
        <h1 class="display-1">{{ $code ?? 'Error' }}</h1>
        <h2 class="h3 mb-3">{{ $message ?? 'Something went wrong' }}</h2>
        <p class="text-muted mb-4">{{ $description ?? 'Please try again or contact support.' }}</p>
        <a href="{{ url('/') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
                <line x1="5" y1="12" x2="11" y2="18"/>
                <line x1="5" y1="12" x2="11" y2="6"/>
            </svg>
            Go Back Home
        </a>
    </div>
</body>
</html>
