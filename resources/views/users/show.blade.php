<x-layout>
    <h1 class="title">{{ $user->username }}'s Profile</h1>

    <div class="card flex flex-col mt-4 h-fit justify-center gap-12">
        <div class="flex flex-row gap-12">
            <div class="w-[250px]">
                @if ($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="" class="aspect-square rounded-full object-cover">
                    
                @else
                    <img src="{{ asset('storage/profile_pictures/default_pfp.jpg') }}" alt="" class="aspect-square rounded-full object-cover">
                    
                @endif
            </div>

            <div class="flex flex-col h-fit my-auto">
                <span>
                    Id: {{ $user->id }}
                </span>
                <span>
                    Name: {{ $user->username }}
                </span>
                <span>
                    Email: {{ $user->email }}
                </span>
            </div>
        </div>
        

        <div class="h-fit flex flex-row gap-2">
            <a href="{{ route('user.edit', $user) }}" class="btn text text-center">Edit</a>
            <button class="btn text">Reset Password</button>
            <button class="btn text">Delete Account</button>
        </div>
        
    </div>
</x-layout>