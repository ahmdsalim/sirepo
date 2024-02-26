@extends('layouts.apperror')

@section('title', __('Payment Required'))
@section('message')
    <div class="col-md-8 col-12 offset-md-2">
        <div class="text-center">
            <img class="img-error" src="{{ asset('assets/compiled/svg/error-500.svg') }}" alt="System Error">
            <h1 class="error-title">Payment Required</h1>
            <p class="fs-5 text-gray-600">The request cannot be processed until a payment is made. Please provide the
                necessary payment information or authorization to proceed.</p>
            <a href="{{ route('landing') }}" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
        </div>
    </div>
@endsection
