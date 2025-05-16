<x-layout>
     {{-- Session messages --}}
    @if (session('success'))
        <x-flashMsg msg="{{ session('success') }}" bg="bg-green-500"/>
    @endif

    @if (session('failed'))
        <x-flashMsg msg="{{ session('failed') }}" bg="bg-red-500"/>
    @endif

    <a href="{{ route('posts') }}" class="block mb-2 text-xs text-blue-500">&larr;Go back to home</a>

    <h1 class="title">{{ $user->username }}'s Profile</h1>

    <div class="card flex flex-col mt-4 h-fit justify-center gap-12" x-data="{ open: {{ session('modalOpen') ? 'true' : 'false' }} }">
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
        
    @if ($user == Auth::user())
        <div class="h-fit flex flex-row gap-2">
                <a href="{{ route('user.edit', $user) }}" class="btn text text-center flex flex-col items-center justify-center">Edit</a>
                <a href="{{ route('userpassword.reset', $user->id) }}" class="btn text text-center flex flex-col items-center justify-center">Reset Password</a>
                <button class="btn text" @click="open = true">Delete Account</button>
            </div>

            <div x-show="open" x-transition class="fixed inset-0 bg-slate-700 z-10 flex justify-center items-center" style="background-color: rgba(0, 0, 0, 0.5);" @click.away="open = false; $wire.set('modalOpen', false)">
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

    {{-- User posts --}}
    <h2 class="mt-6">{{ $user->username }}'s posts ({{ $posts->total() }})</h2>

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
                                <a href=""><i class="fa-regular fa-heart fa-lg"></i></a>
                                <a href="{{ route('posts.show', $post->id) }}"><i class="fa-regular fa-comment fa-lg"></i></a>
                                <button id="copyButton" class="copyButton m-0 pt-0 inline-flex items-center cursor-pointer"><i class="fa-solid fa-share-nodes fa-lg"></i></button>
                            @endauth
                            
                            @guest
                                <button id="copyButton" class="copyButton m-0 pt-2 inline-flex items-center cursor-pointer"><i class="fa-solid fa-share-nodes fa-lg"></i></button>
                                
                            @endguest
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