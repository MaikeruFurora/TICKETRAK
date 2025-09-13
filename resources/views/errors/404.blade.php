{{-- resources/views/errors/404.blade.php --}}
@extends('errors.error-template')

@section('content')
@php
    $code = 404;
    $message = "Page Not Found";
    $description = "Sorry, the page you are looking for does not exist.";
@endphp
@endsection
