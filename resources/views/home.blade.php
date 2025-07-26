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
                                        <h6 class="text-muted font-semibold">User Mhs/Mhs</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalUser }}/{{ $totalMahasiswa }}</h6>
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
                                        <h6 class="text-muted font-semibold">Staff/Dosen</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalAdmin }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (auth()->user()->role === 'admin')
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="bi-mortarboard-fill"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Mahasiswa</h6>
                                        <h6 class="font-extrabold mb-0">{{ $totalMahasiswa }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-6 col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                    <div class="stats-icon green mb-2">
                                        <i class="bi-file-earmark-arrow-down-fill"></i>
                                    </div>
                                </div>
                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                    <h6 class="text-muted font-semibold">Diunduh</h6>
                                    <h6 class="font-extrabold mb-0">{{ $totalUnduhan }}</h6>
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
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Total unduhan 7 hari terakhir</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chart-unduhan">
                            </canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Stats Dok. Penelitian {{ date('Y') }}</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chart-document">
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body py-4 px-4">
                    <h6 class="fw-bold">{{ Auth::user()->nama }}</h6>
                    <p class="small text-muted mb-0">{{ Auth::user()->email }}</p>
                </div>
            </div>
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
        <script>
            const ctx = document.getElementById('chart-document');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($dataBulan),
                    datasets: [{
                        label: 'Total Doc. Penelitian',
                        data: @json($dataTotalDoc),
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            ticks: {
                                callback: function(value, index, ticks) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                }
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <script>
            const cty = document.getElementById('chart-unduhan');

            new Chart(cty, {
                type: 'line',
                data: {
                    labels: @json($dataTanggal),
                    datasets: [{
                        label: 'Total Unduhan',
                        data: @json($dataTotalDownload),
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    return moment(context.parsed).format('DD/MM/YY');
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                callback: function(value, index, ticks) {
                                    return moment(this.getLabelForValue(value)).format('D MMM');
                                }
                            }
                        },
                        y: {
                            ticks: {
                                callback: function(value, index, ticks) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                }
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
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
