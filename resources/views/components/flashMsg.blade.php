{{-- message and background color as props --}}
@props(['msg', 'bg' => 'bg-green-500']) 

{{-- flashcard --}}
<p class="mb-2 text-sm font-medium text-white px-3 py-2 rounded-md {{ $bg }}">{{ $msg }}</p>