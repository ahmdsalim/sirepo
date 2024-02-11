<x-app-layout title="Kelola Jenis">
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kelola Jenis</h3>
                <p class="text-subtitle text-muted">Jenis dokumen</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Jenis</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <form class="row" id="formJenis">
                    <div class="col-md-4 col-sm-12">
                        <div class="input-group">
                            <input class="form-control" type="text" name="nama_jenis" required="true" id="namajenis" placeholder="Jenis dokumen">
                            <button class="btn btn-primary" type="submit">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Data Jenis
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Jenis Dokumen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#198754" id="toastRect"></rect></svg>
                    <strong class="me-auto" id="toastType">Success</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body" id="toastMessage">
                    Berhasil menambahkan data jenis.
                </div>
            </div>
        </div>
    </section>

    @push('styles')
        @vite(['resources/assets/compiled/css/table-datatable-jquery.css','resources/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css'])
    @endpush

    @push('scripts')
        <script src="{{asset('assets/extensions/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function() {
                let datatable = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('jenis.getJenis') }}",
                        type: "POST",
                        data: function (data) {
                            data.search = $('input[type="search"]').val();
                        }
                    },
                    order: ['1', 'DESC'],
                    pageLength: 10,
                    searching: true,
                    aoColumns: [
                        {
                            data: 'nama_jenis',
                        },
                        {
                            data: 'id',
                            orderable: false,
                            width: "20%",
                            render: function(data, type, row) {
                                const editUrl = `{{ route('jenis.edit',['id' => ':data']) }}`
                                const bindEditUrl = editUrl.replace(':data', data)
                                return `<a class="btn btn-primary btn-sm" href="${bindEditUrl}">Edit</a>
                                    <button type="button" class="btn btn-danger text-white btn-sm delete-button" data-id="${data}" id="btnDelete">
                                        Hapus
                                    </button>`;
                            }
                        }
                    ]
                });

                const setTableColor = () => {
                    document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                        dt.classList.add('pagination-primary')
                    })
                }
                setTableColor()
                datatable.on('draw', setTableColor)

                const formJenis = document.getElementById('formJenis')
                formJenis.addEventListener("submit", (event) => {
                    let namajenis = $('#namajenis')
                    event.preventDefault()
                    let data = {
                        nama_jenis: namajenis.val()
                    }
                    $.ajax({
                        url: "{{ route('jenis.store') }}",
                        type: "POST",
                        data: JSON.stringify(data),
                        dataType: "JSON",
                        proccessData: false,
                        contentType: "application/json",
                        success: (response) => {
                            if(response.errors) {
                                var errorMsg = ''
                                $.each(response.errors, (field, errors) => {
                                    $.each(errors, (index, error) => {
                                        errorMsg += error + '<br>'
                                    })
                                })
                                toast("#dc3545","Failed",errorMsg)
                            }else{
                                refreshData(datatable)
                                toast()
                            }
                        },
                        error: function(xhr, status, error) {
                            toast("#dc3545","Failed",error)
                        }

                    })
                    namajenis.val('')
                })

                $('#datatable').on('click', '.delete-button', function() {
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Semua data yang berkaitan akan ikut terhapus",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#233446',
                        cancelButtonColor: '#8592a3',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.value) {
                            const dataId = $(this).data('id') 
                            const data = {
                                id: dataId
                            }
                            const url = "{{ route('jenis.destroy', ['id'=>':data']) }}"
                            const bindUrl = url.replace(':data', dataId)
                            $.ajax({
                                url: bindUrl,
                                type: "DELETE",
                                data: JSON.stringify(data),
                                dataType: "JSON",
                                proccessData: false,
                                contentType: "application/json",
                                success: (response) => {
                                    if(response.errors){
                                        var errorMsg = response.errors
                                        toast("#dc3545","Failed",errorMsg)
                                    }else{
                                        refreshData(datatable)
                                        toast(undefined,undefined,response.success)
                                    }
                                },
                                error: function(xhr, status, error) {
                                    toast("#dc3545","Failed",error)
                                }
                            })
                        }
                    })
                });
                
                function toast(color = "#198754", type = "Success", message = "Berhasil menambahkan data jenis") {
                    $("#toastRect").attr("fill",color)
                    $("#toastType").text(type)
                    $("#toastMessage").text(message) 
                    const toastContainer = $("#liveToast")
                    const toast = new bootstrap.Toast(toastContainer)
                    toast.show()
                }

                function refreshData(table) {
                    table.ajax.reload()
                }
            });

        </script>
    @endpush
</x-app-layout>