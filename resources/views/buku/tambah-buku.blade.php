@extends('layouts.appnifty')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('sekolah.index') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('buku.index') }}">Buku</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">{{ $header }}</a></li>
    </ol>
@endsection

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2">{{ $tittle }}</h1>
    {{-- <p class="lead">
        A widget is an element of a graphical user interface that displays information or provides a specific way for a user
        to interact.
    </p> --}}
@endsection

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

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <form action="{{ route('buku.store') }}" method="post" class="needs-validation" novalidate
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 col-sm-12 ">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="d-flex justify-content-center">
                                                <div class="p-2 m-2 ">
                                                    <div class="text-center">
                                                        <img id="thumbnail-preview" src="https://via.placeholder.com/400"
                                                            style="width:100px; height:120px;"
                                                            class="rounded object-fit-cover" alt="placeholder">
                                                    </div>
                                                </div>
                                            </div>
                                            <h5>Thumbnail</h5>
                                            <input type="file" name="thumbnail" class="form-control" accept="image/*"
                                                onchange="updatePreview(this, 'thumbnail-preview')">
                                            <small class="form-text text-muted">
                                                Ukuran thumbhnail harus 3x4
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-8 col-sm-12">
                        <div class="card">
                            {{-- <div class="card-header">
                            <h3>{{ $header }}</h3>
                        </div> --}}
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <address class="mb-4 mb-md-0">
                                            <h4 class="mb-1">Deskripsi</h4>
                                            <div class="col-12 mt-2">
                                                <textarea name="deskripsi" id="_dm-inputAddress" value="{{ old('deskripsi') }}" cols="5" rows="3" 
                                                    class="form-control 
                                                "></textarea>
                                            </div>
                                        </address>
                                    </div>
                                </div>
                                <div class="contaier">
                                    <h4>Detail</h4>
                                    <div class="d-flex flex-column gap-3">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address class="mb-4 mb-md-0">
                                                    <h5 class="mb-1">Judul</h5>
                                                    <div class="col-12 mt-2 ">
                                                        <input id="_dm-inputAddress" name="judul"
                                                            placeholder="Masukan Judul" value="{{ old('judul') }}"
                                                            class="form-control 
                                                        @error('judul')
                                                            is-invalid
                                                        @enderror">
                                                        @error('judul')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </address>
                                            </div>
                                            <div class="col-md-6 right">
                                                <address class="mb-4 mb-md-0">
                                                    <h5 class="mb-1">Pengarang</h5>
                                                    <div class="col-12 mt-2">
                                                        <input id="_dm-inputAddress" name="pengarang"
                                                            placeholder="Masukan pengarang" value="{{ old('pengarang') }}"
                                                            class="form-control 
                                                        @error('pengarang')
                                                            is-invalid
                                                        @enderror">
                                                        @error('pengarang')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </address>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address class="mb-4 mb-md-0">
                                                    <h5 class="mb-1">Kategori</h5>
                                                    <div class="col-12 mt-2">
                                                        <select
                                                            class="form-select
                                                                    @error('kategori_id')
                                                                        is-invalid
                                                                    @enderror"
                                                            name="kategori_id" id="category">
                                                            <option value="">Pilih Kategori</option>
                                                            @foreach ($kategori as $index => $kat)
                                                                <option value="{{ $kat->id }}">{{ $kat->kategori }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('kategori_id')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </address>
                                            </div>
                                            <div class="col-md-6 right">
                                                <address class="mb-4 mb-md-0">
                                                    <h5 class="mb-1">Penerbit</h5>
                                                    <div class="col-12 mt-2">
                                                        <input id="_dm-inputAddress" name="penerbit"
                                                            placeholder="Masukan penerbit" value="{{ old('penerbit') }}"
                                                            class="form-control 
                                                        @error('penerbit')
                                                            is-invalid
                                                        @enderror">
                                                        @error('penerbit')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </address>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address class="mb-4 mb-md-0">
                                                    <h5 class="mb-1">No ISBN</h5>
                                                    <div class="col-12 mt-2">
                                                        <input id="_dm-inputAddress" name="no_isbn" type="number"
                                                            placeholder="Masukan no isbn"
                                                            onkeydown="preventNegativeInput(event)"
                                                            value="{{ old('no_isbn') }}"
                                                            class="form-control 
                                                            @error('no_isbn')
                                                                is-invalid
                                                            @enderror">
                                                        @error('no_isbn')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </address>
                                            </div>
                                            <div class="col-md-6 right">
                                                <address class="mb-4 mb-md-0">
                                                    <h5 class="mb-1"></h5>
                                                    <h5 class="mb-1">Upload Buku</h5>
                                                    <div class="col-12 mt-2">
                                                        <input id="_dm-inputAddress" type="file" name="url_pdf"
                                                            placeholder="Masukan url pdf" accept="application/pdf"
                                                            value="{{ old('url_pdf') }}"
                                                            class="form-control 
                                                            @error('url_pdf')
                                                                is-invalid
                                                            @enderror">
                                                        @error('url_pdf')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </address>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address class="mb-4 mb-md-0">
                                                    <h5 class="mb-1">Tahun terbit</h5>
                                                    <div class="col-12 mt-2">
                                                        <input id="_dm-inputAddress" name="tahun_terbit"
                                                            placeholder="Masukan tahun terbit"
                                                            onkeydown="preventNegativeInput(event)"
                                                            value="{{ old('tahun_terbit') }}"
                                                            class="form-control 
                                                            @error('tahun_terbit')
                                                                is-invalid
                                                            @enderror">
                                                        @error('tahun_terbit')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </address>
                                            </div>
                                            <div class="col-md-6 right">
                                                <address class="mb-4 mb-md-0">
                                                    <h5 class="mb-1"></h5>

                                                </address>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 ">
                                    <div class="col-md-6 col-sm-12 mb-2 d-grid ">
                                        <a href="{{ route('buku.index') }}" class="btn btn-primary">Batal</a>
                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-2 d-grid">
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </form>

        </div>
        <!-- END : Basic card -->
    </div>
    </div>
@endsection
    @push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.form-select').select2({
                border : 'inline',
            });
        });
    </script>
    <script>
        function updatePreview(input, target) {
            let file = input.files[0];
            let reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = function() {
                let img = document.getElementById(target);
                // can also use "this.result"
                img.src = reader.result;
            }
        }

        function updateMultiPreview(inputId, targetContainer) {
            let input = document.getElementById(inputId);
            let images = input.files;
            let previewContainer = document.getElementById(targetContainer);
            previewContainer.innerHTML = ''; // Clear existing preview

            for (let i = 0; i < images.length; i++) {
                let reader = new FileReader();
                reader.readAsDataURL(images[i]);

                reader.onload = function() {
                    let imgContainer = document.createElement('div');
                    imgContainer.classList.add('d-flex', 'flex', 'align-middle', 'position-relative',
                        'mb-3'); // Add position relative class and margin bottom

                    let imgElement = document.createElement('img');
                    imgElement.src = reader.result;
                    imgElement.style.width = '70px'; // 

                    let fileName = document.createElement('p');
                    fileName.innerText = images[i].name; // Display file name

                    let cancelButton = document.createElement('button');
                    cancelButton.innerText = 'Cancel';
                    cancelButton.classList.add('btn', 'btn-danger', 'btn-sm', 'position-absolute', 'top-0',
                        'end-0'); // Add Bootstrap classes
                    cancelButton.addEventListener('click', function() {
                        previewContainer.removeChild(imgContainer); // Remove the image container
                    });

                    imgContainer.appendChild(imgElement);
                    imgContainer.appendChild(fileName);
                    imgContainer.appendChild(cancelButton);
                    previewContainer.appendChild(imgContainer);
                }
            }
        }
    </script>
    <script>
        function preventNegativeInput(event) {
            if (event.key === "-" || event.key === "e" || event.key === "E") {
                event.preventDefault();
            }
        }
    </script>
        
        
    @endpush

