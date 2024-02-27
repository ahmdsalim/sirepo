@extends('layouts.apperror')

@section('title', __('Method Not Allowed'))
@section('code', '405')
@section('message')
    <div class="col-md-8 col-12 offset-md-2">
        <div class="text-center">
            <img class="img-error" src="{{ asset('assets/compiled/svg/error-404.svg') }}" alt="System Error">
            <h1 class="error-title">Method Not Allowed</h1>
            <p class="fs-5 text-gray-600">The method specified in the request is not allowed for the resource identified by
                the request. Please ensure you are using an appropriate HTTP method for this resource.</p>
            <a href="{{ route('landing') }}" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
        </div>
    </div>
@endsection
