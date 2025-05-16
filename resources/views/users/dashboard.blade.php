<x-layout>
    {{-- Session messages --}}
    @if (session('success'))
        <x-flashMsg msg="{{ session('success') }}" bg="bg-green-500"/>

    @elseif (session('deleted'))
        <x-flashMsg msg="{{ session('deleted') }}" bg="bg-red-500"/>
    @endif

    <h1 class="title">Dashboard</h1>
    <h3 class="text text-slate-400">Welcome back, {{ $user->username }}</h3>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="card my-6">
        <p>What's on your mind?</p>
        @csrf

         {{-- Post title --}}

            <div class="mb-4">
                <label for="title">Post Title</label>

                <input type="text" name="title" class="input @error('title') ring-red-500 @enderror" value={{ old('title') }}>
                
                @error('title')
                    <p class="error">{{ $message }}</p>
                @enderror

            </div>

            {{-- Post Body --}}
            
            <div class="mb-4">
                <label for="body">Post Content</label>

                <textarea name="body" cols="30" rows="4" class="input @error('body') ring-red-500 @enderror">{{ old('body') }}</textarea>
                
                @error('body')
                    <p class="error">{{ $message }}</p>
                @enderror

            </div>

            {{-- Post Image --}}
            <div class="mb-4">
                <label for="image">Photo</label>
                <input type="file" name="image" id="image">

                @error('image')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>


            {{-- Submit button --}}
            <button class="btn">Create</button>

    </form>

    <div class="my-6">
         

        <h2>Your latest posts ({{ $posts->total() }})</h2>

        <form method="GET" action="{{ route('dashboard') }}" class="my-4 w-full flex flex-row gap-2">
            <input type="text" name="search" placeholder="Search posts..." class="border rounded p-1 px-2 w-[60%] lg:w-[80%]" value="{{ request('search') }}">
            <button type="submit" class="btn px-4 py-1 rounded-md w-[40%] lg:w-[20%]">Search</button>
        </form>

        <div class="my-2 md:grid md:grid-cols-2 md:gap-6">
            @foreach ($posts as $post)

                <div class="card md:my-0">

                    {{-- postCard --}}
                    <x-postCard :post="$post">

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
                    </x-postCard>
                    
                </div>
            @endforeach
        </div>

        <div>
            {{$posts->links()}}
        </div>
    </div>
</x-layout>