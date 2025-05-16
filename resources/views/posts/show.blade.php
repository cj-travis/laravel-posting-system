<x-layout>
    @auth
        <a href="{{ route('posts') }}" class="block mb-2 text-xs text-blue-500">&larr; Back</a>
    @endauth

    @guest
        <a href="{{ route('index') }}" class="block mb-2 text-xs text-blue-500">&larr; Back</a>
    @endguest
    
    <x-postCard :post="$post" full='true'>

        <div>
            <div class="flex flex-row gap-3 pt-0 mt-auto mb-0 h-full">
                <input type="text" value="{{ route('posts.show', $post->id) }}" id="copyLink" readonly class="copyLink opacity-0 absolute -z-1">

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
                
                <button id="copyButton" class="copyButton m-0 p-0 inline-flex items-center"><i class="fa-solid fa-share-nodes fa-lg"></i></button>
            </div>
        </div>
    </x-postCard>

    @auth
        <hr class="text-slate-300 mt-3"/>
            {{-- Session messages --}}
            @if (session('success'))
                <x-flashMsg msg="{{ session('success') }}" bg="bg-green-500"/>

            @elseif (session('deleted'))
                <x-flashMsg msg="{{ session('deleted') }}" bg="bg-red-500"/>
            @endif
        <div class="my-4">
            <h1 class="text">Comments</h1>

            <form action="{{ route('comment.store') }}" class="my-3" method="POST">
                @csrf

                <label for="body" class="text">Add your Comment</label>

                <div class="flex flex-row gap-2">
                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                    <div class="flex-flex-col w-full">
                        <input type="text" name="body" class="input @error('body') r}ing-red-500 @enderror" value={{ old('body') }}>

                        @error('body')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    

                    <button class="btn max-w-[100px]">Send</button>
                </div>
                
            </form>

            

            <div class="my-2">
                @foreach ($comments as $comment)
                    <div class="card my-2 py-3 flex flex-col justify-between">
                        <div class="flex flex-row justify-between">
                            <div class="flex flex-row w-fit justify-center items-center gap-2">
                                @if ($comment->user->profile_picture)
                                    <img src="{{ asset('storage/' . $comment->user->profile_picture) }}" alt="" class="aspect-square rounded-full object-cover h-[20px]">
                                    
                                @else
                                    <img src="{{ asset('storage/profile_pictures/default_pfp.jpg') }}" alt="" class="aspect-square rounded-full object-cover h-[20px]">
                                    
                                @endif
                                <a href="{{ route('user.show', $comment->user) }}" class="text text-slate-500">{{ $comment->user->username }}</a>

                                
                            </div>
                            <span class="text-xs text-slate-500">{{ $post->created_at->DiffForHumans() }}</span>
                            
                        </div>

                        <div class="flex flex-row justify-between items-baseline">
                            <p class="text leading-5 my-2">{{ $comment->body }}</p>

                            {{-- delete comment button --}}
                            @if (Auth::user()->id == $post->user_id || Auth::user()->id == $comment->user_id)
                                {{-- DELETE --}}
                                <form action="{{ route('comment.destroy', $comment) }}" method="post" class="ms-auto me-0 mb-0 mt-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button class="cursor-pointer"><i class="fa-solid fa-trash fa-xs md:fa-lg text-red-500"></i></button>

                                </form>
                            @endif
                        </div>
                        
                    </div>
                    
                    
                @endforeach
            </div>
            

            <div>
                {{ $comments->links() }}
            </div>
        </div>
    @endauth
    

</x-layout>