@extends('layouts.appnifty')

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2">Error Import</h1>
    {{-- <p class="lead">
        A widget is an element of a graphical user interface that displays information or provides a specific way for a user
        to interact.
    </p> --}}
@endsection

@push('js')
    <script>
        document.getElementById("fileInput").addEventListener("change", function() {
            document.getElementById("importForm").submit();
        });
    </script>
@endpush

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row mt-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            @if (Auth::user()->role == 'sekolah' && str_contains(Route::current()->getName(), 'siswa'))
                                <a href="{{ route('sekolah.siswa.index') }}" type="button"
                                    class="btn btn-sm btn-primary">
                                @else
                                    <a href="{{ route('sekolah.guru.index') }}" type="button"
                                        class="btn btn-sm btn-primary">
                            @endif

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <g fill="none">
                                    <path
                                        d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z" />
                                    <path fill="currentColor"
                                        d="M3.636 11.293a1 1 0 0 0 0 1.414l5.657 5.657a1 1 0 0 0 1.414-1.414L6.757 13H20a1 1 0 1 0 0-2H6.757l3.95-3.95a1 1 0 0 0-1.414-1.414l-5.657 5.657Z" />
                                </g>
                            </svg></i> Kembali
                        </a>
                            @if (Auth::user()->role == 'siswa')
                                <form id="importForm" action="{{ route('siswa.import') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                @else
                                    <form id="importForm" action="{{ route('guru.import') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                            @endif
                            <input type="file" id="fileInput" name="file" accept=".xlsx" style="display: none;">
                            <label for="fileInput">
                                <div class="btn btn-secondary">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.5" width="18"
                                        height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
                                        </path>
                                    </svg>Import
                                </div>
                            </label>
                            </form>
                        </div>
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
                                                    <li>{{ $error }}</li>
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
        </div>
    </div>

@endsection
