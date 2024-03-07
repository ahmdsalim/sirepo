<x-app-layout title="Profile">
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Profile</h3>
                <p class="text-subtitle text-muted">Kelola Profile</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <h4 class="mt-3" id="profileName">{{ $user->nama }}</h4>
                            <p class="text-small">{{ ucfirst($user->role) }}
                                @if ($user->kode_prodi)
                                    {{ ' - ' . $user->kode_prodi }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form id="formProfile">
                            <div class="form-group mandatory">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    placeholder="Nama pengguna" value="{{ $user->nama }}" required>
                            </div>
                            <div class="form-group mandatory">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email" id="email" class="form-control"
                                    placeholder="Email pengguna" value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="btnUpdate">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <svg class="bd-placeholder-img rounded me-2" width="20" height="20"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice"
                        focusable="false">
                        <rect width="100%" height="100%" fill="#198754" id="toastRect"></rect>
                    </svg>
                    <strong class="me-auto" id="toastType">Success</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body" id="toastMessage">
                    Berhasil mengubah data.
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function() {
                const formProfile = document.getElementById('formProfile')
                formProfile.addEventListener("submit", (event) => {
                    event.preventDefault()
                    //Clear error message
                    $('.invalid-feedback').remove()
                    $('.is-invalid').removeClass('is-invalid')
                    //Prepare input element
                    let nama = $('#nama'),
                        email = $('#email')
                    //Data for sending to server    
                    let data = {
                        nama: nama.val(),
                        email: email.val()
                    }
                    var btn = $('#btnUpdate')
                    $.ajax({
                        url: "{{ route('profile.update') }}",
                        type: "POST",
                        data: JSON.stringify(data),
                        dataType: "JSON",
                        proccessData: false,
                        contentType: "application/json",
                        beforeSend: () => {
                            btn.attr('disabled', true).html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                            )
                        },
                        success: (response) => {
                            if (response.success) {
                                $('#profileName').text(response.data.nama)
                                toast(undefined, undefined, response.success)
                            }
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;

                            if (errors.hasOwnProperty('nama')) {
                                nama.addClass('is-invalid')
                                nama.after(
                                    `<span class="invalid-feedback" role="alert">${errors.nama[0]}</span>`
                                )
                            }
                            if (errors.hasOwnProperty('email')) {
                                email.addClass('is-invalid')
                                email.after(
                                    `<span class="invalid-feedback" role="alert">${errors.email[0]}</span>`
                                )
                            }
                            toast("#dc3545", "Failed", "Gagal mengupdate profile")
                        },
                        complete: () => {
                            $('#btnUpdate').removeAttr('disabled').text('Submit')
                        }

                    })
                })

                function toast(color = "#198754", type = "Success", message = "Berhasil menambahkan data jenis") {
                    $("#toastRect").attr("fill", color)
                    $("#toastType").text(type)
                    $("#toastMessage").text(message)
                    const toastContainer = $("#liveToast")
                    const toast = new bootstrap.Toast(toastContainer)
                    toast.show()
                }
            });
        </script>
    @endpush
</x-app-layout>
