@extends('layouts.appnifty')

@section('content')
    <div class="content__boxed">
                <div class="content__wrap">
                    <div class="card">
                        <div class="card-body">
                            <div class="flex-fill min-w-0">
                                    <div class="d-md-flex align-items-center border-bottom pb-3 mb-3">
                                        <h3>Semua Notifikasi</h3>
                                    </div>

                                    <!-- Mail list -->
                                    @php
                                        $notifikasi = auth()->user()->notifikasi()->latest()->paginate(10);
                                    @endphp
                                    @foreach($notifikasi as $notif)
                                    <div class="list-group list-group-borderless gap-1 mb-3">
                                        <div class="list-group-item list-group-item-action {{ $notif->is_read ? '' : 'list-group-item-info' }} d-flex align-items-center">

                                            <!-- Checkbox and star button -->
                                            <div class="d-flex flex-column flex-md-row flex-shrink-0 gap-3 align-items-center">
                                                <a href="{{ route('inbox.destroy',Crypt::encryptString($notif->id)) }}" class="text-decoration-none text-light">
                                                    <svg fill="none"
                                                        stroke="black" stroke-width="1.5"
                                                        width="18" height="18" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        aria-hidden="true">
                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </div>
                                            <!-- END : Checkbox and star button -->

                                            <div class="flex-fill min-w-0 ms-3 ms-lg-5">
                                                <div class="d-flex flex-wrap flex-xl-nowrap align-items-xl-center">

                                                    <!-- Mail sender -->
                                                    <div class="w-md-200px flex-shrink-0">
                                                        <a href="{{ route('inbox.show', Crypt::encryptString($notif->id)) }}" class="text-dark fw-semibold m-0 text-decoration-none">{{ $notif->title }}</a>
                                                    </div>
                                                    <!-- END : Mail sender -->

                                                    <!-- Date and attachment icon -->
                                                    <div class="flex-shrink-0 ms-auto order-xl-3">
                                                        @php \Carbon\Carbon::setLocale('id'); @endphp
                                                        <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <!-- END : Date and attachment icon -->

                                                    <!-- Mail subject -->
                                                    <div class="flex-fill w-100 min-w-0 mt-2 mt-xl-0 mx-xl-3 order-xl-2">
                                                        <a href="{{ route('inbox.show', Crypt::encryptString($notif->id)) }}" class="d-block text-dark fw-normal m-0 text-decoration-none text-truncate">
                                                            {{ $notif->body }}
                                                        </a>
                                                    </div>
                                                    <!-- END : Mail subject -->

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    @endforeach
                                    <!-- Mail list -->

                                    <div class="d-flex align-items-center justify-content-end border-top pt-3 text-center">
                                        {{ $notifikasi->links() }}
                                    </div>
                                </div>

                        </div>
                    </div>

                </div>
            </div>

@endsection