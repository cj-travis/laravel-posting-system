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
    <nav class="bg-white z-10 min-h-[80px] shadow flex flex-row items-center" id="topnav">
        <div class="w-full flex flex-row justify-between px-6 py-4">
            <div class="w-fit my-auto">
                <span class="text-xl p-3 font-cal text-[#12d30f]"><a href="{{ route('index') }}">SaveNShare</a></span>
            </div>

            {{-- Mobile Navbar --}}
            <div class="w-fit block md:hidden" x-data="{ open: false }">
                <i class="fa-solid fa-bars" @click="open = !open" x-show="!open"></i>
                <i class="fa-solid fa-xmark" @click="open = !open" x-show="open"></i>
                <ul class="bg-white shadow-lg absolute top-[80px] right-0 overflow-hidden font-light px-6"  x-show="open" @click.outside="open = false">
                    <li class="p-3"><a href="{{ route('login') }}">Login</a></li>
                    <li class="p-3"><a href="{{ route('register') }}">Register</a></li>
                    <li class="p-3"><a href="">Posts</a></li>
                </ul>
            </div>

            {{-- Desktop Navbar --}}
            <div class="w-fit hidden md:block">
                <ul class="flex flex-row gap-4">
                    <li class="p-3"><a href="">Login</a></li>
                    <li class="p-3"><a href="">Register</a></li>
                    <li class="p-3"><a href="">Posts</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="pt-30 w-[90%] md:w-[75%] mx-auto">
        {{ $slot }}
    </div>

    <div class="h-[1000px]"></div>

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
                        <a href="#" class="hover:underline me-4 md:me-6">Posts</a>
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

  </body>
</html>