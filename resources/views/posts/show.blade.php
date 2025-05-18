<x-layout>

    {{-- Back button --}}
    @auth
        <a href="{{ route('posts') }}" class="block mb-2 text-xs text-blue-500">&larr; Back</a>
    @endauth

    @guest
        <a href="{{ route('index') }}" class="block mb-2 text-xs text-blue-500">&larr; Back</a>
    @endguest
    
    {{-- full post card --}}
    <x-postCard :post="$post" full='true' />

    {{-- divider (styling purposes) --}}
    <hr class="text-slate-300 mt-3"/>

        {{-- Session messages --}}
        @if (session('success'))
            <x-flashMsg msg="{{ session('success') }}" bg="bg-green-500"/>

        @elseif (session('deleted'))
            <x-flashMsg msg="{{ session('deleted') }}" bg="bg-red-500"/>
        @endif

    {{-- comment section --}}
    <div class="my-4">
        <h1 class="text">Comments</h1>

        @auth
            {{-- CREATE comment --}}
            <form action="{{ route('comment.store') }}" class="my-3" method="POST">
                @csrf

                <label for="body" class="text">Add your Comment</label>

                <div class="flex flex-row gap-2">
                    {{-- post id (hidden) --}}
                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                    {{-- comment --}}
                    <div class="flex-flex-col w-full">
                        <input type="text" name="body" class="input @error('body') r}ing-red-500 @enderror" value={{ old('body') }}>

                        @error('body')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- button --}}
                    <button class="btn max-w-[100px]">Send</button>
                </div>
                
            </form>
        @endauth

        <div class="my-2">
            {{-- display comments --}}
            @foreach ($comments as $comment)
                <div class="card my-2 py-3 flex flex-col justify-between">
                    <div class="flex flex-row justify-between">
                        <div class="flex flex-row w-fit justify-center items-center gap-2">
                            {{-- display profile picture, and default pfp if custome pfp not exists --}}
                            @if ($comment->user->profile_picture)
                                <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" alt="" class="aspect-square rounded-full object-cover h-[20px]">
                                
                            @else
                                <img src="{{ asset('storage/profile_pictures/default_pfp.jpg') }}" alt="" class="aspect-square rounded-full object-cover h-[20px]">
                                
                            @endif

                            {{-- username --}}
                            <a href="{{ route('user.show', $comment->user) }}" class="text text-slate-500">{{ $comment->user->username }}</a>

                        </div>
                        {{-- comment timestamp --}}
                        <span class="text-xs text-slate-500">{{ $comment->created_at->DiffForHumans() }}</span>
                        
                    </div>
                        
                    <div class="flex flex-row justify-between items-baseline">
                        {{-- comment content --}}
                        <p class="text leading-5 my-2">{{ $comment->body }}</p>

                        @auth
                            {{-- delete comment button --}}
                            @if (Auth::user()->id == $post->user_id || Auth::user()->id == $comment->user_id)
                                {{-- DELETE --}}
                                <form action="{{ route('comment.destroy', $comment) }}" method="post" class="ms-auto me-0 mb-0 mt-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button class="cursor-pointer"><i class="fa-solid fa-trash fa-xs md:fa-lg text-red-500"></i></button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    
                </div>
                
            @endforeach
        </div>
        
        {{-- pagination links --}}
        <div>
            {{ $comments->links() }}
        </div>
    </div>
    

</x-layout>