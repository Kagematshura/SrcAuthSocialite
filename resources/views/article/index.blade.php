@extends('layout.app')

@section('content')
<div class="container mx-auto p-8">
    <h1 class="text-4xl font-bold mb-8 text-gray-900">Articles</h1>

    <!-- Filters and Sorting -->
    <div class="flex justify-between items-center mb-4">
        <!-- Title Filter -->
        <div class="flex items-center">
            <input type="text" id="titleFilter" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg p-2 mr-2" placeholder="Filter by title">
            <button onclick="applyTitleFilter()" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition duration-300">Apply Filter</button>
        </div>

        <!-- Sorting -->
        <div class="flex items-center">
            <select id="sortOrder" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg p-2 mr-2">
                <option value="asc">Oldest</option>
                <option value="desc">Newest</option>
            </select>
            <button onclick="sortArticles()" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition duration-300">Sort</button>
        </div>

        <!-- Refresh Filter -->
        <div class="flex items-center">
            <button onclick="refreshFilters()" class="bg-gray-600 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 transition duration-300">Refresh Filters</button>
        </div>
    </div>

    <div class="overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-lg">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-200 text-gray-800">
                    <th class="py-3 px-6 text-left text-sm font-semibold">Title</th>
                    <th class="py-3 px-6 text-left text-sm font-semibold">Snippet</th>
                    <th class="py-3 px-6 text-left text-sm font-semibold">Published On</th>
                    <th class="py-3 px-6 text-left text-sm font-semibold">Last Updated</th>
                    <th class="py-3 px-6 text-center" colspan="2"></th>
                </tr>
            </thead>
            <tbody id="articleTable">
                @foreach ($t_article as $article)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-4 px-6 text-gray-900">
                            <a href="{{ route('article.show', $article->id) }}" class="text-red-600 hover:text-red-800 font-semibold">
                                {{ $article->title }}
                            </a>
                        </td>
                        <td class="py-4 px-6 text-gray-700">
                            {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 100, '...') }}
                        </td>
                        <td class="py-4 px-6 text-gray-700">
                            {{ $article->created_at->timezone('Asia/Jakarta')->format('F d, Y h:i:s A') }}
                        </td>
                        <td class="py-4 px-6 text-gray-700">
                            {{ $article->updated_at->timezone('Asia/Jakarta')->format('F d, Y h:i:s A') }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('article.edit', $article->id) }}" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition duration-300">Edit</a>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <form action="{{ route('article.destroy', $article->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 transition duration-300" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        <a href="{{ route('article.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-red-700 transition duration-300">Add New Article</a>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/t4d8f3p0fnqaze0wj0rfr1kxftjdeulfrkzscrmzj1eokgrc/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    function applyTitleFilter() {
        let filter = document.getElementById('titleFilter').value.toLowerCase();
        let rows = document.querySelectorAll('#articleTable tr');

        rows.forEach(row => {
            let title = row.querySelector('td:first-child').textContent.toLowerCase();
            row.style.display = title.includes(filter) ? '' : 'none';
        });
    }

    function sortArticles() {
        let sortOrder = document.getElementById('sortOrder').value;
        let rows = Array.from(document.querySelectorAll('#articleTable tr'));

        rows.sort((a, b) => {
            let dateA = new Date(a.querySelector('td:nth-child(3)').textContent);
            let dateB = new Date(b.querySelector('td:nth-child(3)').textContent);

            return sortOrder === 'asc' ? dateA - dateB : dateB - dateA;
        });

        rows.forEach(row => document.querySelector('#articleTable').appendChild(row));
    }

    function refreshFilters() {
        document.getElementById('titleFilter').value = '';
        document.getElementById('sortOrder').value = 'asc';
        applyTitleFilter();
        sortArticles();
    }
</script>
@endsection
