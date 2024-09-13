@extends('layout.app')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-4xl font-extrabold mb-8 text-gray-900">Create a Draft</h1>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('drafts.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="form-group">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>

        <div class="form-group">
            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
            <textarea name="content" id="content" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
        </div>

        <div class="form-group">
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <select name="type" id="type" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <option value="article">Article</option>
                <option value="news">News</option>
            </select>
        </div>
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save as Draft</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>
</div>
@endsection
