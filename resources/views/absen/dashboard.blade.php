@extends('absen.layout.polosan')
@php
    use Carbon\Carbon;

    $now = Carbon::now();
    $hour = $now->hour;

    if ($hour >= 5 && $hour < 11) {
        $waktu = 'Pagi';
    } elseif ($hour >= 11 && $hour < 15) {
        $waktu = 'Siang';
    } elseif ($hour >= 15 && $hour < 18) {
        $waktu = 'Sore';
    } else {
        $waktu = 'Malam';
    }

@endphp
@section('konten')

<div class="iq-navbar-header" style="height: 215px;">
                <div class="container-fluid iq-container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="flex-wrap d-flex justify-content-between align-items-center">
                                <div>
                                    
                                    <h4>Selamat {{ $waktu }} !</h4>
                                    <p>{{ auth()->user()->name }}</p>
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="iq-header-img">
                    <img src="{{ asset('images/top-header.png') }}" alt="header"
                        class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
                </div>
            </div> 
            <div class="conatiner-fluid content-inner mt-n5 py-0">
<div class="row">
         
         <div class="col-lg-3 col-md-6">
            <div class="card">
               <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                     <div class="bg-success text-white rounded p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                     </div>
                     <div class="text-end">
                        Tidak Hadir Hari Ini
                           <h2 class="counter">{{ $jumlah_tidak_hadir }}</h2>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6">
            <div class="card">
               <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                     <div class="bg-danger text-white rounded p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 20 20" fill="currentColor">
                           <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                     </div>
                     <div class="text-end">
                        Hadir Hari Ini
                           <h2 class="counter">{{ $jumlah_hadir }}</h2>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6">
            <div class="card">
               <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                     <div class="bg-primary text-white rounded p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 20 20" fill="currentColor">
                           <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                     </div>
                     <div class="text-end">
                        Jumlah Guru
                           <h2 class="counter">{{ $jumlah_guru }}</h2>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-3 col-md-6">
            <div class="card">
               <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                     <div class="bg-warning text-white rounded p-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 20 20" fill="currentColor">
                           <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                     </div>
                     <div class="text-end">
                        Jumlah Siswa
                           <h2 class="counter">{{ $jumlah_siswa }}</h2>
                     </div>
                  </div>
               </div>
            </div>
         </div>

            <div class="col-md-12 col-lg-7">
               <div class="card" data-aos="fade-up" data-aos-delay="800">
                  <div class="card-header d-flex justify-content-between flex-wrap">
                     <div class="header-title">
                        <h4 class="card-title">Absensi Siswa</h4>
                        <p class="mb-0">7 hari terakhir</p>
                     </div>
                     <div class="d-flex align-items-center align-self-center">
                        <div class="d-flex align-items-center text-primary">
                           <svg xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24" fill="currentColor">
                              <g id="Solid dot2">
                                 <circle id="Ellipse 65" cx="12" cy="12" r="8" fill="#28a745"></circle>
                              </g>
                           </svg>
                           <div class="ms-2">
                              <span class="text-secondary">Hadir</span>
                           </div>
                        </div>
                        <div class="d-flex align-items-center ms-3 text-info">
                           <svg xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24" fill="currentColor">
                              <g id="Solid dot3">
                                 <circle id="Ellipse 66" cx="12" cy="12" r="8" fill="#fa003f"></circle>
                              </g>
                           </svg>
                           <div class="ms-2">
                              <span class="text-secondary">Tidak hadir</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <div id="d-main" class="d-main"
                        data-sales='{!! json_encode($data['hadir']) !!}'
                        data-cost='{!! json_encode($data['tidak_hadir']) !!}'
                        data-labels='{!! json_encode($data['labels']) !!}'>
                     </div>

                  </div>
               </div>
            </div>
            <div class="col-md-12 col-lg-5">
               <div class="card" data-aos="fade-up" data-aos-delay="1000">
                  <div class="card-header d-flex justify-content-between flex-wrap">
                     <div class="header-title">
                        <h4 class="card-title">Absensi hari ini</h4>
                     </div>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center justify-content-between">
                        <div id="myChart"
                        data-presentase="{{ json_encode($data['presentase']) }}"
                        class="col-md-8 col-lg-8 myChart"></div>
                        <div class="d-grid gap col-md-4 col-lg-4">
                           <div class="d-flex align-items-start">
                              <svg class="mt-2" xmlns="http://www.w3.org/2000/svg" width="14" viewBox="0 0 24 24" fill="#3a57e8">
                                 <g id="Solid dot">
                                    <circle id="Ellipse 67" cx="12" cy="12" r="8" fill="#1aa053"></circle>
                                 </g>
                              </svg>
                              <div class="ms-3">
                                 <span class="text-secondary">Hadir</span>
                                 <h6>{{ $jumlah_hadir }}</h6>
                              </div>
                           </div>
                           <div class="d-flex align-items-start">
                              <svg class="mt-2" xmlns="http://www.w3.org/2000/svg" width="14" viewBox="0 0 24 24" fill="#4bc7d2">
                                 <g id="Solid dot1">
                                    <circle id="Ellipse 68" cx="12" cy="12" r="8" fill="#f0ad4e"></circle>
                                 </g>
                              </svg>
                              <div class="ms-3">
                                 <span class="text-secondary">Izin</span>
                                 <h6>{{ $jumlah_izin }}</h6>
                              </div>
                           </div>
                           <div class="d-flex align-items-start">
                              <svg class="mt-2" xmlns="http://www.w3.org/2000/svg" width="14" viewBox="0 0 24 24" fill="#4bc7d2">
                                 <g id="Solid dot1">
                                    <circle id="Ellipse 68" cx="12" cy="12" r="8" fill="#0275d8"></circle>
                                 </g>
                              </svg>
                              <div class="ms-3">
                                 <span class="text-secondary">Sakit</span>
                                 <h6>{{ $jumlah_sakit }}</h6>
                              </div>
                           </div>
                           <div class="d-flex align-items-start">
                              <svg class="mt-2" xmlns="http://www.w3.org/2000/svg" width="14" viewBox="0 0 24 24" fill="#4bc7d2">
                                 <g id="Solid dot1">
                                    <circle id="Ellipse 68" cx="12" cy="12" r="8" fill="#fa003f"></circle>
                                 </g>
                              </svg>
                              <div class="ms-3">
                                 <span class="text-secondary">Alfa</span>
                                 <h6>{{ $jumlah_alfa }}</h6>
                              </div>
                           </div>
                        </div>


         
            </div>            
@endsection
