{{-- resources/views/errors/419.blade.php --}}
@extends('errors.error-template')

@section('content')
@php
    $code = 419;
    $message = "Page Expired";
    $description = "Your session has expired due to inactivity. Please refresh the page or log in again.";
@endphp
@endsection
