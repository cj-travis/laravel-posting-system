<x-layout>
    @auth
        <a href="{{ route('posts') }}" class="block mb-2 text-xs text-blue-500">&larr; Back</a>
    @endauth

    @guest
        <a href="{{ route('index') }}" class="block mb-2 text-xs text-blue-500">&larr; Back</a>
    @endguest
    
    <x-postCard :post="$post" full='true'/>

</x-layout>