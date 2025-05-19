<x-layout :title="'Admin Dashboard'">
    {{-- Session messages --}}
    @if (session('success'))
        <x-flashMsg msg="{{ session('success') }}" bg="bg-green-500"/>

    @elseif (session('failed'))
        <x-flashMsg msg="{{ session('failed') }}" bg="bg-red-500"/>
    @endif

    <div class="flex flex-col lg:flex-row gap-2 justify-between">
        <h1 class="title">Admin Dashboard</h1>
        {{-- Table dropdown --}}
        <form method="GET" action="{{ route('admin-dashboard') }}" class="flex flex-col md:flex-row gap-2">

            {{-- dropdown --}}
            <select name="table" id="table" class="px-2 border rounded-lg">
                <option value="users" {{ request('table') === 'users' ? 'selected' : '' }}>User Management</option>
                <option value="posts" {{ request('table') === 'posts' ? 'selected' : '' }}>Post Management</option>
            </select>
            
            {{-- search --}}
            <input type="text" name="search" placeholder="Search posts..." class="border rounded p-1 w-full md:w-[60%] lg:w-[80%] px-2" value="{{ request('search') }}">

            {{-- sort button --}}
            <button type="submit" class="px-2 rounded bg-blue-500 text-white hover:bg-blue-400">Select</button>
        </form>
    </div>

    <div class="relative">

        
        {{-- Top scrollbar (fake scroll container)--}}
        <div class="overflow-x-auto mb-2" id="scroll-top">
            <div class="w-full min-w-[800px] h-4"></div> {{-- Match table width --}}
        </div>

        {{-- table --}}
        <div class="my-4 overflow-x-auto relative" id="scroll-table">
            <table class=" w-full min-w-[800px] table-fixed w-full text-xs md:text-sm 2xl:text-base" >

                {{-- posts table --}}
                @if (request()->query('table') == 'posts')
                    <thead>
                        <tr>
                            <th class="bg-white sticky left-0 z-1 w-[5%]">ID</th>
                            <th class="w-[20%]">Title</th>
                            <th class="w-[25%]">Body</th>
                            <th class="w-[10%]">Created by</th>
                            <th class="w-[8%]">User ID</th>
                            <th class="w-[15%]">Created at</th>
                            <th class="bg-white sticky right-0 z-1 w-[17%] ">
                                <span>Status/Action</span>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody>

                    @foreach ($result as $post)
                        <tr>
                            <td class="bg-white sticky left-0 z-1 w-[5%]">{{ $post->id }}</td>
                            <td class="text-left max-w-[20%]"><a href="{{ route('posts.show', $post) }}" class="underline">{{  Str::words($post->title, 6) }}</a></td>
                            <td class="text-left max-w-[25%]">{{  Str::words($post->body, 15) }}</td>
                            <td class="w-[10%]"><a href="{{ route('user.show', $post->user) }}" class="underline">{{ $post->user->username }}</a></td>
                            <td class="w-[8%]">{{ $post->user_id }}</td>
                            <td class="w-[15%]">{{ $post->created_at }}</td>
                            <td class="bg-white sticky right-0 z-1 w-[17%] ">
                                <span>{{ $post->status }}</span><br>

                                {{-- UPDATE post status --}}
                                <form action="{{ route('post-status.update', $post) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    @if ($post->status == 'blocked')
                                        <button class="btn w-[80%] lg:w-[50%] mx-auto hover:cursor-pointer bg-green-600">Unblock</button>
                                    @else
                                        <button class="btn w-[80%] lg:w-[50%] mx-auto hover:cursor-pointer bg-red-600">Block</button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                @else
                    {{-- user table --}}
                    <thead>
                        <tr>
                            <th class="w-[5%] bg-white sticky left-0 z-1">Id</th>
                            <th class="w-[20%]">Username</th>
                            <th class="w-[20%]">Email</th>
                            <th class="w-[15%]">Joined since</th>
                            <th class="w-[13%]">Number of posts</th>
                            <td class="bg-white sticky right-0 z-1 w-[10%] md:w-[27%]">
                                <span>Role/Status</span>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($result as $user)
                        <tr>
                            <td class="w-[5%] bg-white sticky left-0 z-1">{{ $user->id }}</td>
                            <td class="w-[20%]"><a href="{{ route('user.show', $user) }}" class="underline">{{ $user->username }}</a></td>
                            <td class="w-[20%]">{{ $user->email }}</td>
                            <td class="w-[15%]">{{ $user->created_at }}</td>
                            <td class="w-[13%]">{{ $user->posts_count }}</td>
                            <td class="bg-white sticky right-0 z-1 w-[10%] md:w-[27%]">
                                <div class="py-1">
                                    <span>{{ $user->role }}</span><br>
                                    
                                    {{-- UPDATE user role --}}
                                    <form action="{{ route('role.update', $user) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        @if ($user->role == 'admin')
                                            <button class="btn w-[80%] lg:w-[50%] mx-auto hover:cursor-pointer bg-slate-900">Set User</button>
                                        @else
                                            <button class="btn w-[80%] lg:w-[50%] mx-auto hover:cursor-pointer bg-slate-700">Set Admin</button>
                                        @endif
                                    </form>
                                </div>
                                <div class="py-1">

                                    {{-- UPDATE user status --}}
                                    <span>{{ $user->status }}</span><br>
                                    <form action="{{ route('user-status.update', $user) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        @if ($user->status == 'blocked')
                                            <button class="btn w-[80%] lg:w-[50%] mx-auto hover:cursor-pointer bg-green-600">Unblock</button>
                                        @else
                                            <button class="btn w-[80%] lg:w-[50%] mx-auto hover:cursor-pointer bg-red-600">Block</button>
                                        @endif
                                    </form>
                                </div>
                                
                            </td>
                            
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>
    </div>

    <script>
    const scrollTop = document.getElementById('scroll-top');
    const scrollTable = document.getElementById('scroll-table');

    // When you scroll the top, scroll the table
    scrollTop.addEventListener('scroll', () => {
        scrollTable.scrollLeft = scrollTop.scrollLeft;
    });

    // When you scroll the table, scroll the top bar
    scrollTable.addEventListener('scroll', () => {
        scrollTop.scrollLeft = scrollTable.scrollLeft;
    });
</script>
</x-layout>