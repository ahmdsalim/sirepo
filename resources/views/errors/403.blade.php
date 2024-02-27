@extends('layouts.apperror')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message')
    <div class="col-md-8 col-12 offset-md-2">
        <div class="text-center">
            <img class="img-error" src="{{ asset('assets/compiled/svg/error-403.svg') }}" alt="System Error">
            <h1 class="error-title">Forbidden</h1>
            <p class="fs-5 text-gray-600">The server understood the request, but is refusing to fulfill it.</p>
            <a href="{{ route('landing') }}" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
        </div>
    </div>
@endsection
