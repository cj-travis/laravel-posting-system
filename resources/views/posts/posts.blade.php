<x-layout>
    <div class="w-full flex flex-row justify-between">
        <h1 class="title">All Posts ({{ $posts->total() }})</h1>

        <form method="GET" action="{{ route('posts') }}" class="flex gap-2">
            
            <select name="sort" id="sort" class="px-2">
                <option value="new" {{ request('sort') === 'new' ? 'selected' : '' }}>Newest</option>
                <option value="old" {{ request('sort') === 'old' ? 'selected' : '' }}>Oldest</option>
                <option value="like" {{ request('sort') === 'like' ? 'selected' : '' }}>Most Liked</option>
            </select>
            
            <button type="submit" class="px-2 rounded bg-blue-500 text-white">Sort</button>
        </form>
    </div>

    <form method="GET" action="{{ route('posts') }}" class="my-4 w-full flex flex-row gap-2">
        <input type="text" name="search" placeholder="Search posts..." class="border rounded p-1 w-[60%] lg:w-[80%] px-2" value="{{ request('search') }}">
        <button type="submit" class="btn px-4 py-1 rounded-md w-[40%] lg:w-[20%]">Search</button>
    </form>


    <div class="mb-4 md:grid md:grid-cols-2 md:gap-6">
        @if ($posts->count() == 0)
            <div class="w-fit mx-auto my-12"><span>No results found</span></div>
        @else
            @foreach ($posts as $post)

                <div class="card my-2 md:my-0">
                    <x-postCard :post="$post">
                        <input type="text" value="{{ route('posts.show', $post->id) }}" id="copyLink" readonly class="copyLink opacity-0 absolute -z-1">

                        <div class="flex flex-row gap-3 pt-0 mt-auto mb-0 h-full">
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

                                <a href="{{ route('posts.show', $post->id) }}"><i class="fa-regular fa-comment fa-lg"></i></a>
                            @endauth
                        
                            <button id="copyButton" class="copyButton m-0 p-0 inline-flex items-center cursor-pointer"><i class="fa-solid fa-share-nodes fa-lg"></i></button>
                        </div>

                    </x-postCard>
                </div>
            @endforeach
        @endif
        
    </div>

    <div>
        {{ $posts->links() }}
    </div>
</x-layout>