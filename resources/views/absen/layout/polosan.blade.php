<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title></title>
      {{-- icon bootstrap  --}}
      <!-- Tambahkan di layout atau sebelum </body> -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}

      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
      {{-- bootstrap --}}
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

          <!-- 1. jQuery (harus sebelum script.js) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
      <!-- Favicon -->
      <link rel="shortcut icon" href="{{ asset('img/smktip2.png') }}" />

      <!-- Library / Plugin Css Build -->
      <link rel="stylesheet" href="{{ asset('css/core/libs.min.css') }}" />

      <!-- Hope Ui Design System Css -->
      <link rel="stylesheet" href="{{ asset('css/hope-ui.min.css') }}" />

      <!-- Custom Css -->
      <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

      <!-- Customizer Css -->
      <link rel="stylesheet" href="{{ asset('css/customizer.min.css') }}" />

      <!-- RTL Css -->
      <link rel="stylesheet" href="{{ asset('css/rtl.min.css') }}"/>
      

  </head>
  <body>
    <aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all ">
        <div class="sidebar-header d-flex align-items-center justify-content-start">
            <a href="/admin/dashboard" class="navbar-brand">
                <h4 class="logo-title">SMKS Wahas</h4>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="">
                        <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body pt-0 data-scrollbar">
            <div class="sidebar-list">
                <!-- Sidebar Menu Start -->
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">
                    <!-- Home Section -->
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Home</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ url('admin/dashboard') }}">
                            <i class="icon">
                                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-20">
                                    <path opacity="0.4" d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z" fill="currentColor"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="currentColor"></path>
                                </svg>
                            </i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>

                    <li><hr class="hr-horizontal"></li>
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Data</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>

                    <!-- Administrasi Section -->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('tapel', 'libur') ? 'active' : '' }}"
                           data-bs-toggle="collapse" href="#utilities-error"
                           role="button" aria-expanded="{{ Request::is('tapel', 'libur') ? 'true' : 'false' }}"
                           aria-controls="utilities-error">
                            <i class="icon">
                            <svg width="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4" d="M16.6643 21.9897H7.33488C5.88835 22.0796 4.46781 21.5781 3.3989 20.6011C2.4219 19.5312 1.92041 18.1107 2.01032 16.6652V7.33482C1.92041 5.88932 2.4209 4.46878 3.3979 3.39889C4.46781 2.42189 5.88835 1.92041 7.33488 2.01032H16.6643C18.1089 1.92041 19.5284 2.4209 20.5973 3.39789C21.5733 4.46878 22.0758 5.88832 21.9899 7.33482V16.6652C22.0788 18.1107 21.5783 19.5312 20.6013 20.6011C19.5314 21.5781 18.1109 22.0796 16.6643 21.9897Z" fill="currentColor"></path>                                <path d="M17.0545 10.3976L10.5018 16.9829C10.161 17.3146 9.7131 17.5 9.24574 17.5H6.95762C6.83105 17.5 6.71421 17.4512 6.62658 17.3634C6.53895 17.2756 6.5 17.1585 6.5 17.0317L6.55842 14.7195C6.56816 14.261 6.75315 13.8317 7.07446 13.5098L11.7189 8.8561C11.7967 8.77805 11.9331 8.77805 12.011 8.8561L13.6399 10.4785C13.747 10.5849 13.9028 10.6541 14.0683 10.6541C14.4286 10.6541 14.7109 10.3615 14.7109 10.0102C14.7109 9.83463 14.6428 9.67854 14.5357 9.56146C14.5065 9.52244 12.9554 7.97805 12.9554 7.97805C12.858 7.88049 12.858 7.71463 12.9554 7.61707L13.6078 6.95366C14.2114 6.34878 15.1851 6.34878 15.7888 6.95366L17.0545 8.22195C17.6485 8.81707 17.6485 9.79268 17.0545 10.3976Z" fill="currentColor"></path>
                            </svg>
                            </i>                            
                            <span class="item-name">Administrasi</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse {{ Request::is('tapel', 'libur') ? 'show' : '' }}" id="utilities-error">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('tapel') ? 'active' : '' }}" href="{{ url('tapel') }}" id="active">
                                    <i class="icon">
                                        <!-- SVG Icon -->
                                    </i>
                                    <i class="sidenav-mini-icon">DT</i>
                                    <span class="item-name">Tahun Pelajaran</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('libur') ? 'active' : '' }}" href="{{ url('libur') }}" id="active">
                                    <i class="icon">
                                        <!-- SVG Icon -->
                                    </i>
                                    <i class="sidenav-mini-icon">HL</i>
                                    <span class="item-name">Data Hari Libur</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li><hr class="hr-horizontal"></li>

                    <!-- Absensi Section -->
                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#" tabindex="-1">
                            <span class="default-icon">Absensi</span>
                            <span class="mini-icon">-</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('kelola_absen*') || Request::is('admin/rekap_absen') ? 'active' : '' }}"
                           data-bs-toggle="collapse" href="#sidebar-widget"
                           role="button" aria-expanded="{{ Request::is('kelola_absen*') || Request::is('admin/rekap_absen') ? 'true' : 'false' }}"
                           aria-controls="sidebar-widget">
                            <i class="icon">
                                <svg width="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path>                                <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path>
                                </svg>                            
                            </i>
                            <span class="item-name">Absen Guru</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse {{ Request::is('admin/kelola_absen') || Request::is('admin/rekap_absen') ? 'show' : '' }}" id="sidebar-widget">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/kelola_absen') ? 'active' : '' }}" href="{{ url('admin/kelola_absen') }}" id="active">
                                    <i class="icon">
                                        <!-- SVG Icon -->
                                    </i>
                                    <i class="sidenav-mini-icon">K</i>
                                    <span class="item-name">Kelola Absen</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/rekap_absen') ? 'active' : '' }}" href="{{ url('admin/rekap_absen') }}" id="active">
                                    <i class="icon">
                                        <!-- SVG Icon -->
                                    </i>
                                    <i class="sidenav-mini-icon">A</i>
                                    <span class="item-name">Rekap Absen</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!--- ------------ End Absen Section ----------- --->
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('kelola_absenharian') || Request::is('admin/rekap_absenharian') ? 'active' : '' }}"
                           data-bs-toggle="collapse" href="#sidebar-widget1"
                           role="button" aria-expanded="{{ Request::is('kelola_absenharian') || Request::is('admin/rekap_absenharian') ? 'true' : 'false' }}"
                           aria-controls="sidebar-widget1">
                            <i class="icon">
                                <svg width="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.9488 14.54C8.49884 14.54 5.58789 15.1038 5.58789 17.2795C5.58789 19.4562 8.51765 20.0001 11.9488 20.0001C15.3988 20.0001 18.3098 19.4364 18.3098 17.2606C18.3098 15.084 15.38 14.54 11.9488 14.54Z" fill="currentColor"></path>                                <path opacity="0.4" d="M11.949 12.467C14.2851 12.467 16.1583 10.5831 16.1583 8.23351C16.1583 5.88306 14.2851 4 11.949 4C9.61293 4 7.73975 5.88306 7.73975 8.23351C7.73975 10.5831 9.61293 12.467 11.949 12.467Z" fill="currentColor"></path>                                <path opacity="0.4" d="M21.0881 9.21923C21.6925 6.84176 19.9205 4.70654 17.664 4.70654C17.4187 4.70654 17.1841 4.73356 16.9549 4.77949C16.9244 4.78669 16.8904 4.802 16.8725 4.82902C16.8519 4.86324 16.8671 4.90917 16.8895 4.93889C17.5673 5.89528 17.9568 7.0597 17.9568 8.30967C17.9568 9.50741 17.5996 10.6241 16.9728 11.5508C16.9083 11.6462 16.9656 11.775 17.0793 11.7948C17.2369 11.8227 17.3981 11.8371 17.5629 11.8416C19.2059 11.8849 20.6807 10.8213 21.0881 9.21923Z" fill="currentColor"></path>                                <path d="M22.8094 14.817C22.5086 14.1722 21.7824 13.73 20.6783 13.513C20.1572 13.3851 18.747 13.205 17.4352 13.2293C17.4155 13.232 17.4048 13.2455 17.403 13.2545C17.4003 13.2671 17.4057 13.2887 17.4316 13.3022C18.0378 13.6039 20.3811 14.916 20.0865 17.6834C20.074 17.8032 20.1698 17.9068 20.2888 17.8888C20.8655 17.8059 22.3492 17.4853 22.8094 16.4866C23.0637 15.9589 23.0637 15.3456 22.8094 14.817Z" fill="currentColor"></path>                                <path opacity="0.4" d="M7.04459 4.77973C6.81626 4.7329 6.58077 4.70679 6.33543 4.70679C4.07901 4.70679 2.30701 6.84201 2.9123 9.21947C3.31882 10.8216 4.79355 11.8851 6.43661 11.8419C6.60136 11.8374 6.76343 11.8221 6.92013 11.7951C7.03384 11.7753 7.09115 11.6465 7.02668 11.551C6.3999 10.6234 6.04263 9.50765 6.04263 8.30991C6.04263 7.05904 6.43303 5.89462 7.11085 4.93913C7.13234 4.90941 7.14845 4.86348 7.12696 4.82926C7.10906 4.80135 7.07593 4.78694 7.04459 4.77973Z" fill="currentColor"></path>                                <path d="M3.32156 13.5127C2.21752 13.7297 1.49225 14.1719 1.19139 14.8167C0.936203 15.3453 0.936203 15.9586 1.19139 16.4872C1.65163 17.4851 3.13531 17.8066 3.71195 17.8885C3.83104 17.9065 3.92595 17.8038 3.91342 17.6832C3.61883 14.9167 5.9621 13.6046 6.56918 13.3029C6.59425 13.2885 6.59962 13.2677 6.59694 13.2542C6.59515 13.2452 6.5853 13.2317 6.5656 13.2299C5.25294 13.2047 3.84358 13.3848 3.32156 13.5127Z" fill="currentColor"></path>
                                </svg>                            
                            </i>
                            <span class="item-name">Absensi Harian</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse {{ Request::is('admin/kelola_absenharian') || Request::is('admin/rekap_absenharian') ? 'show' : '' }}" id="sidebar-widget1">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/kelola_absenharian') ? 'active' : '' }}" href="{{ url('admin/kelola_absenharian') }}" id="active">
                                    <i class="icon">
                                        <!-- SVG Icon -->
                                    </i>
                                    <i class="sidenav-mini-icon">K</i>
                                    <span class="item-name">Kelola Absen</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/rekap_absenharian') ? 'active' : '' }}" href="{{ url('admin/rekap_absenharian') }}" id="active">
                                    <i class="icon">
                                        <!-- SVG Icon -->
                                    </i>
                                    <i class="sidenav-mini-icon">A</i>
                                    <span class="item-name">Rekap Absen</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('kelola_absenmapel') || Request::is('admin/rekap_absenmapel') ? 'active' : '' }}"
                           data-bs-toggle="collapse" href="#sidebar-widget2"
                           role="button" aria-expanded="{{ Request::is('kelola_absenmapel') || Request::is('admin/rekap_absenmapel') ? 'true' : 'false' }}"
                           aria-controls="sidebar-widget1">
                            <i class="icon">
                                <svg width="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.34933 14.8577C5.38553 14.8577 2 15.47 2 17.9173C2 20.3665 5.364 20.9999 9.34933 20.9999C13.3131 20.9999 16.6987 20.3876 16.6987 17.9403C16.6987 15.4911 13.3347 14.8577 9.34933 14.8577Z" fill="currentColor"></path>                                <path opacity="0.4" d="M9.34935 12.5248C12.049 12.5248 14.2124 10.4062 14.2124 7.76241C14.2124 5.11865 12.049 3 9.34935 3C6.65072 3 4.48633 5.11865 4.48633 7.76241C4.48633 10.4062 6.65072 12.5248 9.34935 12.5248Z" fill="currentColor"></path>                                <path opacity="0.4" d="M16.1733 7.84873C16.1733 9.19505 15.7604 10.4513 15.0363 11.4948C14.961 11.6021 15.0275 11.7468 15.1586 11.7698C15.3406 11.7995 15.5275 11.8177 15.7183 11.8216C17.6165 11.8704 19.3201 10.6736 19.7907 8.87116C20.4884 6.19674 18.4414 3.79541 15.8338 3.79541C15.551 3.79541 15.2799 3.82416 15.0157 3.87686C14.9795 3.88453 14.9404 3.90177 14.9208 3.93244C14.8954 3.97172 14.914 4.02251 14.9394 4.05605C15.7232 5.13214 16.1733 6.44205 16.1733 7.84873Z" fill="currentColor"></path>                                <path d="M21.779 15.1693C21.4316 14.4439 20.593 13.9465 19.3171 13.7022C18.7153 13.5585 17.0852 13.3544 15.5695 13.3831C15.547 13.386 15.5343 13.4013 15.5324 13.4109C15.5294 13.4262 15.5363 13.4492 15.5656 13.4655C16.2662 13.8047 18.9737 15.2804 18.6332 18.3927C18.6185 18.5288 18.729 18.6438 18.867 18.6246C19.5333 18.5317 21.2476 18.1704 21.779 17.0474C22.0735 16.4533 22.0735 15.7634 21.779 15.1693Z" fill="currentColor"></path>
                                </svg>                            
                            </i>
                            <span class="item-name">Absensi Mapel</span>
                            <i class="right-icon">
                                <svg class="icon-18" xmlns="http://www.w3.org/2000/svg" width="18"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse {{ Request::is('admin/kelola_absenmapel') || Request::is('admin/rekap_absenmapel') ? 'show' : '' }}" id="sidebar-widget2">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/kelola_absenmapel') ? 'active' : '' }}" href="{{ url('admin/kelola_absenmapel') }}" id="active">
                                    <i class="icon">
                                        <!-- SVG Icon -->
                                    </i>
                                    <i class="sidenav-mini-icon">K</i>
                                    <span class="item-name">Kelola Absen</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('admin/rekap_absenmapel') ? 'active' : '' }}" href="{{ url('admin/rekap_absenmapel') }}" id="active">
                                    <i class="icon">
                                        <!-- SVG Icon -->
                                    </i>
                                    <i class="sidenav-mini-icon">A</i>
                                    <span class="item-name">Rekap Absen</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu End -->
            </div>
        </div>
        <div class="sidebar-footer"></div>
    </aside>
     <main class="main-content">
      <div class="position-relative iq-banner">
        <!--Nav Start-->
        <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
          <div class="container-fluid navbar-inner">
            <a href="../dashboard/index.html" class="navbar-brand">
                <!--Logo start-->
                <!--logo End-->

                <!--Logo start-->
                <div class="logo-main">
                    <div class="logo-normal">
                    </div>
                    <div class="logo-mini">
                    </div>
                </div>
                <!--logo End-->
                <h4 class="logo-title">SMKS Wahas</h4>
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                 <svg  width="20px" class="icon-20" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
                </i>
            </div>
            {{-- <div class="input-group search-input">
              <span class="input-group-text" id="search-input">
                <svg class="icon-18" width="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></circle>
                    <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
              </span>
              <input type="search" class="form-control" placeholder="Search...">
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon">
                  <span class="mt-2 navbar-toggler-bar bar1"></span>
                  <span class="navbar-toggler-bar bar2"></span>
                  <span class="navbar-toggler-bar bar3"></span>
                </span>
            </button> --}}
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                {{-- <li class="nav-item dropdown">
                    <a href="#" class="search-toggle nav-link" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ asset('img/ind.png') }}" class="img-fluid rounded-circle" alt="user" style="height: 30px; min-width: 30px; width: 30px;">
                    <span class="bg-primary"></span>
                    </a>
                    <div class="p-0 sub-drop dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                        <div class="m-0 border-0 shadow-none card">
                            <div class="p-0 ">
                                <ul class="p-0 list-group list-group-flush">
                                    <li class="iq-sub-card list-group-item"><a class="p-0" href="#"><img src="{{ asset('img/ind.png') }}" alt="img-flaf" class="img-fluid me-2" style="width: 15px;height: 15px;min-width: 15px;"/>Indonesia</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link" id="mail-drop" data-bs-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                    <svg class="icon-24" width="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path opacity="0.4" d="M22 15.94C22 18.73 19.76 20.99 16.97 21H16.96H7.05C4.27 21 2 18.75 2 15.96V15.95C2 15.95 2.006 11.524 2.014 9.298C2.015 8.88 2.495 8.646 2.822 8.906C5.198 10.791 9.447 14.228 9.5 14.273C10.21 14.842 11.11 15.163 12.03 15.163C12.95 15.163 13.85 14.842 14.56 14.262C14.613 14.227 18.767 10.893 21.179 8.977C21.507 8.716 21.989 8.95 21.99 9.367C22 11.576 22 15.94 22 15.94Z" fill="currentColor"></path>
                      <path d="M21.4759 5.67351C20.6099 4.04151 18.9059 2.99951 17.0299 2.99951H7.04988C5.17388 2.99951 3.46988 4.04151 2.60388 5.67351C2.40988 6.03851 2.50188 6.49351 2.82488 6.75151L10.2499 12.6905C10.7699 13.1105 11.3999 13.3195 12.0299 13.3195C12.0339 13.3195 12.0369 13.3195 12.0399 13.3195C12.0429 13.3195 12.0469 13.3195 12.0499 13.3195C12.6799 13.3195 13.3099 13.1105 13.8299 12.6905L21.2549 6.75151C21.5779 6.49351 21.6699 6.03851 21.4759 5.67351Z" fill="currentColor"></path>
                    </svg>
                    <span class="bg-primary count-mail"></span>
                  </a>
                  <div class="p-0 sub-drop dropdown-menu dropdown-menu-end" aria-labelledby="mail-drop">
                      <div class="m-0 shadow-none card">
                        <div class="py-3 card-header d-flex justify-content-between bg-primary">
                            <div class="header-title">
                              <h5 class="mb-0 text-white">All Message</h5>
                            </div>
                        </div>
                        <div class="p-0 card-body ">
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <div class="">
                                    <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="{{ asset('img/1.png') }}" alt="">
                                  </div>
                                  <div class="ms-3">
                                    <h6 class="mb-0 ">ngopi bro</h6>
                                    <small class="float-start font-size-12">13 Jun</small>
                                  </div>
                              </div>
                            </a>
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <div class="">
                                    <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="{{ asset('img/profile.jpg') }}" alt="">
                                  </div>
                                  <div class="ms-3">
                                    <h6 class="mb-0 ">tugas tong poho</h6>
                                    <small class="float-start font-size-12">20 Apr</small>
                                  </div>
                              </div>
                            </a>
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <div class="">
                                    <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="{{ asset('img/2.png') }}" alt="">
                                  </div>
                                  <div class="ms-3">
                                    <h6 class="mb-0 ">Kamana?</h6>
                                    <small class="float-start font-size-12">30 Jun</small>
                                  </div>
                              </div>
                            </a>
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <div class="">
                                    <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="{{ asset('img/3.png') }}" alt="">
                                  </div>
                                  <div class="ms-3">
                                    <h6 class="mb-0 ">Info tugas</h6>
                                    <small class="float-start font-size-12">12 Sep</small>
                                  </div>
                              </div>
                            </a>
                            <a href="#" class="iq-sub-card">
                              <div class="d-flex align-items-center">
                                  <div class="">
                                    <img class="p-1 avatar-40 rounded-pill bg-soft-primary" src="{{ asset('img/profile.jpg') }}" alt="">
                                  </div>
                                  <div class="ms-3">
                                    <h6 class="mb-0 ">Maaf,Kita temenan aja ya</h6>
                                    <small class="float-start font-size-12">2021 jan</small>
                                  </div>
                              </div>
                            </a>
                        </div>
                      </div>
                  </div>
                </li> --}}
                <li class="nav-item dropdown">
                  <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/profile.jpg') }}" alt="User-Profile" class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                    <div class="caption ms-3 d-none d-md-block ">
                        <h6 class="mb-0 caption-title">{{ Auth::user()->name }}</h6>
                        <p class="mb-0 caption-sub-title"></p>
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    {{-- <li><a class="dropdown-item" href="../dashboard/app/user-profile.html">Profile</a></li> --}}
                    {{-- <li><hr class="dropdown-divider"></li> --}}
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <!-- Navbar End -->
      @include('sweetalert::alert')
      <div class="container">
        @yield('konten')
      </div>
      @include('sweetalert::alert')
      <!-- Footer Section Start -->
      {{-- <footer class="footer">
          <div class="footer-body">
              <ul class="left-panel list-inline mb-0 p-0">
                  <li class="list-inline-item"><a href="../dashboard/extra/privacy-policy.html"></a></li>
                  <li class="list-inline-item"><a href="../dashboard/extra/terms-of-service.html"></a></li>
              </ul>
              <div class="right-panel">
                  <script>document.write(new Date().getFullYear())</script> made in indonesian
                  <span class="">
                      <svg class="icon-15" width="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M15.85 2.50065C16.481 2.50065 17.111 2.58965 17.71 2.79065C21.401 3.99065 22.731 8.04065 21.62 11.5806C20.99 13.3896 19.96 15.0406 18.611 16.3896C16.68 18.2596 14.561 19.9196 12.28 21.3496L12.03 21.5006L11.77 21.3396C9.48102 19.9196 7.35002 18.2596 5.40102 16.3796C4.06102 15.0306 3.03002 13.3896 2.39002 11.5806C1.26002 8.04065 2.59002 3.99065 6.32102 2.76965C6.61102 2.66965 6.91002 2.59965 7.21002 2.56065H7.33002C7.61102 2.51965 7.89002 2.50065 8.17002 2.50065H8.28002C8.91002 2.51965 9.52002 2.62965 10.111 2.83065H10.17C10.21 2.84965 10.24 2.87065 10.26 2.88965C10.481 2.96065 10.69 3.04065 10.89 3.15065L11.27 3.32065C11.3618 3.36962 11.4649 3.44445 11.554 3.50912C11.6104 3.55009 11.6612 3.58699 11.7 3.61065C11.7163 3.62028 11.7329 3.62996 11.7496 3.63972C11.8354 3.68977 11.9247 3.74191 12 3.79965C13.111 2.95065 14.46 2.49065 15.85 2.50065ZM18.51 9.70065C18.92 9.68965 19.27 9.36065 19.3 8.93965V8.82065C19.33 7.41965 18.481 6.15065 17.19 5.66065C16.78 5.51965 16.33 5.74065 16.18 6.16065C16.04 6.58065 16.26 7.04065 16.68 7.18965C17.321 7.42965 17.75 8.06065 17.75 8.75965V8.79065C17.731 9.01965 17.8 9.24065 17.94 9.41065C18.08 9.58065 18.29 9.67965 18.51 9.70065Z" fill="currentColor"></path>
                      </svg>
                  </span> by <a href="https://iqonic.design/">yoo Design</a>.
              </div>
          </div>
      </footer> --}}
      <!-- Footer Section End -->
    </main>


    <script src="{{ asset('js/script.js') }}"></script>
    <!-- Library Bundle Script -->
    <script src="{{ asset('js/core/libs.min.js') }}"></script>
    <!-- External Library Bundle Script -->
    <script src="{{ asset('js/core/external.min.js') }}"></script>
    <!-- mapchart Script -->
    <script src="{{ asset('js/charts/dashboard.js') }}" ></script>
    <!-- App Script -->
    <script src="{{ asset('js/hope-ui.js') }}" defer></script>

  </body>
</html>
