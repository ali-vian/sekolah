@include("templates.header")
@include("templates.nav")

@php
    use Illuminate\Support\Str;
@endphp

<section class="bg-white mt-12 dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
            <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Semua Alumni</h2>
                    
        <form class="max-w-md mx-auto" method="GET" action="/alumni/search">   
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="search" name="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search ..." />
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>
        </div> 
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
          </div>
          <div class="my-6">
            {{ $alumnis->links() }}
          </div>
    </div>
  </section>

@include("templates.footer")