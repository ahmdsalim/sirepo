@extends('layouts.apperror')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message')
    <div class="col-md-8 col-12 offset-md-2">
        <div class="text-center">
            <img class="img-error" src="{{ asset('assets/compiled/svg/error-500.svg') }}" alt="System Error">
            <h1 class="error-title">Page Expired</h1>
            <p class="fs-5 text-gray-600">The page you are trying to access has expired. Please refresh the page or try again
                later.</p>
            <a href="{{ route('landing') }}" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
        </div>
    </div>
@endsection
