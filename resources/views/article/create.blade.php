@extends('layout.app')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-4xl font-bold mb-8 text-gray-900">Add New Page</h1>

    @if ($errors->any())
        <div class="bg-red-600 text-white p-4 rounded-lg shadow-md mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('article.store') }}" method="POST" class="bg-white p-8 rounded-lg shadow-md" enctype="multipart/form-data" onsubmit="handleSubmit()">
        @csrf
        <div class="mb-6">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="title">Title</label>
            <input type="text" name="title" id="title" placeholder="Enter your title here..." class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-red-500 focus:ring focus:ring-red-200" required oninput="updateTitleCounter()">
            <div id="title-counter" class="text-sm text-gray-500 mt-1">Character count: 0</div>
        </div>

        <!-- Category Dropdown -->
        <div class="mb-6">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="category">Category</label>
            <select name="category" id="category" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-red-500 focus:ring focus:ring-red-200" required>
                <option value="" disabled selected>Select a category</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="image">Image</label>
            <input type="file" name="image" id="image" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-red-500 focus:ring focus:ring-red-200">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-lg font-semibold mb-2" for="content">Content</label>
            <textarea
                name="content"
                id="content"
                rows="10"
                class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:border-red-500 focus:ring focus:ring-red-200"
                placeholder="Write your article content here..."
                required>{{ isset($article) ? $article->content : '' }}</textarea>
            <div id="content-counter" class="text-sm text-gray-500 mt-1">Word count: 0</div>
        </div>

        <!-- Status -->
        <input type="hidden" name="sts" value="{{ $sts }}">

        <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg shadow hover:bg-red-700 transition duration-300">
            {{ isset($article) ? 'Update' : 'Submit' }}
        </button>

    </form>

    <a href="{{ route('article.index') }}" class="mt-6 inline-block bg-gray-600 text-white px-6 py-3 rounded-lg shadow hover:bg-gray-700 transition duration-300">Back to Articles</a>
</div>

<script src="https://cdn.tiny.cloud/1/t4d8f3p0fnqaze0wj0rfr1kxftjdeulfrkzscrmzj1eokgrc/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Function to get query parameters from the URL
    function getQueryParam(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    // Get the 'sts' value from the URL
    const sts = getQueryParam('sts');
    const categorySelect = document.getElementById('category');

    const categories = {
        'news': ['Culture', 'Smile', 'Love'],
        'article': ['Information', 'Knowledge']
    };

    // Clear existing options
    categorySelect.innerHTML = '';

    // Populate categories based on sts
    if (categories[sts]) {
        categories[sts].forEach(category => {
            const option = document.createElement('option');
            option.value = category.toLowerCase();
            option.textContent = category;
            categorySelect.appendChild(option);
        });
    }
});

    tinymce.init({
        selector: '#content',
        menubar: false,
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image code',
        height: 400,
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
                updateContentCounter();
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

    function handleSubmit() {
        tinymce.triggerSave();
    }
</script>
@endsection
