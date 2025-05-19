<x-layout :title="'Edit Post'">
    {{-- back to dashboard --}}
    <a href="{{ route('dashboard') }}" class="block mb-2 text-xs text-blue-500">&larr;Go back to your dashboard</a>

    <h1 class="title">Edit Post</h1>

    <div class="card">
        <form action="{{ route('posts.update', $post) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
    
            {{-- Update title --}}
    
            <div class="mb-4">
                <label for="title">Post Title</label>
    
                <input type="text" name="title" class="input @error('title') ring-red-500 @enderror" value="{{ old('title', $post->title) }}">
                
                @error('title')
                    <p class="error">{{ $message }}</p>
                @enderror
    
                
            </div>
            
            {{-- Update content --}}
            <div class="mb-4">
                <label for="body">Post Content</label>
    
                <textarea name="body" id="" rows="4" class="input @error('body') ring-red-500 @enderror">{{ $post->body }}</textarea>
                
                @error('body')
                    <p class="error">{{ $message }}</p>
                @enderror
    
            </div>

            {{-- current Image --}}
            @if ($post->image)
                <label>Current Cover Photo</label>

                <div class="rounded-md mb-4 w-1/4 object-cover overflow-hidden">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="post image">
                </div>
            @endif

            {{-- Post Image --}}
            <div class="mb-4">
                <label for="image">Cover photo</label>
                <input type="file" name="image" id="image">

                @error('image')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            
    
            {{-- Submit button --}}
            <button class="btn">Update</button>
    
        </form>
    </div>

    


</x-layout>