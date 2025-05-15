
<x-layout>
    <a href="{{ route('user.show', Auth::user()) }}" class="block mb-2 text-xs text-blue-500">&larr;Go back to profile</a>

    <h1 class="title">Reset your password</h1>

    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('userpassword.update') }}" method="POST">
            @csrf

            {{-- Old Password --}}
            <div class="mb-4">
                <label for="old_password">Old Password</label>
                <input type="password" name="old_password" class="input @error('old_password') ring-red-500 @enderror">

                @error('old_password')
                    <p class="error">{{ $message }}</p>
                @enderror

            </div>

            {{-- New Password --}}
            <div class="mb-4">
                <label for="password">New Password</label>
                <input type="password" name="password" class="input @error('password') ring-red-500 @enderror">

                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror

            </div>

            {{-- Confirm Password --}}
            <div class="mb-8">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="input @error('password') ring-red-500 @enderror">

            </div>

            {{-- Submit Button --}}
            <button class="btn">Reset Password</button>

        </form>
    </div>

</x-layout>