@extends('landing.setting.sidebar')

@section('setting')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Ubah Password</h5>
        </div>
        <div class="card-body">
            <form id="formSecurity">
                <div class="form-group mandatory my-2">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control"
                        autocomplete="current_password" placeholder="Password saat ini">
                </div>
                <div class="form-group mandatory my-2">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" name="password" id="password" class="form-control" autocomplete="password"
                        placeholder="Password baru">
                </div>
                <div class="form-group mandatory my-2">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="password"
                        class="form-control" placeholder="Konfirmasi password">
                </div>

                <div class="form-group my-2 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            const formSecurity = document.getElementById('formSecurity')
            formSecurity.addEventListener("submit", (event) => {
                event.preventDefault()
                //Clear error message
                $('.invalid-feedback').remove()
                $('.is-invalid').removeClass('is-invalid')
                //Prepare input element
                let current_password = $('#current_password'),
                    password = $('#password'),
                    password_confirmation = $('#password_confirmation')
                //Data for sending to server    
                let data = {
                    current_password: current_password.val(),
                    password: password.val(),
                    password_confirmation: password_confirmation.val()
                }
                $.ajax({
                    url: "{{ route('security.update') }}",
                    type: "POST",
                    data: JSON.stringify(data),
                    dataType: "JSON",
                    proccessData: false,
                    contentType: "application/json",
                    success: (response) => {
                        if (response.success) {
                            current_password.val('')
                            password.val('')
                            password_confirmation.val('')
                            toast(undefined, undefined, response.success)
                        }
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;

                        if (errors.hasOwnProperty('current_password')) {
                            current_password.addClass('is-invalid')
                            current_password.after(
                                `<span class="invalid-feedback" role="alert">${errors.current_password[0]}</span>`
                                )
                        }
                        if (errors.hasOwnProperty('password')) {
                            password.addClass('is-invalid')
                            password.after(
                                `<span class="invalid-feedback" role="alert">${errors.password[0]}</span>`
                                )
                        }
                        if (errors.hasOwnProperty('password_confirmation')) {
                            password_confirmation.addClass('is-invalid')
                            password_confirmation.after(
                                `<span class="invalid-feedback" role="alert">${errors.password_confirmation[0]}</span>`
                                )
                        }
                        toast("#dc3545", "Failed", "Gagal mengupdate password")
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
