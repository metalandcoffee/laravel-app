<x-layout>
    @include ('posts._header')
    <main class="max-w-6xl mx-auto mt-6 lg:mt-20 space-y-6">
        @if($posts->count())
            <x-post-grid :posts="$posts"/>

            {{--Pagination--}}
            {{ $posts->links() }}
        @else
            <p>Not posts yet. Please check back later.</p>
        @endif
    </main>
</x-layout>


