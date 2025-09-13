{{-- resources/views/errors/403.blade.php --}}
@extends('errors.error-template')

@section('content')
@php
    $code = 403;
    $message = "Forbidden";
    $description = "You don't have permission to access this page.";
@endphp
@endsection
