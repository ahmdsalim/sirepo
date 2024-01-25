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
<style>

</style>

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <section>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $header }}</h5>
                                <!-- Block styled form -->
                                <form class="row g-3" action="{{ route('buku.store') }}" method="post" class="needs-validation" novalidate>
                                    @csrf>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <div class="p-2 m-2 ">
                                                    <div class="text-center">
                                                        <img id="image-preview" src="https://via.placeholder.com/400"
                                                            style="width:100px" class="rounded rounded-circle"
                                                            alt="placeholder">
                                                    </div>
                                                </div>
                                            </div>
                                            <label>Foto</label>
                                            <input type="file" name="foto" class="form-control" accept="image/*"
                                                onchange="updatePreview(this, 'image-preview')">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="kategori" class="form-label">Kategori</label>
                                        <select id="kategori" name="kategori" id="" class="form-control">
                                            <option value="">Pilih Kategori</option>
                                            <option value="">Elektronik</option>
                                            <option value="">Novel</option>
                                            <option value="">Sains</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="_dm-inputAddress" class="form-label">Judul Buku</label>
                                        <input id="_dm-inputAddress" name="judul" type="text" class="form-control"
                                            placeholder="Masukan Judul Buku">
                                    </div>
                                    <div class="col-12">
                                        <label for="_dm-inputAddress" class="form-label">Pengarang</label>
                                        <input id="_dm-inputAddress" name="pengarang" type="text" class="form-control"
                                            placeholder="Masukan Pengarang">
                                    </div>
                                    <div class="col-12">
                                        <label for="_dm-inputAddress" class="form-label">Penerbit</label>
                                        <input id="_dm-inputAddress" name="penerbit" type="text" class="form-control"
                                            placeholder="Masukan Penerbit">
                                    </div>
                                    <div class="col-12">
                                        <label for="_dm-inputAddress" class="form-label">Tahun Terbit</label>
                                        <input id="_dm-inputAddress" name="tahun_terbit" type="number" class="form-control" onkeydown="preventNegativeInput(event)"
                                            placeholder="Masukan Tahun Terbit">
                                    </div>
                                    <div class="col-12">
                                        <label for="_dm-inputAddress" class="form-label">No ISBN</label>
                                        <input id="_dm-inputAddress" name="no_isbn" type="text" class="form-control"
                                            placeholder="Masukan No ISBN">
                                    </div>
                                    <div class="col-12">
                                        <label for="_dm-inputAddress" class="form-label">Jumlah Halaman</label>
                                        <input id="_dm-inputAddress" name="jumlah_halaman" type="number" onkeydown="preventNegativeInput(event)"
                                            class="form-control" placeholder="Masukan Jumlah Halaman">
                                    </div>
                                    <div class="col-12">
                                        <label for="_dm-inputAddress" class="form-label">URL PDF</label>
                                        <input id="_dm-inputAddress" name="url_pdf" type="text" 
                                            class="form-control" placeholder="Masukan URL PDF">
                                    </div>
                                    <div class="row mt-3 ">
                                        <div class="col-md-6 col-sm-12 mb-2 d-grid ">
                                            <a href="{{ route('buku.index') }}" class="btn btn-primary">Batal</a>
                                        </div>
                                        <div class="col-md-6 col-sm-12 mb-2 d-grid">
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </div>
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
    </script>
    <script>
        function preventNegativeInput(event) {
            if (event.key === "-" || event.key === "e" || event.key === "E") {
                event.preventDefault();
            }
        }
    </script>
@endsection
