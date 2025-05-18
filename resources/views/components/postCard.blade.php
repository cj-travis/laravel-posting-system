@props(['post', 'full' => false])

{{-- different parent layout if users view full post (not as card but as a whole page) --}}
@if ($full)
    <div class="w-full flex flex-col gap-2 h-fit">
@else
    <div class="w-full flex flex-col sm:flex-row md:flex-col xl:flex-row gap-2 h-fit">
@endif

    {{-- if has image or not view posts as full --}}
    @if ($post->image && $full == false)
        <div class="w-full sm:w-[70%] md:w-full xl:w-[70%] flex flex-col h-[100%] justify-between">
    @else
        <div class="justify-between">
    @endif
        <div class="h-fit">
            {{-- title --}}
            <h1 class="font-semibold">{{ $post->title }}</h1>

            {{-- Author and Date --}}
            <div class="text-xs font-light mb-4">
                    <span>Posted {{ $post->created_at->DiffForHumans() }} by </span>
                <a href="{{ route('user.show', $post->user) }}" class="text-blue-500 font-medium">{{ $post->user->username }}</a>
            </div>

            {{-- display image if exist --}}
            @if ($post->image && !$full)
                <img class="block sm:hidden md:block xl:hidden w-full sm:w-[30%] md:w-full xl:w-[30%] object-cover max-h-[200px] rounded-lg mb-2" src="{{ asset('storage/' . $post->image) }}" alt="">
            @endif
           
            {{-- body --}}
            @if ($full)
                <div class="text-sm">
                    <span>{{ $post->body }}</span>
                </div>
                @if ($post->image || $full)
                    <img class="w-fit object-cover max-h-[200px] rounded-lg mt-2" src="{{ asset('storage/' . $post->image) }}" alt="">
                @endif
            @else
                <span class="text">{{ Str::words($post->body, 15) }}</span>
                <a href="{{ route('posts.show', $post) }}" class="text-blue-500 text">Read more &rarr;</a>
            @endif
            
        </div>
        
        {{-- smaller mobile and tablet --}}
        <div class="mb-0 mt-auto py-2">

            @if (Route::currentRouteName() === 'dashboard')
                {{-- buttons --}}
                <div class="mt-1 flex flex-row h-fit gap-1">
                    
                    {{-- UPDATE --}}
                    <a href="{{ route('posts.edit', $post) }}" class="bg-green-500 text-white px-2 py-1 text-xs rounded-md hover:opacity-[0.8]">Update</a>
                    
                    {{-- DELETE --}}
                    <form action="{{ route('posts.destroy', $post) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 text-white px-2 py-1 text-xs rounded-md hover:opacity-[0.8]">Delete</button>
                    </form>
                </div>
            @else
                <div class="flex flex-row gap-3 pt-0 mt-auto mb-0 h-full">
                    <input type="text" value="{{ route('posts.show', $post->id) }}" id="copyLink" readonly class="copyLink opacity-0 absolute -z-1">

                    @auth
                        <div class="flex flex-row gap-1">
                            @if (!Auth::user()->likes()->where('post_id', $post->id)->exists())
                            <form action="{{ route('like.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}"/>
                                <button class="cursor-pointer"><i class="fa-regular fa-heart fa-lg"></i></button>
                            </form>
                            @else
                                @php
                                    // Retrieve the like object if it exists for the current user and post
                                    $like = Auth::user()->likes()->where('post_id', $post->id)->first();
                                @endphp

                                <form action="{{ route('like.destroy', $like) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="cursor-pointer"><i class="fa-solid fa-heart fa-lg text-red-500"></i></button>
                                </form>
                            @endif
                            <span class="text-slate-900 m-0">{{ $post->likes }}</span>
                        </div>
                    @endauth

                    @guest
                        <div class="flex flex-row gap-1">
                            <form action="{{ route('like.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}"/>
                                <button class="cursor-pointer"><i class="fa-regular fa-heart fa-lg"></i></button>
                            </form>
                            <span class="text-slate-900 m-0">{{ $post->likes }}</span>
                        </div>
                    @endguest
                        <a href="{{ route('posts.show', $post->id) }}"><i class="fa-regular fa-comment fa-lg"></i></a>
                        
                    
                    <button id="copyButton" class="copyButton m-0 p-0 inline-flex items-center"><i class="fa-solid fa-share-nodes fa-lg"></i></button>
                </div>
            @endif
        </div>

    </div>
    

    {{-- display image if exist --}}
    @if ($post->image  && !$full)
        <img class="hidden sm:block md:hidden xl:block w-full sm:w-[30%] md:w-full xl:w-[30%] object-cover max-h-[200px] rounded-lg" src="{{ asset('storage/' . $post->image) }}" alt="">
    @endif
    
</div>