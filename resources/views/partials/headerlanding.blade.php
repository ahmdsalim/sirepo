<header class="header sticky-top shadow-sm">
   <div class="header__inner">
      <!-- Brand -->
      <div class="header__brand">
         <div class="brand-wrap">
                        <a href="/" class="brand-img stretched-link">
            <img src="{{asset('assets/img/app-logo-sample.png')}}" alt="Logo" class="logo" width="40" height="40">
            </a>
            <!-- Brand title -->
            <div class="brand-title">{{ env('APP_NAME') }}</div>
            <!-- You can also use IMG or SVG instead of a text element. -->
         </div>
      </div>
      <!-- End - Brand -->
      <div class="header__content">
         <!-- Content Header - Left Side: --> 
         <div class="header__content-start">
            <!-- Navigation Toggler -->
            <div class="header-searchbox">
               <!-- Searchbox toggler for small devices -->
                @if(request()->route()->getName() != 'pembaca.profile' && request()->route()->getName() != 'pembaca.changepassword.show' && request()->route()->getName() != 'koleksi' && request()->route()->getName() != 'buku.detailbuku' && request()->route()->getName() != 'daftarbacaan')
               <label for="header-search-input" class="header__btn d-md-none btn btn-icon rounded-pill shadow-none border-0 btn-sm" type="button">
               <i class="demo-psi-magnifi-glass"></i>
               </label>
               @endif
                  @if(request()->route()->getName() != 'pembaca.profile' && request()->route()->getName() != 'pembaca.changepassword.show' && request()->route()->getName() != 'koleksi' && request()->route()->getName() != 'buku.detailbuku' && request()->route()->getName() != 'daftarbacaan')                 
                  <form action="{{ route('book.search') }}" method="GET" class="searchbox searchbox--auto-expand searchbox--hide-btn input-group">
                  <input id="header-search-input" class="searchbox__input form-control bg-transparent" name="keyword" type="search" placeholder="Cari ..." aria-label="Search">
                  <div class="searchbox__backdrop">
                     <button class="searchbox__btn header__btn btn btn-icon rounded shadow-none border-0 btn-sm" type="button" id="button-addon2">
                     <i class="demo-pli-magnifi-glass"></i>
                     </button>
                  </div>
               </form>
               @endif
            </div>
         </div>
         <!-- End - Content Header - Left Side -->
         <!-- Content Header - Right Side: -->
         <div class="header__content-end">
           @if(isAuth())
            <div class="dropdown">
               <!-- Toggler -->
               <button class="header__btn btn btn-icon btn-sm" type="button" data-bs-toggle="dropdown" aria-label="User dropdown" aria-expanded="false">
               <i class="demo-psi-male"></i>
               </button>
               <!-- User dropdown menu -->
               <div class="dropdown-menu dropdown-menu-end w-md-250px">
                  <!-- User dropdown header -->
                  <div class="d-flex align-items-center border-bottom px-3 py-2">
                     <div class="flex-shrink-0">
                        <img class="img-sm rounded-circle" src="{{asset('assets/img/profile-photos/1.png')}}" alt="Profile Picture" loading="lazy">
                     </div>
                        @if(isAuth())
                     <div class="flex-grow-1 ms-3">
                        <h5 class="mb-0">{{Auth::user()->nama}}</h5>
                        <span class="text-muted fst-italic">{{ucfirst(Auth::user()->role)}}</span>
                     </div>
                        @endif 
                  </div>
                  <div class="row">
                     <div class="col-md-12">
                        <!-- User menu link -->
                        <div class="list-group list-group-borderless h-100 py-3">
                           <a href="{{route('pembaca.profile')}}" class="list-group-item list-group-item-action">
                           <i class="demo-pli-male fs-5 me-2"></i> Profile
                           </a>
                           <a href="{{route('pembaca.changepassword.show')}}" class="list-group-item list-group-item-action">
                           <svg xmlns="http://www.w3.org/2000/svg" class="fs-5 me-2" width="15" height="15" viewBox="0 0 24 24" fill="none">
                           <path d="M15.6807 14.5869C19.1708 14.5869 22 11.7692 22 8.29344C22 4.81767 19.1708 2 15.6807 2C12.1907 2 9.3615 4.81767 9.3615 8.29344C9.3615 9.90338 10.0963 11.0743 10.0963 11.0743L2.45441 18.6849C2.1115 19.0264 1.63143 19.9143 2.45441 20.7339L3.33616 21.6121C3.67905 21.9048 4.54119 22.3146 5.2466 21.6121L6.27531 20.5876C7.30403 21.6121 8.4797 21.0267 8.92058 20.4412C9.65538 19.4167 8.77362 18.3922 8.77362 18.3922L9.06754 18.0995C10.4783 19.5045 11.7128 18.6849 12.1537 18.0995C12.8885 17.075 12.1537 16.0505 12.1537 16.0505C11.8598 15.465 11.272 15.465 12.0067 14.7333L12.8885 13.8551C13.5939 14.4405 15.0439 14.5869 15.6807 14.5869Z" stroke="#1C274C" stroke-width="1" stroke-linejoin="round"/>
                           <path d="M17.8853 8.29353C17.8853 9.50601 16.8984 10.4889 15.681 10.4889C14.4635 10.4889 13.4766 9.50601 13.4766 8.29353C13.4766 7.08105 14.4635 6.09814 15.681 6.09814C16.8984 6.09814 17.8853 7.08105 17.8853 8.29353Z" stroke="#1C274C" stroke-width="1"/>
                           </svg> Ubah Password
                           </a>
                        <a href="/koleksi" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span>
                              <svg class="fs-5 me-2" width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#75868f"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 6.2C5 5.07989 5 4.51984 5.21799 4.09202C5.40973 3.71569 5.71569 3.40973 6.09202 3.21799C6.51984 3 7.07989 3 8.2 3H15.8C16.9201 3 17.4802 3 17.908 3.21799C18.2843 3.40973 18.5903 3.71569 18.782 4.09202C19 4.51984 19 5.07989 19 6.2V21L12 16L5 21V6.2Z" stroke="#75868f" stroke-width="2" stroke-linejoin="round"></path> </g></svg>
                           Koleksi</span>
                        </a>
                        <a href="{{route('daftarbacaan')}}" class="list-group-item list-group-item-action">
                        <svg class="fs-5 me-2" width="15" height="15" fill="currentcolor" viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M229.75146,196.61035l-8.28173-30.9082-.00049-.00195-.00049-.00184L196.62256,72.97217v-.00086l-8.28223-30.90979a12.00916,12.00916,0,0,0-14.69678-8.48437l-30.90966,8.28222a11.99256,11.99256,0,0,0-3.61182,1.656A12.01237,12.01237,0,0,0,128,36H96a11.93662,11.93662,0,0,0-8,3.081A11.93662,11.93662,0,0,0,80,36H48A12.01343,12.01343,0,0,0,36,48V208a12.01343,12.01343,0,0,0,12,12H80a11.93662,11.93662,0,0,0,8-3.08105A11.93662,11.93662,0,0,0,96,220h32a12.01343,12.01343,0,0,0,12-12V78.02l2.53027,9.44373.00049.00109.00049.00122,24.84619,92.72706v.00122l.00049.00146,8.28174,30.90772a11.98984,11.98984,0,0,0,14.69678,8.48535l30.90966-8.28223a11.99918,11.99918,0,0,0,8.48535-14.69629ZM151.293,89.25781,189.93066,78.9054l22.77588,85.00207-38.63672,10.353ZM96,44h32a4.00427,4.00427,0,0,1,4,4V172H92V48A4.00427,4.00427,0,0,1,96,44ZM48,44H80a4.00427,4.00427,0,0,1,4,4V76H44V48A4.00427,4.00427,0,0,1,48,44ZM80,212H48a4.00427,4.00427,0,0,1-4-4V84H84V208A4.00427,4.00427,0,0,1,80,212Zm48,0H96a4.00427,4.00427,0,0,1-4-4V180h40v28A4.00427,4.00427,0,0,1,128,212ZM142.37549,51.4502a3.97587,3.97587,0,0,1,2.4292-1.86426l30.90918-8.28223a3.99814,3.99814,0,0,1,4.89892,2.82813l7.24756,27.04687L149.22266,81.53113l-7.24659-27.04578A3.9718,3.9718,0,0,1,142.37549,51.4502Zm79.249,150.26562a3.97594,3.97594,0,0,1-2.4292,1.86426l-30.90918,8.28222a4.00907,4.00907,0,0,1-4.89892-2.8291l-7.24707-27.04614,38.63672-10.353,7.24707,27.04663A3.97183,3.97183,0,0,1,221.62451,201.71582Z"></path> </g></svg>
                        Daftar Bacaan
                        </a>                           
                        <a href="javascript:void(0);" class="list-group-item list-group-item-action" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           <i class="demo-pli-unlock fs-5 me-2"></i> Logout
                           </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                           @csrf
                        </form>
                        @php
                           $lastread = auth()->user()->baca()->orderBy('end_at','desc')->first() ?? null;
                        @endphp 
                        @if($lastread !== null)
                        <div class="list-group-item list-group-item-action border-end-0 py-0">
                            <hr class="mb-0 mt-1">
                        </div>
                        <div href="#" class="list-group-item list-group-item-action border-end-0 mt-0">
                           <span class="text-muted small">Terakhir Dibaca:</span>
                           <div class="d-flex align-items-center position-relative mt-2">
                              <div class="flex-shrink-0">
                                 <img src="{{Storage::url('imgs/thumbnail-buku/'.$lastread->buku->thumbnail)}}" width="15" height="auto">
                              </div>
                              <div class="flex-grow-1 ms-2">
                                 <a href="{{ route('read', ['id' => $lastread->buku->id, 'slug' => $lastread->buku->slug]) }}" class="stretched-link text-reset text-decoration-none mb-1">{{$lastread->buku->judul}}</a>
                                 <div class="progress progress-md">
                                    <div class="progress-bar" role="progressbar" style="width: {{round(($lastread->progress/$lastread->buku->jumlah_halaman)*100)}}%; border-radius: 0;" aria-label="Progress Membaca" aria-valuenow="{{round(($lastread->progress/$lastread->buku->jumlah_halaman)*100)}}" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @else
            <div class="brand-wrap">
               <h5 class="my-auto">
                  <a href="/login" style="text-decoration: none; color: white; font-family: Ubuntu,sans-serif;">
                  Masuk</a>
               </h5>
            </div>
            @endif             
         </div>
         <!-- Brand title -->
      </div>
   </div>
   </div>
</header>