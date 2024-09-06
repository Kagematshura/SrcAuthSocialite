@extends('layout.app')

@section('content')
<div class="container mx-auto p-8 max-w-screen-md">
    <h1 class="text-4xl font-bold mb-4 text-gray-900 lg:text-5xl">{{ $article->title }}</h1>

    <p class="text-gray-600 text-sm mb-6">
        <span class="block">
            Written by <span class="font-semibold">{{ $article->user->name ?? 'Unknown' }}</span> <!-- Display the author's name -->
        </span>
        <time datetime="{{ $article->created_at->toIso8601String() }}" class="block">
            Published on <span class="font-semibold">{{ $article->created_at->timezone('Asia/Jakarta')->format('F d, Y h:i:s A') }}</span>
        </time>
        <time datetime="{{ $article->updated_at->toIso8601String() }}" class="block">
            Last updated on <span class="font-semibold">{{ $article->updated_at->timezone('Asia/Jakarta')->format('F d, Y h:i:s A') }}</span>
        </time>
    </p>

    @if ($article->image_path)
        <div class="mb-6">
            <img src="{{ asset('storage/' . $article->image_path) }}"
                 alt="Article Image" class="w-full h-auto object-cover rounded-lg shadow-md">
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-md prose lg:prose-xl">
        <!-- Render the content with HTML formatting -->
        {!! $article->content !!}
    </div>

    <div class="mt-8 flex justify-between">
        @if ($previousArticle)
            <a href="{{ route('article.show', $previousArticle->id) }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg shadow hover:bg-gray-700 transition duration-300">
                ← Previous Article
            </a>
        @endif

        @if ($nextArticle)
            <a href="{{ route('article.show', $nextArticle->id) }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg shadow hover:bg-gray-700 transition duration-300 ml-auto">
                Next Article →
            </a>
        @endif
    </div>

    <div class="mt-8">
        <a href="{{ route('article.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg shadow hover:bg-gray-700 transition duration-300">Back to Articles</a>
    </div>
    <div class="mt-8">
        <a href="{{ route('article.home') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg shadow hover:bg-gray-700 transition duration-300">Back to Home</a>
    </div>
</div>
@endsection
