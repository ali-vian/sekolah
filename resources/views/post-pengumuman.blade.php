@include('templates.header')
@include('templates.nav')

    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
  <div class="pt-16 lg:pt-20">
    <div class="border-b border-grey-lighter pb-8 sm:pb-12">
      <span
        class="mb-5 inline-block rounded-full bg-green-400 px-2 py-1 font-body text-sm text-green sm:mb-8"
        >{{ $post->category }}</span
      >
      <h2
        class="block font-body text-3xl font-semibold leading-tight text-primary dark:text-white sm:text-4xl md:text-5xl"
      >
        {{ $post->title }}
      </h2>
      <div class="flex items-center pt-5 sm:pt-8">
        <p class="pr-2 font-body font-light text-primary dark:text-white">
        
        </p>
        <span class="vdark:text-white font-body text-grey"> </span>
        <p class="pl-2 font-body font-light text-primary dark:text-white">
          {{ $post->created_at->diffForHumans() }}
        </p>
      </div>
    </div>
  
    {!! str($post->content)->sanitizeHtml() !!}

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