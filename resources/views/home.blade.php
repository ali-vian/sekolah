@include('templates.header')
@include('templates.nav')
        <section class="bg-white mt-20 dark:bg-gray-900">
            <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                <div class="mr-auto place-self-center lg:col-span-7">
                    <h1 class="max-w-2xl mb-4 text-4xl font-[1000] tracking-tight leading-none md:text-5xl xl:text-6xl dark:text-white">SMKS <span class="text-yellow-400">Wahid Hasyim </span> Glagah</h1>
                    <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">sekolah adalah tempat mencetak penerus bangsa
                        {{ $about->description }}</p>
                    <div class="inline-flex justify-center">

                            <a href="/about" class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                                Selengkapnya
                                <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </a>
                        <a href="https://youtu.be/zcIVe5nMeHs?si=4gVezSGGh8f3tfy8" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path></svg>
                        Video
                        </a> 
                    </div>
                </div>
                <div data-aos="zoom-in" class="hidden lg:mt-0 lg:col-span-5 lg:flex"  >
                    <img src="{{ asset("storage/".$about->image) }}" class="h-96 rounded-xl shadow-md" alt="mockup" >
                </div>                
            </div>
        </section>
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
                <div class="max-w-screen-md mx-auto mb-8 lg:mb-16">
                    <h2 class="mb-4 text-center text-3xl md:text-4xl tracking-tight font-extrabold text-blue-700 dark:text-white">Kenapa Harus SMKS Wahid Hasyim Glagah ?</h2>
                    <p class="text-gray-500 text-center sm:text-xl dark:text-gray-400">Alasan kenapa harus memilih untuk bergabung dengan <br> SMKS Wachid Hasyim Glagah</p>
                </div>
                <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-4 md:gap-12 md:space-y-0">
                    @foreach ( $about->fasilitas as $i => $fsl )
                    <div data-aos="zoom-in" data-aos-delay="{{ $i*2 }}00" data-aos-duration="500"  class="shadow-lg p-3 rounded-lg w-46 text-center flex flex-col items-center bg-white dark:bg-gray-800">
                        <div class="flex justify-center items-center mb-4 w-12 h-12 rounded-full bg-blue-100 lg:h-24 lg:w-24 dark:bg-gray-200">
                            <img  src="{{ asset("storage/".$fsl['icon_fasilitas']) }}" class="w-16" alt="">
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">{{ $fsl['fasilitas'] }}</h3>
                        <p class="text-gray-500 dark:text-gray-400">{{ $fsl['deskripsi_fasilitas'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
          </section>
          <section class="bg-white dark:bg-gray-900">
            <div class="max-w-screen-md mx-auto mt-4 lg:mt-16">
                <h2 class="mb-4 text-center text-4xl tracking-tight font-extrabold text-yellow-400 dark:text-white">Profil SMKS Wahid Hasyim  Glagah</h2>
            </div>
            <div class="gap-8 items-center py-8 px-4 mx-auto max-w-screen-xl xl:gap-16 md:grid md:grid-cols-2 sm:py-16 lg:px-6">
                <img data-aos="fade-right" data-aos-duration="2000" class="rounded-xl" src="{{ asset("storage/".$about->gambar_sambutan) }}" alt="kepsek">
                <div data-aos="fade-left" data-aos-duration="2000" class="mt-4 md:mt-0">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Sembutan Kepala Sekolah SMKS Wahid Hasyim Glagah</h2>
                    <p class="mb-6 font-light text-gray-500 md:text-lg dark:text-gray-400">{{ $about->sambutan }}<p>
                    {{-- <a href="/about" class="inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-blue-900">
                        Selengkapnya
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a> --}}
                </div>
            </div>
        </section>
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
                <div class="max-w-screen-md mx-auto mb-8 lg:mb-16">
                    <h2 class="mb-4 text-center text-3xl md:text-4xl tracking-tight font-extrabold text-blue-700 dark:text-white">Jurusan Di  SMKS Wahid Hasyim  Glagah</h2>
                    <p class="text-gray-500 text-center sm:text-xl dark:text-gray-400">Pilihan program keahlian di SMKS Wahid Hasyim Glagah.</p>
                </div>
                <div class="relative">
                <button  onclick="scrollSlider('left')" type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/20 dark:bg-gray-200/30 group-hover:bg-black/30 dark:group-hover:bg-gray-200/60 group-focus:ring-4 group-focus:ring-black dark:group-focus:ring-gray-200/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button  onclick="scrollSlider('right')" type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/20 dark:bg-gray-200/30 group-hover:bg-black/30 dark:group-hover:bg-gray-200/60 group-focus:ring-4 group-focus:ring-black dark:group-focus:ring-gray-200/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
                <div id="slider"  class="flex gap-6 md:gap-8 overflow-x-auto px-12 py-4 scrollbar-hide scroll-smooth">
                    @foreach ($jurusan as $i => $jrsn )
                    <a href="jurusan/{{ $jrsn->id }}">
                        <div data-aos="fade-up"
                            data-aos-delay="{{ 12-$i*2 }}00"
                            data-aos-duration="700"
                             class="shadow-lg p-4 rounded-lg w-48 h-full text-center justify-between flex flex-col items-center bg-white dark:bg-gray-800">
                            <div class="flex justify-center items-center mb-4 w-12 h-12 rounded-full bg-gray-300 lg:h-24 lg:w-24 dark:bg-gray-200">
                                <img class="h-16" src="{{ asset("storage/".$jrsn->icon) }}" alt="{{ $jrsn->name }}">
                            </div>
                            <h3 class="mb-2 text-xl font-bold dark:text-white">{{ $jrsn->name }}</h3>
                        </div>
                    </a>
                    @endforeach
                </div>   
                </div>
            </div>
          </section>
        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
                <div class="max-w-screen-md mx-auto mb-8 lg:mb-16">
                    <h2 class="mb-4 text-center text-3xl md:text-4xl tracking-tight font-extrabold text-yellow-400 dark:text-white">Ekstrakulikuler Di  SMKS 
                        Wahid Hasyim  Glagah</h2>
                    <p class="text-gray-500 text-center sm:text-xl dark:text-gray-400">Pilihan Ekstrakulikuler di SMK Wahid Hasyim Glagah</p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-y-4 md:gap-12  md:space-y-0">
                    @foreach ($ekstrakulikuler as $i => $extra )
                    <div data-aos="@php
                        if ($i == 0 or $i==2) {
                            echo "fade-up-left";
                        }elseif ($i == 1 or $i == 3) {
                            echo "fade-up-right";
                        }elseif ($i == 4 or $i == 5) {
                            echo "fade-down-left";
                        }else {
                            echo "fade-down-right";
                        }
                    @endphp"
                    data-aos-easing="ease-out-cubic"
                    data-aos-duration="2000"
                    class="shadow-lg mx-auto p-3 rounded-lg w-48 md:w-64 text-center flex flex-col items-center bg-white dark:bg-gray-800">
                        <div class="flex justify-center items-center mb-4 w-12 h-12 rounded-full bg-blue-100 lg:h-24 lg:w-24 dark:bg-gray-200">
                            <img class="w-16" src="{{ asset("storage/".$extra->image) }}" alt="">
                        </div>
                        <h3 class="mb-2 text-xl font-bold dark:text-white">{{ $extra->nama }}</h3>
                    </div>
                    @endforeach
                </div>
            </div>
          </section>
        <section class="bg-blue-100 dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
                <div class="max-w-screen-md mx-auto mb-8 lg:mb-16">
                    <h2 class="mb-4 text-center text-3xl md:text-4xl tracking-tight font-extrabold text-blue-700 dark:text-white">Berita Terbaru Di  SMKS Wahid Hasyim Glagah</h2>
                    <p class="text-black text-center sm:text-xl dark:text-gray-400">Berita Terbaru Tentang SMK Wahid Hasyim Glagah</p>
                </div>
                <div class="space-y-8 md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-12 md:space-y-0">
                    @foreach ($beritas as $i => $berita )
                    <div data-aos="{{ $i%2==0 ? "zoom-in" : "zoom-out" }}" data-aos-duration="2000" class="max-w-sm bg-white border border-gray-200 overflow-hidden rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                        <a class=" overflow-hidden" href="/post/{{ $berita->id }}">
                            <img class="h-80 w-96 object-cover" src="{{ asset("storage/".$berita->image) }}" alt="" />
                        </a>
                        <div class="p-5">
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $berita->title }}</h5>
                            </a>
                            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ Str::limit($berita->content,80) }}</p>
                            <a href="/post/{{ $berita->id }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Selengkapnya
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="px-auto mt-8 md:mt-16 text-center">
                    <a href="/berita" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-yellow-500 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Baca Lainnya
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                        </svg>
                        
                    </a>
                </div>
            </div>
          </section>


          <!-- Team start -->
		<div id="team" class="section relative pt-20 pb-8 md:pt-16 bg-white dark:bg-gray-800">
            <div class="container xl:max-w-6xl mx-auto px-4">
              <!-- section header -->
              <header class="text-center mx-auto mb-12">
                <h2 class="mb-4 text-center text-3xl md:text-4xl tracking-tight font-extrabold text-blue-700 dark:text-white">Alumni Kita</h2>
              </header><!-- end section header -->
              
              <!-- row -->
              <div class="flex flex-wrap flex-row -mx-4 justify-center">
                @foreach ($alumnis as $i => $alumni)  
                <div class="flex-shrink max-w-full px-4 w-2/3 sm:w-1/2 md:w-5/12 lg:w-1/5 xl:px-5">
                    <div class="relative overflow-hidden bg-white dark:bg-gray-800 mb-12 " >
                        <!-- team block -->
                        <div data-aos="flip-left" data-aos-delay="{{ $i*2 }}00" data-aos-duration="2000" class="relative overflow-hidden px-6">
                            <img src="{{ asset('storage/'.$alumni->image) }}" class="max-w-full h-auto mx-auto rounded-full bg-gray-50" alt="{{ $alumni->name }}">   
                        </div>
                        <div class="pt-6 text-center">
                        <p class="text-lg leading-normal font-bold mb-1">{{ $alumni->name }}</p>
                            <p class="text-gray-500 leading-relaxed font-light">{{ $alumni->pekerjaan }} di {{ $alumni->tempatKerja }}</p>
                            
                        </div>
                    </div><!-- end team block -->
                </div>
                @endforeach
                <div class="flex-shrink max-w-full px-4 w-2/3 sm:w-1/2 md:w-5/12 lg:w-1/5 xl:px-5">
                    <a href="/alumni">
                    <div class="relative overflow-hidden bg-white dark:bg-gray-800 mb-12 " >
                        <!-- team block -->
                        <div data-aos="flip-left" data-aos-delay="{{ $i*2 }}00" data-aos-duration="2000" class="relative overflow-hidden px-6">
                            <img src="{{ asset('images/Alumni Lainnya.png') }}" class="max-w-full h-auto mx-auto rounded-full bg-gray-50" alt="{{ $alumni->name }}">   
                        </div>
                        <div class="pt-6 text-center">
                        <p class="text-lg leading-normal font-bold mb-1">Alumni Lainnya</p>
                            
                        </div>
                    </div><!-- end team block -->
                </a>
                </div>
              </div><!-- end row -->
            </div>
          </div>


          <section class="bg-white dark:bg-gray-900">
            <d class="py-8 px-4 mx-auto max-w-screen-xl sm:py-16 lg:px-6">
                <div class="max-w-screen-md mx-auto mb-4 lg:mb-4">
                    <h2 class="mb-4 text-center text-3xl md:text-4xl tracking-tight font-extrabold text-yellow-500 dark:text-white">Kerjasama</h2>
                </div>
                    <div class="flex flex-wrap items-center justify-center pt-4 sm:pt-4">
                        @foreach ($kerjasamas as $number => $kerjasama)
                        <span class="m-8 block">
                            <img
                              data-aos="{{ $number%2==0 ? "fade-up" : "fade-down" }}"
                              {{-- data-aos-delay="{{ $number*2 }}00" --}}
                              data-aos-duration="2000"  
                              data-popover-target="popover-image-{{$number}}"
                              src="{{ asset('storage/'.$kerjasama->image) }}"
                              alt="client logo"
                              class="mx-auto block h-16 w-auto grayscale dark:grayscale opacity-80 hover:opacity-100 hover:grayscale-0"/>
                            <div data-popover id="popover-image-{{ $number }}" role="tooltip" class="absolute z-10 invisible inline-block text-center text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $kerjasama->nama_perusahaan }}</h3>
                                </div>
                                <div data-popper-arrow></div>
                            </div>
                        </span>
                        @endforeach
                    </div>
                
            </div>
          </section>

@include('templates.footer')

