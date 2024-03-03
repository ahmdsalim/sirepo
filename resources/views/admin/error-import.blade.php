<x-app-layout title="Kelola Mahasiswa">
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Error Import Data Mahasiswa</h3>
                <p class="text-subtitle text-muted">Mahasiswa</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item text-decoration-none"><a class="text-decoration-none"
                                href="home">Dashboard</a></li>
                        <li class="breadcrumb-item text-decoration-none"><a class="text-decoration-none"
                                href="{{ route('mahasiswas.index') }}">Import</a></li>
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
                    <form id="importForm" action="{{ route('mahasiswas.import') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <input class="form-control mb-2" type="file" id="fileInput" required name="file"
                                accept=".xlsx">
                        </div>
                        <div class="col-12 d-flex justify-content-end ">
                            <button type="sumbit" class="btn btn-primary">Import</button>
                        </div>

                    </form>
                </div>

                @if (session()->has('failures'))
                    <table class="table table-warning ">
                        <tr>
                            <th>Baris</th>
                            <th>Attribute</th>
                            <th>Error</th>
                            <th>Value</th>
                        </tr>
                        @foreach (session()->get('failures') as $validasi)
                            <tr>
                                <td>{{ $validasi->row() }}</td>
                                <td>{{ $validasi->attribute() }}</td>
                                <td>
                                    <ul class="text-danger">
                                        @foreach ($validasi->errors() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $validasi->values()[$validasi->attribute()] }}</td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <h5 class="text-center">Tidak ada error</h5>
                @endif
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