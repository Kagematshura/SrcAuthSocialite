@extends('layout.app')

@section('content')
<!-- Navbar -->
<nav class="bg-[#3A5A40] p-4 shadow-md"> <!-- Hunter Green with a shadow -->
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="#" class="text-[#DAD7CD] text-2xl font-bold">My App</a> <!-- Timberwolf for the logo -->

        <!-- Menu Links -->
        <div class="hidden md:flex space-x-6">
            <a href="#" class="text-[#DAD7CD] hover:text-white transition duration-200">Home</a>
            <a href="#" class="text-[#DAD7CD] hover:text-white transition duration-200">Articles</a>
            <a href="#" class="text-[#DAD7CD] hover:text-white transition duration-200">Contact</a>
        </div>

        <!-- Profile Dropdown -->
        <div class="relative">
            <button id="dropdownButton" class="flex items-center space-x-2 text-[#DAD7CD] hover:text-white focus:outline-none">
                <img src="{{ auth()->user()->profile_picture_url ?? 'https://via.placeholder.com/40' }}" class="w-10 h-10 rounded-full" alt="Profile Picture">
                <span>{{ auth()->user()->name ?? 'Guest' }}</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="dropdownMenu" class="absolute right-0 mt-2 w-48 bg-[#3A5A40] rounded-lg shadow-lg py-2 z-20 hidden"> <!-- Hunter Green for dropdown -->
                <a href="#" class="block px-4 py-2 text-[#DAD7CD] hover:bg-[#2C4A37] transition duration-200">Profile</a> <!-- Timberwolf for the link -->
                <a href="#" class="block px-4 py-2 text-[#DAD7CD] hover:bg-[#2C4A37] transition duration-200">Settings</a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-[#DAD7CD] hover:bg-[#2C4A37] transition duration-200">Logout</button> <!-- Timberwolf for the button -->
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container mx-auto p-8">
    {{-- <h1 class="text-4xl font-bold mb-8 text-[#DAD7CD]">Articles</h1> <!-- Timberwolf for the heading --> --}}

    <!-- Filters and Sorting -->
    <div class="flex justify-between items-center mb-4">
        <!-- Title Filter -->
        <div class="flex items-center space-x-4">
            <input type="text" id="titleFilter" class="bg-[#] border border-[#2C4A37] text-[#DAD7CD] rounded-lg p-2" placeholder="Filter by title"> <!-- Darker Green for the input -->
            <button onclick="applyTitleFilter()" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#3A5A40] transition duration-200">Apply Filter</button> <!-- Fern Green for the button -->
        </div>

        <!-- Sorting -->
        <div class="flex items-center space-x-4">
            <select id="sortOrder" class="bg-[#2C4A37] border border-[#2C4A37] text-[#DAD7CD] rounded-lg p-2">
                <option value="asc">Oldest</option>
                <option value="desc">Newest</option>
            </select>
            <button onclick="sortArticles()" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#3A5A40] transition duration-200">Sort</button>
        </div>

        <!-- Refresh Filter -->
        <div>
            <button onclick="refreshFilters()" class="bg-[#2C4A37] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#344E41] transition duration-200">Refresh Filters</button> <!-- Darker Green for the button -->
        </div>
    </div>

    {{-- Table --}}
<div class="overflow-x-auto bg-[#2C4A37] p-4 rounded-lg shadow-lg">
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead>
            <tr class="border-b border-gray-200 bg-[#3A5A40] text-[#DAD7CD]"> <!-- Header styling -->
                <th class="py-3 px-6 text-left text-sm font-semibold">Title</th>
                <th class="py-3 px-6 text-left text-sm font-semibold">Snippet</th>
                <th class="py-3 px-6 text-left text-sm font-semibold">Published By</th>
                <th class="py-3 px-6 text-left text-sm font-semibold">Published On</th>
                <th class="py-3 px-6 text-left text-sm font-semibold">Last Updated</th>
                <th class="py-3 px-6 text-center" colspan="2"></th>
            </tr>
        </thead>
        {{-- Table body --}}
        <tbody id="articleTable">
            @foreach ($t_article as $article)
                <tr class="border-b border-gray-200 hover:bg-[#3A5A40] transition duration-200"> <!-- Row styling -->
                    <td class="py-4 px-6 text-gray-900">
                        <a href="{{ route('article.show', $article->id) }}" class="text-[#588157] hover:text-[#DAD7CD] font-semibold">
                            {{ $article->title }}
                        </a>
                    </td>
                    <td class="py-4 px-6 text-gray-700">
                        {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 50, '...') }}
                    </td>
                    <td class="py-4 px-6 text-gray-700">
                        {{ $article->user->name ?? 'Unknown' }} <!-- Display user's name -->
                    </td>
                    <td class="py-4 px-6 text-gray-700">
                        {{ $article->created_at->timezone('Asia/Jakarta')->format('F d, Y h:i:s A') }}
                    </td>
                    <td class="py-4 px-6 text-gray-700">
                        {{ $article->updated_at->timezone('Asia/Jakarta')->format('F d, Y h:i:s A') }}
                    </td>
                    <td class="py-4 px-6 text-center">
                        <a href="{{ route('article.edit', $article->id) }}" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#3A5A40] transition duration-200">Edit</a>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <form action="{{ route('article.destroy', $article->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-[#2C4A37] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#344E41] transition duration-200" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


    {{-- create article button --}}
    <div class="mt-8">
        <a href="{{ route('article.create') }}" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#3A5A40] transition duration-200">Add New Article</a> <!-- Fern Green for the button -->
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
            let dateA = new Date(a.querySelector('td:nth-child(4)').textContent);
            let dateB = new Date(b.querySelector('td:nth-child(4)').textContent);

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
    document.getElementById('dropdownButton').addEventListener('click', function () {
        var dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('hidden');
    });

    // Optionally, you can add a click event listener to hide the dropdown when clicking outside of it
    document.addEventListener('click', function (event) {
        var isClickInside = document.getElementById('dropdownButton').contains(event.target) || document.getElementById('dropdownMenu').contains(event.target);

        if (!isClickInside) {
            document.getElementById('dropdownMenu').classList.add('hidden');
        }
    });
</script>
@endsection
