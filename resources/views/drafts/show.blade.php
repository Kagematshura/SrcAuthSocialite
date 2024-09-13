@extends('layout.app')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-4xl font-extrabold mb-8 text-gray-900">{{ $draft->title }}</h1>

    <p class="text-gray-700 mb-4"><strong>Author:</strong> {{ $draft->author }}</p>
    <p class="text-gray-700 mb-4"><strong>Author:</strong> {{ $draft->type }}</p>
    <p class="text-gray-700 mb-4"><strong>Submitted At:</strong> {{ $draft->created_at->format('M d, Y') }}</p>
    <p class="text-gray-700 mb-4"><strong>Status:</strong> {{ ucfirst($draft->status) }}</p>

    <!-- Render content with HTML formatting -->
    <div class="prose">
        {!! $draft->content !!}
    </div>
</div>
@endsection
