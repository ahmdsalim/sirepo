@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-end">
            <button onclick="history.back()" class="btn icon btn-md icon-left">
                <h6>&times Tutup</h6>
            </button>
        </div>
    </div>
    <div class="container">
        <h3 class="text-center mt-3 mb-5">Contributors</h3>
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Ahmad Salim Asshobri</h5>
                        <p class="text-muted">Developer</p>
                    </div>
                    <div class="card-footer pt-0 border-0">
                        <div class="d-flex gap-3">
                            <a href="https://github.com/ahmdsalim" target="_blank" rel="no-follow"><i
                                    class="bi bi-github"></i></a>
                            <a href="https://instagram.com/ahmadsalim_as" target="_blank" rel="no-follow"><i
                                    class="bi bi-instagram"></i></a>
                            <a href="https://linkedin.com/in/ahmdsalim" target="_blank" rel="no-follow"><i
                                    class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Akmal Nur Sidiq</h5>
                        <p class="text-muted">Developer</p>
                    </div>
                    <div class="card-footer pt-0 border-0">
                        <div class="d-flex gap-3">
                            <a href="https://github.com/akmalns28" target="_blank" rel="no-follow"><i
                                    class="bi bi-github"></i></a>
                            <a href="https://instagram.com/akmalns28" target="_blank" rel="no-follow"><i
                                    class="bi bi-instagram"></i></a>
                            <a href="https://linkedin.com/in/akmal-ns" target="_blank" rel="no-follow"><i
                                    class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
