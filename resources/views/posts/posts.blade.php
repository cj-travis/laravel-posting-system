<x-layout>
    <div class="w-full flex flex-row justify-between">
        {{-- display total posts --}}
        <h1 class="title">All Posts ({{ $posts->total() }})</h1>

        {{-- Post filter dropdown --}}
        <form method="GET" action="{{ route('posts') }}" class="flex gap-2">
            
            {{-- dropdown --}}
            <select name="sort" id="sort" class="px-2">
                <option value="new" {{ request('sort') === 'new' ? 'selected' : '' }}>Newest</option>
                <option value="old" {{ request('sort') === 'old' ? 'selected' : '' }}>Oldest</option>
                <option value="like" {{ request('sort') === 'like' ? 'selected' : '' }}>Most Liked</option>
            </select>
            
            {{-- sort button --}}
            <button type="submit" class="px-2 rounded bg-blue-500 text-white">Sort</button>
        </form>
    </div>

    {{-- post searchbar --}}
    <form method="GET" action="{{ route('posts') }}" class="my-4 w-full flex flex-row gap-2">
        <input type="text" name="search" placeholder="Search posts..." class="border rounded p-1 w-[60%] lg:w-[80%] px-2" value="{{ request('search') }}">
        <button type="submit" class="btn px-4 py-1 rounded-md w-[40%] lg:w-[20%]">Search</button>
    </form>

    {{-- if no results are found --}}
    @if ($posts->count() == 0)
        <div class="w-full flex flex-col">
            <span class="w-fit mx-auto my-6">No results found</span>
        </div>
    {{-- display filtered results --}}
    @else
        <div class="mb-4 md:grid md:grid-cols-2 md:gap-6 w-full">
            @foreach ($posts as $post)

                <div class="card my-2 md:my-0">
                    <x-postCard :post="$post"/>
                </div>
            @endforeach
        </div>
    @endif
        
    {{-- pagination links --}}
    <div>
        {{ $posts->links() }}
    </div>
</x-layout>