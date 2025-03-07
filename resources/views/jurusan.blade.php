@include('templates.header')
@include('templates.nav')

    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
  <div class="pt-16 lg:pt-20">
    <div class="border-b border-grey-lighter pb-8 sm:pb-12">
      <span
        class="mb-5 inline-block rounded-full bg-green-400 px-2 py-1 font-body text-sm text-green sm:mb-8"
        >{{ $jurusan->name }}</span
      >
      <div class="flex gap-12 flex-col sm:flex-row">
      <img class="h-64" src="{{ asset('storage/'.$jurusan->icon) }}" alt="">

      
      <div class="flex flex-col  pt-5 sm:pt-8">
        <h2
        class="block font-body mb-8 text-3xl font-semibold leading-tight text-primary dark:text-white sm:text-4xl md:text-5xl"
      >
        {{ $jurusan->name }}
      </h2>
        {{-- <p class="pr-2 font-body font-light text-primary dark:text-white">
        {{-- {{ $jurusan->slug }} --}}
        </p>
        <span class="dark:text-white font-body text-grey"></span> 
        <p class="prose pl-2 font-body font-light text-primary dark:text-white">
          {!! $jurusan->description !!}
        </p>
      </div>
      </div>
    </div>

<article class="prose">
  <h2 class="mb-4 mt-6 text-2xl tracking-tight font-extrabold text-gray-900 dark:text-white">Kompetensi / Materi Yang Diajarkan</h2>
    {!! $jurusan->kompetensi !!}
</article>
<article class="prose mb-6">
  <h2 class="mb-4 text-2xl tracking-tight font-extrabold text-gray-900 dark:text-white">Profesi / Bidang Kerja</h2>
    {!! $jurusan->prospek_kerja !!}
</article>
<img class="w-1/2" src="{{ asset("storage/".$jurusan->gambar) }}" alt="">

    </div>

    <div class="flex items-center py-10">
      <span class="pr-5 font-body font-medium text-primary dark:text-white"
        >Share</span
      >
      <a href="/">
        <i
          class="bx bxl-facebook text-2xl text-primary transition-colors hover:text-secondary dark:text-white dark:hover:text-secondary"
        ></i
      ></a>
      <a href="/">
        <i
          class="bx bxl-twitter pl-2 text-2xl text-primary transition-colors hover:text-secondary dark:text-white dark:hover:text-secondary"
        ></i>
      </a>
      <a href="/">
        <i
          class="bx bxl-linkedin pl-2 text-2xl text-primary transition-colors hover:text-secondary dark:text-white dark:hover:text-secondary"
        ></i
      ></a>
      <a href="/">
        <i
          class="bx bxl-instagram-alt pl-2 text-2xl text-primary transition-colors hover:text-secondary dark:text-white dark:hover:text-secondary"
        ></i
      ></a>
      <a href="/">
        <i
          class="bx bxl-whatsapp-square pl-2 text-2xl text-primary transition-colors hover:text-secondary dark:text-white dark:hover:text-secondary"
        ></i
      ></a>
    </div>
  </div>
</div>
</div>



@include('templates.footer')      