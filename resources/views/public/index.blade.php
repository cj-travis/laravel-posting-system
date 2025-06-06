<x-layout :title="'Home'">
    {{-- landing page --}}
    <div class="flex flex-col w-full mx-auto h-[calc(100dvh-150px)] justify-center items-center">

      <div class="flex flex-col w-fit mx-auto h-full justify-center items-center">
        <div class="text-5xl md:text-[70px] font-cal text-[#12d30f] w-fit mx-auto text-shadow-md mb-0 leading-20 flex flex-row fadeIn-animation">
          <div class="hop-animation leading-none"><span>Save</span></div>
          <div class="leading-none"><span>N</span></div>
          <div class="hop-animation2 leading-none"><span>Share</span></div>
        </div>

        <div class="flex flex-col justify-center items-center">
          <p class="text-base md:text-[22px] text-center">Your only posting system, <span class="text-[#12d30f]">save</span> your posts here and <span class="text-[#12d30f]">share</span> it with others!</p>
          <a href="{{ route('dashboard') }}" class="button rounded-4xl text-white bg-[#12d30f] p-5 mt-7 mb-3 shadow-xl transition delay-100 duration-200 ease-in-out hover:-translate-y-1 hover:shadow-xl/20 ">Create your first post!</a>
          <p class="text-sm">Remember, Sharing is Caring <span class="text-red-500">❤</span></p>

        </div>

        
      </div>
      <div class="mt-auto mb-0 flex flex-col justify-center items-center">
        <span class="text-sm mb-2">Scroll to see top posts!</span>
        <i class="fa-solid fa-arrow-down animate-bounce"></i>
      </div>
      
    </div>

    {{-- top posts, for now is top 6 post --}}
    <div class="mt-12 md:grid md:grid-cols-2 md:gap-6">
        @foreach ($posts as $post)

            <div class="card my-2 md:my-0">
                <x-postCard :post="$post"/>
                
            </div>
        @endforeach
    </div>

    {{-- redirect to view all posts --}}
    <a href="{{ route('posts') }}" class="hover:underline flex w-fit mx-auto mt-2 mb-6 text">See more</a>
    
</x-layout>