@extends('layouts.appnifty')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.profile') }}">Profile</a></li>
        <li class="breadcrumb-item active" aria-current="page">Ubah Password</li>
    </ol>
@endsection

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2">Profile</h1>
    <p class="lead">
        Ubah Password
    </p>
@endsection

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <section>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">Ubah Password</h5>
                                <!-- Block styled form -->
                                <form class="row g-3" method="post" action="{{route('users.changepassword.store')}}">
                                @csrf
                                   <div class="col-12 col-md-6">
                                      <label class="form-label">Password Lama</label>
                                      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required="">
                                      @error('password')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                                      
                                   </div>
                                   <!-- col break -->
                                   <div class="w-100"></div>
                                   <div class="col-12 col-md-6">
                                      <label class="form-label">Password Baru</label>
                                      <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required="">
                                      @error('new_password')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                                      
                                   </div>
                                   <!-- col break -->
                                   <div class="w-100"></div>
                                   <div class="col-12 col-md-6">
                                      <label class="form-label">Konfirmasi Password</label>
                                      <input type="password" class="form-control" name="new_password_confirmation" required="">
                                   </div>
                                   <div class="col-12"> 
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                   </div>
                                </form>
                                <!-- END : Block styled form -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection