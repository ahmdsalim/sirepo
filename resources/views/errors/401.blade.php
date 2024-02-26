@extends('layouts.apperror')

@section('title', __('Unauthorized'))
@section('message')
    <div class="col-md-8 col-12 offset-md-2">
        <div class="text-center">
            <img class="img-error" src="{{ asset('assets/compiled/svg/error-403.svg') }}" alt="System Error">
            <h1 class="error-title">Unauthorized</h1>
            <p class="fs-5 text-gray-600">Access to the requested resource is denied due to missing or invalid authentication
                credentials.</p>
            <a href="{{ route('landing') }}" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
        </div>
    </div>
@endsection
