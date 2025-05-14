@props(['post', 'full' => false])

@if ($full)
    <div class="w-full flex flex-col gap-2 h-fit">
@else
    <div class="w-full flex flex-row md:flex-col xl:flex-row gap-2 h-fit">
@endif


    @if ($post->image && $full == false)
        <div class="w-[70%] md:w-full xl:w-[70%] flex flex-col h-[100%] justify-between">
    @else
        <div class="justify-between">
    @endif
        <div class="h-fit">
            {{-- title --}}
            <h1>{{ $post->title }}</h1>

            {{-- Author and Date --}}
            <div class="text-xs font-light mb-4">
                    <span>Posted {{ $post->created_at->DiffForHumans() }} by </span>
                <a href="" class="text-blue-500 font-medium">{{ $post->user->username }}</a>
            </div>

            {{-- body --}}
            @if ($full)
                <div class="text-sm">
                    <span>{{ $post->body }}</span>
                </div>
            @else
                <span class="text">{{ Str::words($post->body, 15) }}</span>
                <a href="{{ route('posts.show', $post) }}" class="text-blue-500 text">Read more &rarr;</a>
            @endif
        </div>
        

        <div class="block md:hidden xl:block mt-auto mb-0 py-2">
            {{ $slot }}
        </div>

    </div>
    

    {{-- image --}}
    @if ($post->image)
        <img class="w-[30%] md:w-full xl:w-[30%] object-cover max-h-[200px]" src="{{ asset('storage/' . $post->image) }}" alt="">
    @endif
    

    <div class="hidden md:block xl:hidden h-full mb-0 mt-auto py-2">
        {{ $slot }}
    </div>

</div>