@extends('landing.setting.sidebar')

@section('setting')
<div class="card" id="settings-card">
    <div class="card-header">
        <h4>Profil</h4>
    </div>
    <div class="card-body">
        <form class="row" action="{{ route('users.update', $user->username) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama pengguna" value="{{ old('nama', $user->nama ?? '') }}" name="nama" required>
                    @error('nama')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email pengguna" value="{{ old('email', $user->email ?? '') }}" name="email" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ old('username', $user->username ?? '') }}" name="username" required>
                    @error('username')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
