
<x-layout>

    <h1 class="title w-fit mb-4 md:mx-auto">Login</h1>

    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('login') }}" method="POST">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" class="input @error('email') ring-red-500 @enderror" value={{ old('email') }}>
                
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror

            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" class="input @error('password') ring-red-500 @enderror">

                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror

            </div>

            {{-- Remember checkbox --}}
            <div class="mb-4 flex justify-between items-center">
                <div>
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>

                <a class="text-blue-600" href="">Forget your password?</a>
            </div>

            @error('failed')
                <p class="error">{{ $message }}</p>
            @enderror

            {{-- Submit Button --}}
            <button class="btn">Login</button>

        </form>
    </div>

</x-layout>