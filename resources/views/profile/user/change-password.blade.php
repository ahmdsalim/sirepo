@extends('layouts.applanding')
@section('breadcrumb') 
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('landing') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Ubah Password</a></li>
    </ol> 
@endsection

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2 text-center">Ubah Password</h1>
    <p class="lead text-center">
        Masukkan Password Yang Secure Dan Mudah Diingat
    </p>
@endsection

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <section>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-5 mb-3">
                        <div class="card bg-white">
                            <div class="card-body">
                                <!-- Block styled form -->
                                <form class="row g-2" method="post" action="{{route('pembaca.changepassword.store')}}">
                                @csrf
                                   <div class="col-12 text-start">
                                      <label class="form-label">Password Lama</label>
                                      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required="">
                                      @error('password')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                                      
                                   </div>
                                   <div class="col-12 text-start">
                                      <label class="form-label">Password Baru</label>
                                      <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required="">
                                      @error('new_password')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                                      
                                   </div>
                                   <div class="col-12 text-start">
                                      <label class="form-label">Konfirmasi Password</label>
                                      <input type="password" class="form-control" name="new_password_confirmation" required="">
                                   </div>
                                   <div class="col-12 text-end"> 
                                      <button type="submit" class="btn btn-primary">Ubah Password</button>
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