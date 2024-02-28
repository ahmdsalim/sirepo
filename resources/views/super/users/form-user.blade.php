@push('styles')
    <style>
        .field-icon {
            float: right;
            margin-left: -30px;
            margin-right: 10px;
            margin-top: -27px;
            cursor: pointer;
            position: relative;
            z-index: 2;
        }
    </style>
@endpush
<x-app-layout title="Kelola Pengguna">
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kelola Pengguna</h3>
                <p class="text-subtitle text-muted">Pengguna</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/users">Pengguna</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Edit Data Pengguna
                </h5>
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('users.update', $user->username) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6 col-12">
                        <div class="form-group mandatory">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" id="nama"
                                class="form-control @error('nama') is-invalid @enderror" placeholder="Nama pengguna"
                                value="{{ old('nama', $user->nama ?? '') }}" name="nama" required>
                            @error('nama')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group mandatory">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email pengguna"
                                value="{{ old('email', $user->email ?? '') }}" name="email" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group mandatory">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username"
                                class="form-control @error('username') is-invalid @enderror" placeholder="Username"
                                value="{{ old('username', $user->username ?? '') }}" name="username" required>
                            @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Password">
                            <span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group mandatory">
                            <label for="role" class="form-label">Role</label>
                            <select id="role" class="form-select @error('role') is-invalid @enderror"
                                name="role" required>
                                <option value="">Pilih</option>
                                <option value="super" @selected(old('role', $user->role ?? '') == 'super')>Super</option>
                                <option value="admin" @selected(old('role', $user->role ?? '') == 'admin')>Admin</option>
                                <option value="user" @selected(old('role', $user->role ?? '') == 'user')>User</option>
                            </select>
                            @error('role')
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
    </section>
</x-app-layout>
@push('scripts')
    <script>
        $(".toggle-password").click(function() {

            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
@endpush
