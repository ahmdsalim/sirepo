@extends('layouts.appnifty')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
        <li class="breadcrumb-item active" aria-current="page">@if (isset($user)) Edit @else Tambah @endif User</li>
    </ol>
@endsection

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2">User</h1>
    <p class="lead">
        Manajemen User
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
                                <h5 class="card-title">@if (isset($user)) Edit @else Tambah @endif User</h5>
                                <!-- Block styled form -->
                                @if (isset($user))
                                <form class="row g-3" method="post" action="{{ route('users.update', $user->id) }}">
                                @method('PUT')
                                @else
                                <form class="row g-3" method="post" action="{{ route('users.store') }}">
                                @endif
                                @csrf
                                   <div class="col-12">
                                      <label class="form-label">Nama</label>
                                      <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama ?? '') }}" required="">
                                      @error('nama')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                   </div>
                                   <div class="col-md-6">
                                      <label class="form-label">Email</label>
                                      <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email ?? '') }}" required="">
                                      @error('email')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                   </div>
                                   <div class="col-md-6">
                                      <label class="form-label">Password</label>
                                      <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" @if(!isset($user))required=""@endif>
                                      @error('password')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                                      
                                   </div>
                                   <div class="col-md-4">
                                      <label for="inputState" class="form-label">Hak Akses</label>
                                      <select id="roleSelect" class="form-select @error('role') is-invalid @enderror" name="role" required="">
                                         <option value="">Pilih</option>
                                         <option value="owner" @selected(old('role', $user->role ?? '') == 'owner')>Owner</option>
                                         <option value="sekolah" @selected(old('role', $user->role ?? '') == 'sekolah')>Sekolah</option>
                                         <option value="siswa" @selected(old('role', $user->role ?? '') == 'siswa')>Siswa</option>
                                         <option value="guru" @selected(old('role', $user->role ?? '') == 'guru')>Guru</option>
                                      </select>
                                      @error('role')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                    
                                   </div>
                                   <div class="col-md-4">
                                      <label for="inputState" class="form-label">Status</label>
                                      <select class="form-select @error('active') is-invalid @enderror" name="active" required="">
                                         <option value="1" @selected(old('active', $user->active ?? '') == 1)>Active</option>
                                         <option value="0" @selected(old('active', $user->active ?? '') == 0)>Inactive</option>
                                      </select>
                                      @error('active')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                    
                                   </div>
                                   <div class="col-md-4" id="userField" @if(!$errors->has('userable')) style="display: none;" @endif>
                                      <label id="userLabel" class="form-label">User</label>
                                      <select id="userSelect" class="form-select @error('userable') is-invalid @enderror" name="userable">
                                      </select>
                                      @error('userable')
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
       const roleSelect = document.getElementById('roleSelect')
       const userField = document.getElementById('userField')
       const userSelect = document.getElementById('userSelect')
       const userLabel = document.getElementById('userLabel')
       @if(isset($user)) const prevRole = '{{ $user->role }}' @endif

       function toggleUserField(selected) {
           if (selected === 'sekolah') {
                getData('{{route("api.getSekolah")}}')
                userLabel.innerHTML = 'Sekolah'
                userSelect.setAttribute('required', '');
                userField.style.display = 'block';
          }else if(selected === 'siswa') {
                getData('{{route("api.getSiswa")}}')
                userLabel.innerHTML = 'Siswa'
                userSelect.setAttribute('required', '');
                userField.style.display = 'block';
          } else if(selected === 'guru') {
                getData('{{route("api.getGuru")}}')
                userLabel.innerHTML = 'Guru'
                userSelect.setAttribute('required', '');
                userField.style.display = 'block';
          } else {
                userSelect.removeAttribute('required');
                userSelect.innerHTML = ''
                userField.style.display = 'none';
          }
       }

       toggleUserField(roleSelect.value)

       roleSelect.addEventListener('change', function() {
          toggleUserField(this.value)
       });

       function getData(url) {
          axios.get(url)
                .then(function(response) {
                    var data = response.data

                    userSelect.innerHTML = ''
                    var firstOpt = document.createElement('option')
                        
                    @if(isset($user))
                
                        @if($user->role != 'owner')
                        if(roleSelect.value == prevRole){
                            firstOpt.value = "{{$user->userable_id}}"
                            firstOpt.text = "{{$user->userable->nama}} - {{$user->userable->id}}"
                            firstOpt.selected = true
                        } else {
                            firstOpt.value = ''
                            firstOpt.text = data.length > 0 ? 'Pilih' : 'Data tidak ditemukan'
                        }
                        @else
                        firstOpt.value = ''
                        firstOpt.text = data.length > 0 ? 'Pilih' : 'Data tidak ditemukan'
                        @endif
    
                    @else
                        firstOpt.value = ''
                        firstOpt.text = data.length > 0 ? 'Pilih' : 'Data tidak ditemukan'
                    @endif
                    userSelect.appendChild(firstOpt)
                    if(data.length > 0){
                        data.forEach(function(item) {
                            var option = document.createElement('option')
                            option.value = item.id
                            option.text = item.nama + ' - ' + item.id

                            userSelect.appendChild(option)
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
