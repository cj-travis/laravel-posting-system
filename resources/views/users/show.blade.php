<x-layout :title="'Profile'">
     {{-- Session messages --}}
    @if (session('success'))
        <x-flashMsg msg="{{ session('success') }}" bg="bg-green-500"/>
    @endif

    @if (session('failed'))
        <x-flashMsg msg="{{ session('failed') }}" bg="bg-red-500"/>
    @endif

    {{-- back button --}}
    <a href="{{ route('posts') }}" class="block mb-2 text-xs text-blue-500">&larr;Go back to home</a>

    <h1 class="title">{{ $user->username }}'s Profile</h1>

    {{-- display profile details --}}
    <div 
        class="card flex flex-col mt-4 h-fit justify-center gap-12"
        x-data="{ open: false }" 
        x-init="open = @json($errors->has('password') || $errors->has('delete_account'))">
        <div class="flex flex-row gap-12 justify-center items-center ">
            <div class="w-[250px]">

                {{-- profile picture --}}
                @if ($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="" class="aspect-square rounded-full object-cover">
                    
                @else
                    <img src="{{ asset('storage/profile_pictures/default_pfp.jpg') }}" alt="" class="aspect-square rounded-full object-cover">
                    
                @endif
            </div>

            {{-- display id, name, email and date joined --}}
            <div class="flex flex-col h-fit my-auto gap-2 md:gap-0">
                <div class="flex flex-row">
                    <span class="text text-slate-600">Id: &nbsp;</span>
                    <span class="text text-slate-600">{{ $user->id }}</span>
                </div>
                <div class="flex flex-col md:flex-row">
                    <span class="text text-slate-600">Name: &nbsp;</span>
                    <span>{{ $user->username }}</span>
                </div>
                <div class="flex flex-col md:flex-row">
                    <span class="text text-slate-600">Email: &nbsp;</span>
                    <span>{{ $user->email }}</span>
                </div>
                <div class="flex flex-col md:flex-row">
                    <span class="text text-slate-600">Joined since: &nbsp;</span>
                    <span>{{ $user->created_at->format('d F Y') }}</span>
                </div>
            </div>
        </div>
    
    {{-- if the user profile is the logged in user profile --}}
    @if ($user == Auth::user())
        <div class="h-fit flex flex-row gap-2">
                <a href="{{ route('user.edit', $user) }}" class="btn text text-center flex flex-col items-center justify-center">Edit</a>
                <a href="{{ route('userpassword.reset', $user->id) }}" class="btn text text-center flex flex-col items-center justify-center">Reset Password</a>
                <button class="btn text" @click="open = true">Delete Account</button>
            </div>

            <div x-show="open" x-transition class="fixed inset-0 bg-slate-700 z-10 flex justify-center items-center" style="background-color: rgba(0, 0, 0, 0.5);" @click.away="open = false;">
                <div  class="bg-white p-6 rounded-lg shadow-lg w-96">
                    <div class="flex flex-row w-full justify-between gap-2 mb-2">
                        <span class="title">Delete Account</span>
                        <i class="fa-solid fa-xmark" @click="open = !open" x-show="open"></i>

                    </div>
                    {{-- DELETE FORM --}}
                    <form action="{{ route('user.destroy', $user) }}" method="post">
                        @csrf
                        @method('DELETE')

                        {{-- Password --}}
                        <div class="mb-4">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="input @error('password') ring-red-500 @enderror">
                            @error('password')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Confirm Delete --}}
                        <div class="mb-4">
                            <label for="delete_account">Type "delete" to confirm</label>
                            <input type="text" placeholder="delete" name="delete_account" class="input @error('delete_account') ring-red-500 @enderror">
                            @error('delete_account')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        <button class="btn">Confirm</button>
                    </form>
                    
                </div>
            </div>
        @endif
    </div>

    {{-- hide posts if user is blocked --}}
    @if ($user->status == 'blocked')
        <div class="w-full bg-red-500 p-2 my-2 rounded">This user is blocked</div>
    @else
        {{-- User posts --}}
        <h2 class="mt-6 mb-2">{{ $user->username }}'s posts ({{ $posts->total() }})</h2>

        
            @if ($posts->count() == 0)
            <div class="w-full flex">
                <span class="w-fit mx-auto my-6 text-center">No results found</span>
            @else
            <div class="mb-4 md:grid md:grid-cols-2 md:gap-6 w-full">
                @foreach ($posts as $post)

                    <div class="card my-2 md:my-0">
                        <x-postCard :post="$post"/>
                    </div>
                @endforeach
            @endif
            
        </div>

        <div>
            {{ $posts->links() }}
        </div>
    @endif
    
</x-layout>