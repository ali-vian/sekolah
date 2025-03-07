@include('templates.header')
@include('templates.nav')

<main class="pt-8 pb-16 lg:pt-16 mt-12 lg:pb-24 bg-white dark:bg-gray-900 antialiased">
    <div class="flex justify-between  px-4 mx-auto max-w-screen-xl mb-8 lg:mb-16">
        <article class="mx-auto w-full  format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
            <div class="flex gap-4 lg:gap-8 flex-col-reverse lg:flex-row items-center">
                <header class=" lg:mb-6 not-format">
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">Visi SMKS Wahid Hasyim Glagah</h1>
                    <article class="prose dark:prose-invert">{!! $about->sambutan !!}</article>
                </header>
                <img class="w-full sm:w-max sm:h-96 rounded" src="{{ asset("storage/".$about->gambar_sejarah) }}" alt="">
            </div>
        </article>
    </div>
    <div class="flex justify-between  px-4 mx-auto max-w-screen-xl mb-8 lg:mb-16">
        <article class="mx-auto w-full  format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
            <div class="flex gap-4 lg:gap-8 flex-col lg:flex-row items-center">
                <img class="w-full sm:w-max sm:h-96 rounded" src="{{ asset("storage/".$about->gambar_visi) }}" alt="">
                <header class=" lg:mb-6 not-format">
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">Visi SMKS Wahid Hasyim Glagah</h1>
                    <article class="prose dark:prose-invert">{!! $about->visi !!}</article>
                </header>
            </div>
        </article>
    </div>
    <div class="flex justify-between  px-4 mx-auto max-w-screen-xl">
        <article class="mx-auto w-full  format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
            <div class="flex gap-4 lg:gap-8 flex-col-reverse lg:flex-row items-center">
                <header class=" lg:mb-6 not-format lg:w-1/2">
                    <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">Misi SMKS Wahid Hasyim Glagah</h1>
                    <article class="prose dark:prose-invert">
                        {!! $about->misi !!}
                    </article>
                </header>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3786.7497480307065!2d112.49049459727789!3d-7.064048569107127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e77fb1137b7b891%3A0x6313f0f6363e18f9!2sSMK%20Wahid%20Hasyim%20Glagah%20Lamongan!5e1!3m2!1sid!2sid!4v1739890557930!5m2!1sid!2sid"  class="w-[400px] h-[300px] lg:w-[600px] lg:h-[450px]" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                {{-- <iframe class="h-96 rounded"  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3786.7497480307065!2d112.49049459727789!3d-7.064048569107127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e77fb1137b7b891%3A0x6313f0f6363e18f9!2sSMK%20Wahid%20Hasyim%20Glagah%20Lamongan!5e1!3m2!1sid!2sid!4v1739890557930!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
            </div>
        </article>
    </div>
  </main>
  <aside aria-label="Related articles" class="py-8 lg:py-24 bg-gray-50 dark:bg-gray-800">
    <div class="px-4 mx-auto max-w-screen-xl">
        <h2 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">New articles</h2>
        <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($beritas as $berita) 
            <article class="max-w-xs">
                <a href="/post/{{ $berita->id}}">
                    <div class="h-48 overflow-hidden rounded-lg mb-5 ">
                        <img src="{{ asset("storage/".$berita->image) }}"  alt="Image 1">
                    </div>
                </a>
                <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                    <a href="/post/{{ $berita->id}}">{{ Str::limit($berita->title,24) }}</a>
                </h2>
                <p class="mb-4 text-gray-500 dark:text-gray-400">{{ Str::limit($berita->content,65) }}</p>
                <a href="/post/{{ $berita->id}}" class="inline-flex items-center font-medium underline underline-offset-4 text-primary-600 dark:text-primary-500 hover:no-underline">
                    Read in 2 minutes
                </a>
            </article>
            @endforeach
        </div>
    </div>
  </aside>
@include('templates.footer')