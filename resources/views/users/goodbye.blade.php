<x-layout :title="'Goodbye :('">
    <div class="h-[80dvh] flex flex-col gap-2 justify-center items-center">
        <span class="text-4xl p-3 font-cal text-[#12d30f]"><a href="{{ route('index') }}">SaveNShare</a></span>
        <h1 class="mb-3">Account deleted successfully</h1>
        <a href="{{ route('index') }}" class="btn max-w-[200px] text-center">Back to home</a>
        <p class="text-xs">Hope to see you again~</p>
    </div>
</x-layout>