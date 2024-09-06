@extends('layout.app')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-4xl font-bold mb-8 text-gray-900">Edit Article</h1>

    @if ($errors->any())
        <div class="bg-red-600 text-white p-4 rounded-lg shadow-md mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('article.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ $article->title }}" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-red-500 focus:ring focus:ring-red-200" required>
            <div id="title-counter" class="text-sm text-gray-500 mt-1">Character count: {{ strlen($article->title) }}</div>
        </div>

        <!-- Image Upload Section -->
        <div class="mb-6">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="image">Article Image</label>
            <input type="file" name="image" id="image" class="block w-full text-gray-700 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:border-red-500 focus:ring focus:ring-red-200">
            @if ($article->image_path)
                <img src="{{ asset('storage/' . $article->image_path) }}" alt="Article Image" class="w-32 h-32 object-cover rounded-lg shadow-md mt-4">
                <p class="text-sm text-gray-500 mt-2">Current Image</p>
            @endif
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="content">Content</label>
            <textarea
                name="content"
                id="content"
                rows="10"
                class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-red-500 focus:ring focus:ring-red-200"
                placeholder="Write your article content here..."
                required>{{ $article->content }}</textarea>
            <div id="content-counter" class="text-sm text-gray-500 mt-1">Word count: 0</div>
        </div>

        <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg shadow hover:bg-red-700 transition duration-300">
            Update Article
        </button>
    </form>

    <a href="{{ route('article.index') }}" class="mt-6 inline-block bg-gray-600 text-white px-6 py-3 rounded-lg shadow hover:bg-gray-700 transition duration-300">Back to Articles</a>
</div>

<!-- Include TinyMCE -->
<script src="https://cdn.tiny.cloud/1/t4d8f3p0fnqaze0wj0rfr1kxftjdeulfrkzscrmzj1eokgrc/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        menubar: false,
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image code',
        height: 400,
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave(); // Updates the hidden textarea with the WYSIWYG editor content
                updateContentCounter(); // Update the word count
            });
        }
    });

    function updateTitleCounter() {
        const title = document.getElementById('title').value;
        document.getElementById('title-counter').innerText = `Character count: ${title.length}`;
    }

    function updateContentCounter() {
        const content = tinymce.get('content').getContent({format: 'text'});
        const wordCount = content.split(/\s+/).filter(word => word.length > 0).length;
        document.getElementById('content-counter').innerText = `Word count: ${wordCount}`;
    }

    document.getElementById('title').addEventListener('input', updateTitleCounter);
    updateTitleCounter(); // Initialize the title counter with current title length
    updateContentCounter(); // Initialize the content counter with current content length
</script>
@endsection
