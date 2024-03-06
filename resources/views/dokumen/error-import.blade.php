<x-app-layout title="Kelola Dokumens">
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Error Import Data Dokumens</h3>
                <p class="text-subtitle text-muted">Dokumens</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item text-decoration-none"><a class="text-decoration-none"
                                href="home">Dashboard</a></li>
                        <li class="breadcrumb-item text-decoration-none"><a class="text-decoration-none"
                                href="{{ route('dokumens.index') }}">Import</a></li>
                        <li class="breadcrumb-item" aria-current="page">Error</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">

        <div class="card">
            <div class="card-body">
                <div class="card-body" id="formContainerImportCSV">
                    <h6>Import Excel</h6>
                    <form id="importForm" action="{{ route('dokumens.import') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <input class="form-control mb-2" type="file" id="fileInput" required name="file"
                                accept=".xlsx">
                        </div>
                        <div class="col-12 d-flex justify-content-end gap-2">
                            <a href="{{ route('dokumens.index') }}" class="btn btn-primary" >Kembali</a>
                            <button type="sumbit" class="btn btn-success">Import</button>
                        </div>

                    </form>
                </div>
                <div class="card-body">

                @if (session()->has('failures'))
                            <table class="table table-warning">
                                <tr>
                                    <th>Baris</th>
                                    <th>Attribute</th>
                                    <th>Error</th>
                                    <th>Value</th>
                                </tr>
                                @php
                                    try {
                                @endphp
                                @foreach (session()->get('failures') as $validasi)
                                    <tr>
                                        <td>{{ $validasi->row() }}</td>
                                        <td>{{ $validasi->attribute() }}</td>
                                        <td>
                                            <ul>
                                                @foreach ($validasi->errors() as $error)
                                                    <li class="text-danger">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $validasi->values()[$validasi->attribute()] }}</td>
                                    </tr>
                                @endforeach
                                @php
                                    }catch(Exception $e){
                                        echo '<script>alert("Pastikan Format File Excel Sesuai Dengan Template.")</script>';
                                    }
                                @endphp
                            </table>
                        @endif
            </div>
            </div>
        </div>

    </section>
    @push('scripts')
        <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>

        <script>
            const toggleContainerImportCSV = document.getElementById('toggleContainerImportCSV')
            $('#toggleContainerImportCSV').click(function() {
                const formContainerImportCSV = $('#formContainerImportCSV')
                const toggleText = $('#toggleText')
                const toggleIcon = $('#toggleIcon')

                if (formContainerImportCSV.is(':visible')) {
                    formContainerImportCSV.hide(200)
                    toggleText.text('Tambah')
                    toggleIcon.removeClass('bi bi-chevron-compact-down')
                    toggleIcon.addClass('bi bi-chevron-compact-right')
                } else {
                    formContainerImportCSV.show(200)
                    toggleText.text('Sembunyikan')
                    toggleIcon.removeClass('bi bi-chevron-compact-right')
                    toggleIcon.addClass('bi bi-chevron-compact-down')
                }
            })
        </script>
    @endpush
</x-app-layout>
