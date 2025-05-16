<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anaheim:wght@400..800&family=Cal+Sans&family=Overlock:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Spicy+Rice&display=swap" rel="stylesheet">
  </head>
  <body>
    {{-- Top Navbar --}}
    <nav class="bg-white z-10 min-h-[80px] shadow flex flex-row items-center" id="topnav">
        <div class="w-full flex flex-row justify-between px-6 py-4">
            <div class="w-fit my-auto">
                @auth
                    <span class="text-xl p-3 font-cal text-[#12d30f]"><a href="{{ route('posts') }}">SaveNShare</a></span>
                    
                @endauth

                @guest
                    <span class="text-xl p-3 font-cal text-[#12d30f]"><a href="{{ route('index') }}">SaveNShare</a></span>
                    
                @endguest
            </div>

            @auth
                {{-- Mobile Navbar --}}
                <div class="w-fit block md:hidden flex flex-row justify-center items-center gap-2" x-data="{ open: false }">
                    <div class="flex flex-row justify-center items-center gap-2">
                        <span>{{ Auth::user()->username }}</span>
                        @if (Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="pfp" class="aspect-square rounded-full object-cover h-[30px]" @click="open = !open" x-show="!open">
                            
                        @else
                            <img src="{{ asset('storage/profile_pictures/default_pfp.jpg') }}" alt="pfp" class="aspect-square rounded-full object-cover h-[30px]" @click="open = !open" x-show="!open">
                            
                        @endif
                    </div>
                    
                    {{-- <i class="fa-solid fa-bars" @click="open = !open" x-show="!open"></i> --}}
                    <i class="fa-solid fa-xmark" @click="open = !open" x-show="open"></i>
                    <ul class="bg-white shadow-lg absolute top-[80px] right-0 overflow-hidden font-light px-6"  x-show="open" @click.outside="open = false">
                        <li class="p-3"><a href="{{ route('user.show', Auth::user()) }}">Profile</a></li>
                        <li class="p-3"><a href="{{ route('login') }}">Dashboard</a></li>
                        <li class="p-3"><a href="{{ route('posts') }}">Posts</a></li>
                        <li class="p-3">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf

                                <button class="btn bg-red-500 hover:bg-red-600">
                                    Logout
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>

                {{-- Desktop Navbar --}}
                <div class="w-fit hidden md:block">
                    <ul class="flex flex-row gap-4 justify-center items-center">
                        <li class="p-3">
                            <a href="{{ route('user.show', Auth::user()) }}" class="flex flex-row justify-center items-center gap-2">
                                @if (Auth::user()->profile_picture)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="pfp" class="aspect-square rounded-full object-cover h-[30px]" @click="open = !open" x-show="!open">
                                    
                                @else
                                    <img src="{{ asset('storage/profile_pictures/default_pfp.jpg') }}" alt="pfp" class="aspect-square rounded-full object-cover h-[30px]" @click="open = !open" x-show="!open">
                                    
                                @endif
                                Profile
                            </a>
                        </li>
                        <li class="p-3"><a href="{{ route('login') }}">Dashboard</a></li>
                        <li class="p-3"><a href="{{ route('posts') }}">Posts</a></li>
                        <li class="py-1">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf

                                <button class="rounded-xl px-3 py-2 bg-red-500 hover:bg-red-600 text-white">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth

            @guest
                {{-- Mobile Navbar --}}
                <div class="w-fit block md:hidden" x-data="{ open: false }">
                    <i class="fa-solid fa-bars" @click="open = !open" x-show="!open"></i>
                    <i class="fa-solid fa-xmark" @click="open = !open" x-show="open"></i>
                    <ul class="bg-white shadow-lg absolute top-[80px] right-0 overflow-hidden font-light px-6"  x-show="open" @click.outside="open = false">
                        <li class="p-3"><a href="{{ route('dashboard') }}">Login</a></li>
                        <li class="p-3"><a href="{{ route('register') }}">Register</a></li>
                        <li class="p-3"><a href="{{ route('posts') }}">Posts</a></li>
                    </ul>
                </div>

                {{-- Desktop Navbar --}}
                <div class="w-fit hidden md:block">
                    <ul class="flex flex-row gap-4">
                        <li class="p-3"><a href="{{ route('login') }}">Login</a></li>
                        <li class="p-3"><a href="{{ route('register') }}">Register</a></li>
                        <li class="p-3"><a href="{{ route('posts') }}">Posts</a></li>
                    </ul>
                </div>
            @endguest
            
        </div>
    </nav>

    {{-- Page --}}
    <div class="pt-30 w-[90%] md:w-[75%] mx-auto min-h-screen">
        {{ $slot }}
    </div>

    {{-- for scrolling purposes --}}
    {{-- <div class="h-[1000px]"></div>  --}}

    {{-- footer --}}
    @auth
         <footer class="bg-white rounded-lg shadow-sm dark:bg-gray-800 m-2">
            <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <span class="text-xl font-cal text-[#12d30f]"><a href="{{ route('index') }}">SaveNShare</a></span>
                    <ul class="flex flex-wrap items-center mb-6 mt-2 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                        <li>
                            <a href="{{ route('user.show', Auth::user())  }}" class="hover:underline me-4 md:me-6">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard')  }}" class="hover:underline me-4 md:me-6">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('posts') }}" class="hover:underline me-4 md:me-6">Posts</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
                <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
                <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ now()->year }} SaveNShare</span>
            </div>
        </footer>
    @endauth

    @guest
         <footer class="bg-white rounded-lg shadow-sm dark:bg-gray-800 m-2">
            <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <span class="text-xl font-cal text-[#12d30f]"><a href="{{ route('index') }}">SaveNShare</a></span>
                    <ul class="flex flex-wrap items-center mb-6 mt-2 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                        <li>
                            <a href="{{ route('login')  }}" class="hover:underline me-4 md:me-6">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="hover:underline me-4 md:me-6">Register</a>
                        </li>
                        <li>
                            <a href="{{ route('posts') }}" class="hover:underline me-4 md:me-6">Posts</a>
                        </li>
                        <li>
                            <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
                <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
                <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ now()->year }} SaveNShare</span>
            </div>
        </footer>
    @endguest
   

    <script>
        var topNav = document.getElementById("topnav");
        var lastScrollTop = 0;

        // Add scroll event listener
        window.addEventListener('scroll', function() {
            var currentScroll = window.scrollY;

            // If scrolling down, hide the navbar
            if (currentScroll > lastScrollTop) {
                topNav.style.transform = "translateY(-100%)";  
            } 
            // If scrolling up, show the navbar
            else {
                topNav.style.transform = "translateY(0)";  
            }

            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;  
        });
    </script>

    <script>
        // Set form: x-data="formSubmit" @submit.prevent="submit" and button: x-ref="btn"

        document.addEventListener('alpine:init', () => {
            Alpine.data('formSubmit', () => ({
                submit() {
                    this.$refs.btn.disabled = true;
                    this.$refs.btn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                    this.$refs.btn.innerHTML = 
                        `
                        <span class="absolute left-2 top-1/2 -translate-y-1/2 transform">
                            <i class="fa-solid fa-spinner animate-spin"></i>
                        </span>Please wait...
                        `;
                    
                    this.$el.submit();
                }
            }))
        })
    </script>

    <script>
        document.querySelectorAll('.copyButton').forEach(function(button, index) {
        button.addEventListener('click', function() {
            // Get the input field that corresponds to this button
            var copyText = document.querySelectorAll('.copyLink')[index];
            
            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices

            // Copy the text inside the input
            document.execCommand('copy');

            // Alert the user that the text has been copied
            alert("Link copied to clipboard: " + copyText.value);
        });
    });
    </script>

  </body>
</html>