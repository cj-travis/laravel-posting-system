<x-layout>
    <div class="w-full flex flex-row justify-between">
        <h1 class="title">All Posts ({{ $posts->total() }})</h1>

        {{-- <select name="" id="">
            <option value="new">Newest</option>
            <option value="old">Oldest</option>
            <option value="like">Most Liked</option>
        </select> --}}

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
                        {{-- remeber to put the urllll --}}
                        <input type="text" value="{{ route('posts.show', $post->id) }}" id="copyLink" readonly class="copyLink opacity-0 absolute -z-1">

                        <div class="flex flex-row gap-3 pt-4 mt-auto mb-0 h-full">
                            @auth
                                <i class="fa-regular fa-heart fa-lg"></i>
                                <i class="fa-regular fa-comment fa-lg"></i>
                            @endauth
                            
                            {{-- <i class="fa-solid fa-share-nodes fa-lg"></i> --}}
                            <button id="copyButton" class="copyButton m-0 p-0 inline-flex items-center"><i class="fa-solid fa-share-nodes fa-lg"></i></button>
                        </div>

                    </x-postCard>
                </div>
            @endforeach
        @endif
        
    </div>

    <div>
        {{ $posts->links() }}
    </div>

    <script>
        document.querySelectorAll('.copyButton').forEach(function(button, index) {
        button.addEventListener('click', function() {
            // Get the input field that corresponds to this button
            var copyText = document.querySelectorAll('.copyLink')[index];
            
            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the input
            document.execCommand('copy');

            // Alert the user that the text has been copied
            alert("Link copied to clipboard: " + copyText.value);
        });
    });
    </script>
</x-layout>