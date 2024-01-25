@extends('layouts.appnifty')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('sekolah.index') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
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
                                <form action="{{ route('kategori.store') }}" method="post" class="needs-validation"
                                    novalidate enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-12">
                                        <label for="_dm-inputAddress" class="form-label">Kategori</label>
                                        <input id="_dm-inputAddress" name="kategori" type="text" placeholder="Masukan Kategori" autofocus  class="form-control 
                                        @error('kategori')
                                            is-invalid
                                        @enderror">
                                        @error('kategori')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="row mt-3 ">
                                        <div class="col-md-6 col-sm-12 mb-2 d-grid ">
                                            <a href="{{ route('kategori.index') }}" class="btn btn-primary">Batal</a>
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
    <script>
        /*
                                We want to preview images, so we need to register the Image Preview plugin
                                */
        FilePond.registerPlugin(

            // encodes the file as base64 data
            FilePondPluginFileEncode,

            // validates the size of the file
            FilePondPluginFileValidateSize,

            // corrects mobile image orientation
            FilePondPluginImageExifOrientation,

            // previews dropped images
            FilePondPluginImagePreview
        );

        // Select the file input and use create() to turn it into a pond
        FilePond.create(
            document.querySelector('input')
        );
    </script>
@endsection
