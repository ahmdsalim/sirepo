@extends('layouts.app')
@section('title','Mendaftar Sebagai Sekolah')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card p-3">
                <div class="card-body">
                    <h4 class="mb-3">Mendaftar sebagai Sekolah</h4>
                    @if(Session::has('message'))
                    <div class="alert alert-square {{Session::get('alert-class')}} d-flex align-items-center" role="alert">
                        @if(Session::get('alert-class') == 'alert-success')
                        <svg viewBox="0 0 512 512" width="30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="currentcolor"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>success-filled</title> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="add-copy-2" fill="currentcolor" transform="translate(42.666667, 42.666667)"> <path d="M213.333333,3.55271368e-14 C95.51296,3.55271368e-14 3.55271368e-14,95.51296 3.55271368e-14,213.333333 C3.55271368e-14,331.153707 95.51296,426.666667 213.333333,426.666667 C331.153707,426.666667 426.666667,331.153707 426.666667,213.333333 C426.666667,95.51296 331.153707,3.55271368e-14 213.333333,3.55271368e-14 Z M293.669333,137.114453 L323.835947,167.281067 L192,299.66912 L112.916693,220.585813 L143.083307,190.4192 L192,239.335893 L293.669333,137.114453 Z" id="Shape"> </path> </g> </g> </g></svg>
                        @else
                        <svg viewBox="0 0 24 24" width="30" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.7605 15.92L15.3605 4.4C14.5005 2.85 13.3105 2 12.0005 2C10.6905 2 9.50047 2.85 8.64047 4.4L2.24047 15.92C1.43047 17.39 1.34047 18.8 1.99047 19.91C2.64047 21.02 3.92047 21.63 5.60047 21.63H18.4005C20.0805 21.63 21.3605 21.02 22.0105 19.91C22.6605 18.8 22.5705 17.38 21.7605 15.92ZM11.2505 9C11.2505 8.59 11.5905 8.25 12.0005 8.25C12.4105 8.25 12.7505 8.59 12.7505 9V14C12.7505 14.41 12.4105 14.75 12.0005 14.75C11.5905 14.75 11.2505 14.41 11.2505 14V9ZM12.7105 17.71C12.6605 17.75 12.6105 17.79 12.5605 17.83C12.5005 17.87 12.4405 17.9 12.3805 17.92C12.3205 17.95 12.2605 17.97 12.1905 17.98C12.1305 17.99 12.0605 18 12.0005 18C11.9405 18 11.8705 17.99 11.8005 17.98C11.7405 17.97 11.6805 17.95 11.6205 17.92C11.5605 17.9 11.5005 17.87 11.4405 17.83C11.3905 17.79 11.3405 17.75 11.2905 17.71C11.1105 17.52 11.0005 17.26 11.0005 17C11.0005 16.74 11.1105 16.48 11.2905 16.29C11.3405 16.25 11.3905 16.21 11.4405 16.17C11.5005 16.13 11.5605 16.1 11.6205 16.08C11.6805 16.05 11.7405 16.03 11.8005 16.02C11.9305 15.99 12.0705 15.99 12.1905 16.02C12.2605 16.03 12.3205 16.05 12.3805 16.08C12.4405 16.1 12.5005 16.13 12.5605 16.17C12.6105 16.21 12.6605 16.25 12.7105 16.29C12.8905 16.48 13.0005 16.74 13.0005 17C13.0005 17.26 12.8905 17.52 12.7105 17.71Z" fill="currentcolor"></path> </g></svg>
                        @endif
                        <strong class="ms-3">{{Session::get('message')}}</strong>
                    </div>
                    @endif
                    <form class="row g-3" method="POST" action="{{ route('register.sekolah.store') }}">
                        @csrf
                        <div class="col-md-6">
                            <label class="form-label">NPSN</label>
                            <input  type="number" class="form-control @error('npsn') is-invalid @enderror" name="npsn" value="{{ old('npsn') }}" required placeholder="Masukkan NPSN Sekolah" autofocus>

                            @error('npsn')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Sekolah</label>
                            <input  type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan Nama Sekolah">

                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenjang</label>
                            <select  class="form-select @error('jenjang') is-invalid @enderror" name="jenjang" required="">
                               <option value="">Pilih Jenjang</option>
                               <option value="sma" @selected(old('jenjang') == 'sma')>SMA/Sederajat</option>
                               <option value="smp" @selected(old('jenjang') == 'smk')>SMP/Sederajat</option>
                               <option value="sd" @selected(old('jenjang') == 'siswa')>SD/Sederajat</option>
                            </select>
                            @error('jenjang')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                                      
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="number" name="telepon" class="form-control @error('telepon') is-invalid @enderror" placeholder="081XXXXX" value="{{ old('telepon') }}" required="">
                            @error('telepon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                           @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}" required="">
                            @error('alamat')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Provinsi Sekolah</label>
                            <select id="provinsiSelect" class="form-select @error('provinsi') is-invalid @enderror" name="provinsi" required="">
                            </select>
                            @error('provinsi')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                    
                        </div>
                        <div class="col-md-6" id="kotaField" @if(!$errors->has('kota')) style="display: none;" @endif>
                            <label class="form-label">Kabupaten/Kota Sekolah</label>
                            <select id="kotaSelect" class="form-select col @error('kota') is-invalid @enderror" name="kota" required="">
                            </select>
                            @error('kota')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                    
                        </div>
                        <div class="col-md-6" id="kecamatanField" @if(!$errors->has('kecamatan')) style="display: none;" @endif>
                            <label class="form-label">Kecamatan Sekolah</label>
                            <select id="kecamatanSelect" class="form-select @error('kecamatan') is-invalid @enderror" name="kecamatan" required="">
                            </select>
                            @error('kecamatan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                    
                        </div>
                        <div class="col-md-6" id="kelurahanField" @if(!$errors->has('kelurahan')) style="display: none;" @endif>
                            <label class="form-label">Kelurahan/Desa Sekolah</label>
                            <select id="kelurahanSelect" class="form-select @error('kelurahan') is-invalid @enderror" name="kelurahan" required="">
                            </select>
                            @error('kelurahan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                    
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Email</label>
                            <input  type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Masukkan email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input  type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Masukkan password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation" required placeholder="Masukkan ulang password">
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary w-100">
                                Daftar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.form-select').select2({
            width: '100%'
        });

       const provinsiSelect = document.getElementById('provinsiSelect')
       const provinsiField = document.getElementById('provinsiField')

       const kotaSelect = document.getElementById('kotaSelect')
       const kotaField = document.getElementById('kotaField')

       const kecamatanSelect = document.getElementById('kecamatanSelect')
       const kecamatanField = document.getElementById('kecamatanField')

       function toggleProvinsi(selected) {
          kelurahanSelect.innerHTML = ''
          kecamatanSelect.innerHTML = ''
          kotaSelect.innerHTML = ''

          kelurahanField.style.display = 'none';
          kecamatanField.style.display = 'none';
          kotaField.style.display = 'none';

          if (selected !== '') {
                const arrid = selected.split('-')
                getData(`https://ahmdsalim.github.io/api-wilayah-indonesia/api/regencies/${arrid[0]}.json`,kotaSelect)
                kotaField.style.display = 'block';
          }
       }

       function toggleKota(selected) {
          kelurahanSelect.innerHTML = ''
          kecamatanSelect.innerHTML = ''

          kelurahanField.style.display = 'none';
          kecamatanField.style.display = 'none';
           if (selected !== '') {
                const arrid = selected.split('-')
                getData(`https://ahmdsalim.github.io/api-wilayah-indonesia/api/districts/${arrid[0]}.json`,kecamatanSelect)
                kecamatanField.style.display = 'block';
          }
       }

       function toggleKecamatan(selected) {
          kelurahanSelect.innerHTML = ''

          kelurahanField.style.display = 'none';
           if (selected !== '') {
                const arrid = selected.split('-')
                getData(`https://ahmdsalim.github.io/api-wilayah-indonesia/api/villages/${arrid[0]}.json`,kelurahanSelect)
                kelurahanField.style.display = 'block';
          }
       }

       getData(`https://ahmdsalim.github.io/api-wilayah-indonesia/api/provinces.json`,provinsiSelect)

       $('#provinsiSelect').on('change', function() {
            toggleProvinsi(this.value);
        });

        $('#kotaSelect').on('change', function() {
            toggleKota(this.value);
        });

        $('#kecamatanSelect').on('change', function() {
            toggleKecamatan(this.value);
        });

       function getData(url,select) {
          fetch(url)
            .then(response => response.json())
            .then((data) => {
                var firstOpt = document.createElement('option')
                    firstOpt.value = ''
                    firstOpt.text = data.length > 0 ? 'Pilih' : 'Data tidak ditemukan'
                    select.appendChild(firstOpt)
                    if(data.length > 0){
                        data.forEach(function(item) {
                            var option = document.createElement('option')
                            option.value = `${item.id}-${item.name}`
                            option.text = item.name
                            select.appendChild(option)
                        })
                    }
            })
            .catch(function(err) {
                console.log(err)
            })
       }
    });
</script>
@endpush