@extends('layout.app')

@section('content')
<div class="body container mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-4xl font-extrabold text-gray-900">Latest Articles</h1>

        <!-- Sts Filter -->
        <div class="items-center">
            <button onclick="filterBySts('news')" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">Show News</button>
            <button onclick="filterBySts('article')" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">Show Article</button>
            <button onclick="showAllArticles()" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">Show All</button>
        </div>

        <a href="{{ route('article.home') }}" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
        </a>

        <a href="{{ route('drafts.create') }}" class="bg-[#588157] text-white px-6 py-2 rounded-lg shadow-lg hover:bg-red-700 transition duration-300">
            Feeling like writing something?
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="articleGrid">
        @foreach ($t_post as $article)
            <div class="article-card bg-[#588157] shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105" data-sts="{{ $article->sts }}">
                <img src="{{ $article->image_path ? asset('storage/' . $article->image_path) : 'https://via.placeholder.com/400x200' }}"
                     alt="Article Image" class="w-full h-48 object-cover">

                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-3 text-gray-900 truncate">
                        <a href="{{ route('article.show', $article->id) }}" class="hover:text-red-600 transition duration-300">
                            {{ $article->title }}
                        </a>
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        {{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($article->content)), 70, '...') }}
                    </p>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('article.show', $article->id) }}" class=" text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition duration-300">
                            Read More
                        </a>
                        <span class="text-gray-500 text-sm">
                            {{ $article->created_at->format('M d, Y - H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-10 flex justify-center">
        {{ $t_post->links('pagination::tailwind') }}
    </div>
</div>

<script>
    function filterBySts(sts) {
        var articles = document.querySelectorAll('.article-card');
        articles.forEach(function(article) {
            if (article.getAttribute('data-sts') === sts) {
                article.style.display = 'block';
            } else {
                article.style.display = 'none';
            }
        });
    }

    function showAllArticles() {
        var articles = document.querySelectorAll('.article-card');
        articles.forEach(function(article) {
            article.style.display = 'block';
        });
    }
</script>
<style>
    body{
        background-color:#344E41
    }
</style>
@endsection
