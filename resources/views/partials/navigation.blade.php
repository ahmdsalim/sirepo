        <nav id="mainnav-container" class="mainnav">
            <div class="mainnav__inner">
                <!-- Navigation menu -->
                <div class="mainnav__top-content scrollable-content pb-5">
                    <!-- Profile Widget -->
                    <div class="mainnav__profile mt-3 d-flex3">
                        <div class="mt-2 d-mn-max"></div>
                        <!-- Profile picture  -->
                        <div class="mininav-toggle text-center py-2">
                            <img class="mainnav__avatar img-md rounded-circle border"
                                src="{{ asset('assets/img/profile-photos/1.png') }}" alt="Profile Picture">
                        </div>
                        <div class="mininav-content collapse d-mn-max">
                            <div class="d-grid">
                                <!-- User name and position -->
                                <button class="d-block btn shadow-none p-2" data-bs-toggle="collapse"
                                    data-bs-target="#usernav" aria-expanded="false" aria-controls="usernav">
                                    <span class="d-flex flex-column justify-content-center align-items-center">
                                        <h6 class="mb-0 mx-0">{{ Auth::user()->nama }}</h6>
                                        <label class="text-muted">{{ Auth::user()->role }}</label>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- End - Profile widget -->
                    <!-- Navigation Category -->
                    <div class="mainnav__categoriy py-3">
                        <h6 class="mainnav__caption mt-0 px-3 fw-bold">Navigasi</h6>
                        <ul class="mainnav__menu nav flex-column">
                            <!-- Link with submenu -->
                            <li class="nav-item">
                                @if (Auth::user()->role == 'owner')
                                    <a href="{{ route('home') }}"
                                        class="nav-link {{ str_contains(Route::current()->getName(), 'home') ? 'active' : '' }}">
                                    @else
                                        <a href="{{ route('home.sekolah') }}"
                                            class="nav-link {{ str_contains(Route::current()->getName(), 'home') ? 'active' : '' }}">
                                @endif
                                <i><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 36 36" style="margin-right : 4px;">
                                    <path fill="currentColor" d="m25.18 12.32l-5.91 5.81a3 3 0 1 0 1.41 1.42l5.92-5.81Z"
                                        class="clr-i-outline clr-i-outline-path-1" />
                                    <path fill="currentColor"
                                        d="M18 4.25A16.49 16.49 0 0 0 5.4 31.4l.3.35h24.6l.3-.35A16.49 16.49 0 0 0 18 4.25Zm11.34 25.5H6.66a14.43 14.43 0 0 1-3.11-7.84H7v-2H3.55A14.41 14.41 0 0 1 7 11.29l2.45 2.45l1.41-1.41l-2.43-2.46A14.41 14.41 0 0 1 17 6.29v3.5h2V6.3a14.47 14.47 0 0 1 13.4 13.61h-3.48v2h3.53a14.43 14.43 0 0 1-3.11 7.84Z"
                                        class="clr-i-outline clr-i-outline-path-2" />
                                    <path fill="none" d="M0 0h36v36H0z" />
                                </svg></i>
                                <span class="nav-label ms-1">Dashboard</span>
                                </a>
                            </li>
                            <!-- END : Link with submenu -->
                            <!-- Link with submenu -->
                            @if (Auth::check() && Auth::user()->role == 'owner')
                                <li class="nav-item has-sub">
                                    <a href="#"
                                        class="mininav-toggle nav-link collapsed {{ Request::is('kategori*') ? 'active' : '' }}">
                                        <i><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 256 256" style="margin-right:4px;">
                                            <path fill="currentColor"
                                                d="M192.14 42.55C174.94 33.17 152.16 28 128 28s-46.94 5.17-64.14 14.55C45.89 52.35 36 65.65 36 80v96c0 14.35 9.89 27.65 27.86 37.45c17.2 9.38 40 14.55 64.14 14.55s46.94-5.17 64.14-14.55c18-9.8 27.86-23.1 27.86-37.45V80c0-14.35-9.89-27.65-27.86-37.45ZM212 176c0 11.29-8.41 22.1-23.69 30.43C172.27 215.18 150.85 220 128 220s-44.27-4.82-60.31-13.57C52.41 198.1 44 187.29 44 176v-26.52c4.69 5.93 11.37 11.34 19.86 16c17.2 9.38 40 14.55 64.14 14.55s46.94-5.17 64.14-14.55c8.49-4.63 15.17-10 19.86-16Zm0-48c0 11.29-8.41 22.1-23.69 30.43C172.27 167.18 150.85 172 128 172s-44.27-4.82-60.31-13.57C52.41 150.1 44 139.29 44 128v-26.52c4.69 5.93 11.37 11.34 19.86 16c17.2 9.38 40 14.55 64.14 14.55s46.94-5.17 64.14-14.55c8.49-4.63 15.17-10 19.86-16Zm-23.69-17.57C172.27 119.18 150.85 124 128 124s-44.27-4.82-60.31-13.57C52.41 102.1 44 91.29 44 80s8.41-22.1 23.69-30.43C83.73 40.82 105.15 36 128 36s44.27 4.82 60.31 13.57C203.59 57.9 212 68.71 212 80s-8.41 22.1-23.69 30.43Z" />
                                        </svg></i>
                                        <span class="nav-label ms-1">Data Master</span>
                                    </a>
                                    <!-- Layouts submenu list -->
                                    <ul class="mininav-content nav collapse ">
                                        <li class="nav-item">
                                            <a href="{{ route('kategori.index') }}"
                                                class="nav-link {{ Request::is('kategori') ? 'active' : '' }}">Kategori</a>
                                        </li>
                                    </ul>
                                    <!-- END : Layouts submenu list -->
                                </li>
                            @endif
                            <!-- END : Link with submenu -->
                            @if (Auth::check() && Auth::user()->role == 'owner')
                                <li class="nav-item has-sub">
                                    <a href="#"
                                        class="mininav-toggle nav-link collapsed {{ str_contains(Route::current()->getName(), 'buku') ? 'active' : '' }}">
                                        <i><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 256 256">
                                            <path fill="currentColor"
                                                d="M208 24H72a32 32 0 0 0-32 32v168a8 8 0 0 0 8 8h144a8 8 0 0 0 0-16H56a16 16 0 0 1 16-16h136a8 8 0 0 0 8-8V32a8 8 0 0 0-8-8Zm-8 160H72a31.82 31.82 0 0 0-16 4.29V56a16 16 0 0 1 16-16h128Z" />
                                        </svg></i>

                                        <span class="nav-label ms-1">Buku</span>
                                    </a>
                                    <!-- Layouts submenu list -->
                                    <ul class="mininav-content nav collapse">
                                        <li class="nav-item">
                                            <a href="{{ route('buku.index') }}"
                                                class="nav-link {{ Request::is('buku*') ? 'active' : '' }}">Buku</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('buku.request') }}"
                                                class="nav-link {{ str_contains(Route::current()->getName(), 'request') ? 'active' : '' }}">Request
                                                Posting</a>
                                        </li>
                                    </ul>
                                    <!-- END : Layouts submenu list -->
                                </li>
                            @else
                                <!-- Regular menu link -->
                                <li class="nav-item">
                                    <a href="{{ route('buku.index') }}"
                                        class="nav-link mininav-toggle {{ str_contains(Route::current()->getName(), 'buku') ? 'active' : '' }}">
                                        <i><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 256 256">
                                            <path fill="currentColor"
                                                d="M208 24H72a32 32 0 0 0-32 32v168a8 8 0 0 0 8 8h144a8 8 0 0 0 0-16H56a16 16 0 0 1 16-16h136a8 8 0 0 0 8-8V32a8 8 0 0 0-8-8Zm-8 160H72a31.82 31.82 0 0 0-16 4.29V56a16 16 0 0 1 16-16h128Z" />
                                        </svg></i>
                                        <span class="nav-label mininav-content ms-1">Buku</span>
                                    </a>
                                </li>
                                <!-- END : Regular menu link -->
                            @endif
                            @if (Auth::check() && Auth::user()->role == 'owner' || Auth::user()->role == 'sekolah')
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}"
                                    class="nav-link mininav-toggle {{ str_contains(Route::current()->getName(), 'users') ? 'active' : '' }}">
                                    <i><svg fill="none" stroke="currentColor" stroke-width="1.5" width="18"
                                        height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true" style="margin-right: 4px;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z">
                                        </path>
                                    </svg></i>
                                    <span class="nav-label mininav-content ms-1">User</span>
                                </a>
                            </li>
                            @endif
                            @if (Auth::check() && Auth::user()->role == 'owner')
                                <li class="nav-item">
                                    <a href="{{ route('sekolah.index') }}"
                                        class="nav-link mininav-toggle {{ str_contains(Route::current()->getName(), 'sekolah') ? 'active' : '' }}">
                                        <i><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 512 512" style="margin-right: 4px;">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="32"
                                                d="M32 192L256 64l224 128l-224 128L32 192z" />
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="32"
                                                d="M112 240v128l144 80l144-80V240m80 128V192M256 320v128" />
                                        </svg></i>
                                        <span class="nav-label mininav-content ms-1">Sekolah</span>
                                    </a>
                                </li>
                            @endif
                            @if (Auth::check() && Auth::user()->role == 'sekolah')
                                <li class="nav-item">
                                    <a href="{{ route('sekolah.siswa.index') }}"
                                        class="nav-link mininav-toggle {{ str_contains(Route::current()->getName(), 'siswa') ? 'active' : '' }}">
                                        <i><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 512 512" style="margin-right: 4px;">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="32"
                                                d="M32 192L256 64l224 128l-224 128L32 192z" />
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="32"
                                                d="M112 240v128l144 80l144-80V240m80 128V192M256 320v128" />
                                        </svg></i>
                                        <span class="nav-label mininav-content ms-1">Siswa</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('sekolah.guru.index') }}"
                                        class="nav-link mininav-toggle {{ str_contains(Route::current()->getName(), 'guru') ? 'active' : '' }}">
                                        <i><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 512 512" style="margin-right: 4px;">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="32"
                                                d="M32 192L256 64l224 128l-224 128L32 192z" />
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="32"
                                                d="M112 240v128l144 80l144-80V240m80 128V192M256 320v128" />
                                        </svg></i>
                                        <span class="nav-label mininav-content ms-1">Guru</span>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ route('reader.index') }}"
                                    class="nav-link mininav-toggle {{ Request::is('list*') ? 'active' : '' }}">
                                    <i><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 256 256" style="margin-right: 4px;">
                                        <path fill="currentColor" stroke="currentColor" stroke-linecap="round"
                                            d="M247.31 124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57 61.26 162.88 48 128 48S61.43 61.26 36.34 86.35C17.51 105.18 9 124 8.69 124.76a8 8 0 0 0 0 6.5c.35.79 8.82 19.57 27.65 38.4C61.43 194.74 93.12 208 128 208s66.57-13.26 91.66-38.34c18.83-18.83 27.3-37.61 27.65-38.4a8 8 0 0 0 0-6.5ZM128 192c-30.78 0-57.67-11.19-79.93-33.25A133.47 133.47 0 0 1 25 128a133.33 133.33 0 0 1 23.07-30.75C70.33 75.19 97.22 64 128 64s57.67 11.19 79.93 33.25A133.46 133.46 0 0 1 231.05 128c-7.21 13.46-38.62 64-103.05 64Zm0-112a48 48 0 1 0 48 48a48.05 48.05 0 0 0-48-48Zm0 80a32 32 0 1 1 32-32a32 32 0 0 1-32 32Z" />
                                    </svg></i>
                                    <span class="nav-label mininav-content ms-1">Pembaca</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="javascript:void(0);" class="nav-link mininav-toggle"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="demo-pli-unlock fs-5 me-2"></i>
                                    <span class="nav-label mininav-content ms-1">Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </li>
                            <!-- END : Regular menu link -->
                        </ul>
                    </div>
                    <!-- END : Navigation Category -->
                </div>
                <!-- End - Navigation menu -->
                <!-- Bottom navigation menu -->
                <!-- End - Bottom navigation menu -->
            </div>
        </nav>
