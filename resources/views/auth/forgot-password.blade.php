<x-layout :title="'Reset Password Request'">

    <h1 class="title mb-4">Reset Password Request </h1>

    {{-- Session messages --}}
    @if (session('status'))
        <x-flashMsg msg="{{ session('status') }}" bg="bg-green-500"/>
    @endif

    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('password.request') }}" method="POST" x-data="formSubmit" @submit.prevent="submit">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" class="input @error('email') ring-red-500 @enderror" value={{ old('email') }}>
                
                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror

            </div>

            {{-- Submit Button --}}
            <button class="btn" x-ref="btn">Request</button>

        </form>
    </div>

</x-layout>