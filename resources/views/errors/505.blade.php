{{-- resources/views/errors/500.blade.php --}}
@extends('errors.error-template')

@section('content')
@php
    $code = 500;
    $message = "Internal Server Error";
    $description = "Oops! Something went wrong on our end.";
@endphp
@endsection
