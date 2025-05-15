<x-layout>
    <a href="{{ route('user.show', $user) }}" class="block mb-2 text-xs text-blue-500">&larr;Go back to your profile</a>

    <h1>Edit Profile</h1>

    <div class="card">
        <form action="{{ route('user.update', $user) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
    
            {{-- Update username --}}
    
            <div class="mb-4">
                <label for="username">Username</label>
    
                <input type="text" name="username" class="input @error('username') ring-red-500 @enderror" value="{{ old('username', $user->username) }}">
                
                @error('username')
                    <p class="error">{{ $message }}</p>
                @enderror
    
                
            </div>
            
            {{-- Update Email --}}
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" class="input @error('email') ring-red-500 @enderror" value={{ old('email', $user->email) }}>
                
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror

            </div>

            {{-- current Image --}}
            @if ($user->profile_picture)
                <label>Current Profile Picture</label>

                <div class="rounded-md mb-4 w-1/4 object-cover overflow-hidden">
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="post image">
                </div>
            @endif

            {{-- Post Image --}}
            <div class="mb-4">
                <label for="image">Profile picture</label>
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