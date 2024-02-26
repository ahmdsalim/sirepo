@extends('layouts.apperror')

@section('title', __('Service Unavailable'))
@section('message')
    <div class="col-md-8 col-12 offset-md-2">
        <div class="text-center">
            <img class="img-error" src="{{ asset('assets/compiled/svg/error-500.svg') }}" alt="System Error">
            <h1 class="error-title">Service Unavailable</h1>
            <p class="fs-5 text-gray-600">The server is currently unable to handle the request due to a temporary overloading
                or maintenance of the server.</p>
            <a href="{{ route('landing') }}" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
        </div>
    </div>
@endsection
