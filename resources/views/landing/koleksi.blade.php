@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 col-md-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-sm-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a class="text-decoration-none" href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Koleksi</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mb-3 ">
            <button onclick="history.back()" class="btn icon btn-md icon-left bg-white text-primary"><svg
                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 1024 1024">
                    <path fill="currentColor"
                        d="M685.248 104.704a64 64 0 0 1 0 90.496L368.448 512l316.8 316.8a64 64 0 0 1-90.496 90.496L232.704 557.248a64 64 0 0 1 0-90.496l362.048-362.048a64 64 0 0 1 90.496 0" />
                </svg> Kembali</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-2">Koleksi Dokumen</h6>
                    <hr class="mb-0">
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        @forelse ($koleksi as $kol)
                            <div class="row mx-2 ">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-11">
                                            <h4 class="pt-serif"><a
                                                    href="{{ route('landing.detail', $kol->dokumen->judul) }}">{{ $kol->dokumen->judul }}</a>
                                            </h4>
                                        </div>
                                        <div class="col-1">
                                            @if (auth()->check())
                                                <button onclick="toggleCollect(this)" type="sumbit" class="btn btn-lg"
                                                    data-id="{{ Crypt::encryptString($kol->dokumen->id) }}"
                                                    data-collected="{{ $kol->dokumen->collectedBy(auth()->user()) ? 'true' : 'false' }}"
                                                    data-baseurl="{{ url('') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                        fill="{{ $kol->dokumen->collectedBy(auth()->user()) ? '#face15' : 'none' }}"
                                                        viewBox="0 0 24 24" class="icon" style="color: #face15;">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m19 21-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16Z"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="m-0">{{ $kol->dokumen->penulis }}</p>
                                    <p>{{ $kol->dokumen->tahun . ' | ' . $kol->dokumen->jenis->nama_jenis }}</p>
                                    <hr class="my-2">
                                </div>
                            </div>
                        @empty
                            <p>Tidak ada koleksi</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        async function toggleCollect(el) {
            var btn = el
            const collectionIcon = btn.childNodes
            const docId = btn.getAttribute('data-id')
            const baseUrl = btn.getAttribute('data-baseurl')
            const collected = btn.getAttribute('data-collected') === 'true'

            const url = collected ? `${baseUrl}/api/collection/uncollect` : `${baseUrl}/api/collection/collect`;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await axios.post(url, {
                    id: docId
                }, {
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });

                const data = response.data;

                if (data.message === 'collected' || data.message === 'uncollected') {
                    collectionIcon[1].style.fill = collected ? 'none' :
                        '#face15' // Menggunakan css() untuk mengatur fill
                    btn.setAttribute('data-collected', collected ? 'false' :
                        'true') // Menggunakan $(this) untuk mengakses tombol
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    </script>
@endpush
