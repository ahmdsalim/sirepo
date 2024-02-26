@extends('layouts.apperror')

@section('title', __('Too Many Requests'))
@section('message')
    <div class="col-md-8 col-12 offset-md-2">
        <div class="text-center">
            <img class="img-error" src="{{ asset('assets/compiled/svg/error-500.svg') }}" alt="System Error">
            <h1 class="error-title">Too Many Requests</h1>
            <p class="fs-5 text-gray-600">The user has sent too many requests in a given amount of time.</p>
            <a href="{{ route('landing') }}" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
        </div>
    </div>
@endsection
