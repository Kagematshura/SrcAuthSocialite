@extends('layout.app')

@section('content')
<!-- Sidebar and Content Wrapper -->
<div class="flex min-h-screen bg-[#3A5A40]">
    <!-- Sidebar -->
    <aside id="sidebar" class="bg-[#3A5A40] w-64 space-y-6 px-4 py-4 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out shadow-lg z-30">
        <!-- Logo -->
        <div class="text-[#DAD7CD] text-2xl font-bold">My App</div>

        <!-- Menu Links -->
        <nav class="mt-8">
            <ul class="space-y-2">
                <li>
                    <a href="#" class="block py-2 px-4 rounded-lg bg-[#2C4A37] hover:bg-[#588157] text-[#DAD7CD] hover:text-white transition duration-200">Home</a>
                </li>
                <li>
                    <a href="#" class="block py-2 px-4 rounded-lg bg-[#2C4A37] hover:bg-[#588157] text-[#DAD7CD] hover:text-white transition duration-200">Articles</a>
                </li>
                <li>
                    <a href="#" class="block py-2 px-4 rounded-lg bg-[#2C4A37] hover:bg-[#588157] text-[#DAD7CD] hover:text-white transition duration-200">Contact</a>
                </li>
            </ul>
        </nav>

        <!-- Profile Dropdown -->
        <div class="mt-10">
            <button id="dropdownButton" class="flex items-center justify-between w-full text-[#DAD7CD] hover:text-white focus:outline-none py-2 px-4 rounded-lg bg-[#2C4A37] hover:bg-[#588157] transition duration-200">
                <div class="flex items-center space-x-2">
                    <img src="{{ auth()->user()->profile_picture_url ?? 'https://via.placeholder.com/40' }}" class="w-10 h-10 rounded-full" alt="Profile Picture">
                    <span>{{ auth()->user()->name ?? 'Guest' }}</span>
                </div>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="dropdownMenu" class="hidden mt-2 bg-[#3A5A40] rounded-lg shadow-lg py-2 z-20">
                <a href="#" class="block px-4 py-2 text-[#DAD7CD] hover:bg-[#2C4A37] transition duration-200">Profile</a>
                <a href="#" class="block px-4 py-2 text-[#DAD7CD] hover:bg-[#2C4A37] transition duration-200">Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-[#DAD7CD] hover:bg-[#2C4A37] transition duration-200">Logout</button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Header with Sidebar Toggle Button -->
        <header class="bg-[#3A5A40] text-[#DAD7CD] p-4 shadow-md md:hidden">
            <div class="flex justify-between items-center">
                <button id="toggleSidebar" class="text-[#DAD7CD] focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                <div class="text-2xl font-bold">My App</div>
            </div>
        </header>

        {{-- Your content goes here --}}
        <main class="flex-1 p-8">
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
                                    {{ $article->user->name ?? 'Unknown' }}
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
                <a href="{{ route('article.create') }}" class="bg-[#588157] text-white px-6 py-2 rounded-lg shadow-lg hover:bg-[#3A5A40] transition duration-200">
                    Create New Article
                </a>
            </div>
        </main>
    </div>
</div>

<script>
    // JavaScript for Sidebar and Dropdown
    document.getElementById('toggleSidebar').addEventListener('click', function() {
        var sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('-translate-x-full');
    });

    document.getElementById('dropdownButton').addEventListener('click', function() {
        var dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('hidden');
    });

    function applyTitleFilter() {
        var titleFilter = document.getElementById('titleFilter').value.toLowerCase();
        var articleTable = document.getElementById('articleTable');
        var rows = articleTable.getElementsByTagName('tr');

        for (var i = 0; i < rows.length; i++) {
            var titleCell = rows[i].getElementsByTagName('td')[0];
            if (titleCell) {
                var titleText = titleCell.textContent || titleCell.innerText;
                if (titleText.toLowerCase().indexOf(titleFilter) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }

    function sortArticles() {
        var sortOrder = document.getElementById('sortOrder').value;
        var articleTable = document.getElementById('articleTable');
        var rows = Array.from(articleTable.getElementsByTagName('tr'));

        rows.sort(function(a, b) {
            var dateA = new Date(a.getElementsByTagName('td')[3].innerText);
            var dateB = new Date(b.getElementsByTagName('td')[3].innerText);

            return sortOrder === 'asc' ? dateA - dateB : dateB - dateA;
        });

        rows.forEach(function(row) {
            articleTable.appendChild(row);
        });
    }

    function refreshFilters() {
        document.getElementById('titleFilter').value = '';
        document.getElementById('sortOrder').value = 'asc';
        applyTitleFilter();
        sortArticles();
    }
</script>
@endsection
