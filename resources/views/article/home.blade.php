@extends('layout.app')

@section('content')
<div class="container mx-auto p-8">
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-extrabold text-gray-900">Latest Articles</h1>
            <a href="{{ route('drafts.create') }}" class="bg-red-600 text-white px-6 py-2 rounded-lg shadow-lg hover:bg-red-700 transition duration-300">
                Feeling like writing something?
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($t_article as $article)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105">
                    <img src="{{ $article->image_path ? asset('storage/' . $article->image_path) : 'https://via.placeholder.com/400x200' }}"
                         alt="Article Image" class="w-full h-48 object-cover">

                    <div class="p-6">
                        <h2 class="text-2xl font-semibold mb-3 text-gray-900 truncate">
                            <a href="{{ route('article.show', $article->id) }}" class="hover:text-red-600 transition duration-300">
                                {{ $article->title }}
                            </a>
                        </h2>

                        <p class="text-gray-700 mb-4 leading-relaxed">
                            {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 70, '...') }}
                        </p>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('article.show', $article->id) }}" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition duration-300">
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
            {{ $t_article->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
