@extends('layouts.appnifty')

@section('content')
			<div class="content__boxed">
                <div class="content__wrap">
                    <div class="card">
                        <div class="card-body">

                            <div class="d-md-flex gap-4">

                                <div class="flex-fill min-w-0">
                                    <h1 class="h3">{{$notif->title}}</h1>

                                    <!-- Sender information -->
                                    <div class="d-md-flex mt-4">
                                        <div class="d-flex mb-3 position-relative">
                                            <div class="flex-shrink-0">
                                                <img class="img-sm rounded-circle" src="../../assets/img/profile-photos/1.png" alt="Profile Picture" loading="lazy">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <span class="h6 btn-link text-decoration-underline stretched-link mb-0">Sistem</span>
                                                <small class="d-block text-muted">noreply@ruangbaca.me</small>
                                            </div>
                                        </div>

                                        <div class="ms-auto d-md-flex flex-md-column align-items-md-end">
                                            <small class="text-muted">{{ Carbon\Carbon::parse($notif->created_at)->format('l d, F Y') }}</small>
                                            <div class="">
                                                <a href="{{ route('inbox.index') }}" class="fw-semibold btn-link">Kembali</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END : Sender information -->

                                    <!-- Email content -->
                                    <div class="lh-lg py-4 border-top">
                                        {{ $notif->body }}
                                    </div>
                                    <!-- END : Email content -->

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
@endsection