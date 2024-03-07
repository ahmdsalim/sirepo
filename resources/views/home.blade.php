<x-app-layout title="Dashboard">
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Dashboard</h3>
                <p class="text-subtitle text-muted">Anda login sebagai {{ ucfirst(Auth::user()->role) }}@if (Auth::user()->kode_prodi)
                        dari Prodi
                        {{ Auth::user()->prodi->nama_prodi }}
                    @endif
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                @if (auth()->user()->role == 'super')
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="bi-people-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Users</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalUser }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="bi-person-fill-check"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Approved</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalApproved }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="bi-person-fill-up"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Moderation</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalModeration }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->role == 'super')
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-2">
                                            <i class="bi-file-pdf-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Dok. Penelitian</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalDocument }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Stats Dok. Penelitian {{ date('Y') }}</h4>
                        </div>
                        <div class="card-body">
                            <div id="chart-document" style="min-height: 315px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-4">
                    <div class="d-flex align-items-center">
                        <div class="ms-3 name">
                            <h5 class="fw-bold">{{ Auth::user()->nama }}</h5>
                            <small class="text-muted mb-0">{{ Auth::user()->email }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @if (auth()->user()->role == 'admin')
                <div class="card">
                    <div class="card-body px-4 py-4-5">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon red mb-2">
                                    <i class="bi-file-pdf-fill"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Dok. Penelitian</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalDocument }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4>Jenis Dokumen</h4>
                </div>
                <div class="card-body">
                    <div id="chart-jenis" style="min-height: 187.7px;"></div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            var options = {
                series: [{
                    name: "Dok. Penelitian",
                    data: @json($dataTotalDoc)
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: true
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: @json($dataBulan),
                },
                yaxis: {
                    labels: {
                        formatter: (value) => {
                            return value;
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart-document"), options);
            chart.render();
        </script>
        <script>
            var dataJenis = {!! json_encode($dataJenis) !!}
            var seriesJenis
            var labelsJenis = dataJenis.map((item) => Object.keys(item)[0])
            var allZeros = dataJenis.every(item => Object.values(item)[0] === 0)
            seriesJenis = allZeros ? [] : dataJenis.map((item) => Object.values(item)[0])
            var optionsJenis = {
                series: seriesJenis,
                chart: {
                    type: "pie",
                    width: "100%",
                    height: "250px",
                },
                labels: labelsJenis,
                legend: {
                    position: "bottom",
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "30%",
                        },
                    },
                },
                noData: {
                    text: "No data",
                    align: "center",
                    verticalAlign: "middle",
                    offsetY: -45,
                },
            };

            var chartJenis = new ApexCharts(document.querySelector("#chart-jenis"), optionsJenis);
            chartJenis.render();
        </script>
    @endpush
</x-app-layout>
