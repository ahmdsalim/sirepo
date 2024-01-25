@extends('layouts.appnifty')
@push('css')
<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
@endpush
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
        <li class="breadcrumb-item active" aria-current="page">@if (isset($sekolah)) Edit @else Tambah @endif Sekolah</li>
    </ol>
@endsection

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2">Sekolah</h1>
    <p class="lead">
        Manajemen Sekolah
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
                                <h5 class="card-title">@if (isset($sekolah)) Edit @else Tambah @endif Sekolah</h5>
                                <!-- Block styled form -->
                                @if (isset($sekolah))
                                <form class="row g-3" method="post" action="{{ route('sekolah.update', $sekolah->id) }}">
                                @method('PUT')
                                @else
                                <form class="row g-3" method="post" action="{{ route('sekolah.store') }}">
                                @endif
                                @csrf
                                   <div class="col-md-6">
                                      <label class="form-label">Nama Sekolah</label>
                                      <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $sekolah->nama ?? '') }}" required="">
                                      @error('nama')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                   </div>
                                   <div class="col-md-6">
                                      <label class="form-label">NPSN</label>
                                      <input type="number" class="form-control @error('npsn') is-invalid @enderror" name="npsn" value="{{ old('npsn', $sekolah->npsn ?? '') }}" required="">
                                      @error('npsn')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                   </div>
                                   <div class="col-md-6">
                                      <label class="form-label">Jenjang</label>
                                      <select  class="form-select @error('jenjang') is-invalid @enderror" name="jenjang" required="">
                                         <option value="">Pilih</option>
                                         <option value="sma" @selected(old('jenjang', $sekolah->jenjang ?? '') == 'sma')>SMA/Sederajat</option>
                                         <option value="smp" @selected(old('jenjang', $sekolah->jenjang ?? '') == 'smk')>SMP/Sederajat</option>
                                         <option value="sd" @selected(old('jenjang', $sekolah->jenjang ?? '') == 'siswa')>SD/Sederajat</option>
                                      </select>
                                      @error('jenjang')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                                      
                                   </div>
                                   <div class="col-6">
                                      <label class="form-label">Nomor Telepon</label>
                                      <input type="number" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $sekolah->telepon ?? '') }}" required="">
                                      @error('telepon')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                   </div>
                                   <div class="col-12">
                                      <label class="form-label">Alamat</label>
                                      <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat', $sekolah->alamat ?? '') }}" required="">
                                      @error('alamat')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                   </div>
                                   <div class="col-md-6">
                                      <label class="form-label">Provinsi</label>
                                      <select id="provinsiSelect" class="form-select @error('provinsi') is-invalid @enderror" name="provinsi" data-id="" required="">
                                        <option value="">Pilih</option>
                                        @if(isset($provinsi))
                                        @foreach($provinsi as $prov)
                                        <option value="{{$prov['id'].'-'.$prov['name']}}" @selected(old('provinsi', explode('-',$sekolah->provinsi) ?? '')[0] == $prov['id'])>{{$prov['name']}}</option>
                                        @endforeach
                                        @endif
                                      </select>
                                      @error('provinsi')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                    
                                   </div>
                                   <div class="col-md-6" id="kotaField" @if($errors->has('kota') || isset($sekolah)) style="display: block;" @else style="display: none;" @endif>
                                      <label class="form-label">Kabupaten/Kota</label>
                                      <select id="kotaSelect" class="form-select @error('kota') is-invalid @enderror" name="kota" required="">
                                        @if(isset($kota))
                                        @foreach($kota as $kot)
                                        <option value="{{$kot['id'].'-'.$kot['name']}}" @selected(old('kota', explode('-',$sekolah->kota) ?? '')[0] == $kot['id'])>{{$kot['name']}}</option>
                                        @endforeach
                                        @endif
                                      </select>
                                      @error('kota')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                    
                                   </div>
                                   <div class="col-md-6" id="kecamatanField" @if($errors->has('kecamatan') || isset($sekolah)) style="display: block;" @else style="display: none;" @endif>
                                      <label class="form-label">Kecamatan</label>
                                      <select id="kecamatanSelect" class="form-select @error('kecamatan') is-invalid @enderror" name="kecamatan" required="">
                                        @if(isset($kecamatan))
                                        @foreach($kecamatan as $kec)
                                        <option value="{{$kec['id'].'-'.$kec['name']}}" @selected(old('kecamaatan', explode('-',$sekolah->kecamaatan) ?? '')[0] == $kec['id'])>{{$kec['name']}}</option>
                                        @endforeach
                                        @endif
                                      </select>
                                      @error('kecamatan')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                    
                                   </div>
                                   <div class="col-md-6" id="kelurahanField" @if($errors->has('kelurahan') || isset($sekolah)) style="display: block;" @else style="display: none;" @endif>
                                      <label class="form-label">Kelurahan/Desa</label>
                                      <select id="kelurahanSelect" class="form-select @error('kelurahan') is-invalid @enderror" name="kelurahan" required="">
                                        @if(isset($kelurahan))
                                        @foreach($kelurahan as $kel)
                                        <option value="{{$kel['id'].'-'.$kel['name']}}" @selected(old('kelurahan', explode('-',$sekolah->kelurahan) ?? '')[0] == $kel['id'])>{{$kel['name']}}</option>
                                        @endforeach
                                        @endif
                                      </select>
                                      @error('kelurahan')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                    
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

@push('js')
<script>
   document.addEventListener('DOMContentLoaded', function() {
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

       @if(!isset($sekolah))
       getData(`https://ahmdsalim.github.io/api-wilayah-indonesia/api/provinces.json`,provinsiSelect)
       @endif

       provinsiSelect.addEventListener('change', function() {
          toggleProvinsi(this.value)
       });

       kotaSelect.addEventListener('change', function() {
          toggleKota(this.value)
       });

       kecamatanSelect.addEventListener('change', function() {
          toggleKecamatan(this.value)
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
   })
</script>
@endpush
