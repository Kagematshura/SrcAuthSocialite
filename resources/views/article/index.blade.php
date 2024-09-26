@extends('layout.app')

@section('content')
<div class="min-h-screen">
    {{-- Sidebar and Content Wrapper --}}
    <div class="sidebar">
        <div class="logo_details">
            <i>
                <img src="" alt="">
            </i>
            <div class="logo_name">Laz GDI</div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="{{ route('article.index') }}" onclick="updatePath('Dashboard')">
                    <i class="bx bx-grid-alt"></i>
                    <span class="link_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="javascript:void(0)" onclick="toggleDropdown('dropdown1')">
                    <i class="bx bx-folder"></i>
                    <span class="link_name">Post <i class="bx bx-chevron-down"></i></span>
                </a>
                <span class="tooltip">Post</span>
                <!-- Dropdown Menu -->
                <ul class="dropdown hidden" id="dropdown1">
                    <li onclick="filterBySts('news'); updatePath('Post', 'News')">
                        <a href="#" class="ddItems pl-6">
                            <i class='bx bx-news'></i>
                            <span class="link_name">News</span>
                        </a>
                    </li>
                    <li onclick="filterBySts('article'); updatePath('Post', 'Articles')">
                        <a href="#" class="ddItems pl-6">
                            <i class='bx bx-file'></i>
                            <span class="link_name">Articles</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0)" onclick="toggleDropdown('dropdown2')">
                    <i class='bx bx-slider-alt'></i>
                    <span class="link_name">Utilities <i class="bx bx-chevron-down"></i></span>
                </a>
                <span class="tooltip">Utilities</span>
                <!-- Dropdown Menu -->
                <ul class="dropdown hidden" id="dropdown2">
                    <li>
                        <a href="{{ route('profile.index') }}" class="pl-6" onclick="updatePath('Utilities', 'User')">
                            <i class="bx bx-user"></i>
                            <span class="link_name">User</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('drafts.index') }}" class="pl-6" onclick="updatePath('Utilities', 'Drafts')">
                            <i class='bx bx-send'></i>
                            <span class="link_name">Drafts</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('article.home') }}" onclick="updatePath('Home')">
                    <i class='bx bx-home-alt'></i>
                    <span class="link_name">Home</span>
                </a>
                <span class="tooltip">Home</span>
            </li>
            <li class="profile">
                <div class="profile_details">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture ?? 'default.jpg') }}" class="w-10 h-10 rounded-full" alt="Profile Picture">
                        <span class="text-[#DAD7CD]">{{ Str::limit(strip_tags(auth()->user()->name), 15, '...') ?? 'Guest' }}</span>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" id="log_out" class="bg-[#2C4A37] text-white w-full h-12 flex items-center justify-center rounded-lg shadow-lg hover:bg-[#344E41] transition duration-200">
                        <i class="bx bx-log-out"></i>
                    </button>
                </form>
            </li>
        </ul>
    </div>

        {{-- Your content goes here --}}
        <section class="home-section flex-1 p-8">

             {{-- Breadcrumb / Path Display --}}
        <div class="mb-8">
            <span id="pathDisplay">Dashboard</span>
            <input type="hidden" id="currentPath" value="Home">
        </div>

           {{-- Filters n Sorting --}}
        <div class="flex justify-between items-center mb-4">

            {{-- Title Filter --}}
            <div class="flex items-center space-x-4">
                <input type="text" id="titleFilter" class="bg-[#] border border-[#2C4A37] text-[#588157] rounded-lg p-2" placeholder="Filter by title">
                <button onclick="applyTitleFilter()" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#3A5A40] transition duration-200">Apply Filter</button>
            </div>

            {{-- Sorting --}}
            <div class="flex items-center space-x-4">
                <select id="sortOrder" class="bg-[#2C4A37] border border-[#2C4A37] text-[#DAD7CD] rounded-lg p-2">
                    <option value="asc">Oldest</option>
                    <option value="desc">Newest</option>
                </select>
                <button onclick="sortArticles()" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#3A5A40] transition duration-200">Sort</button>
            </div>

            {{-- Create Article Button --}}
            <div class="flex items-center space-x-4">
                <a href="{{ route('article.create', ['sts' => 'news']) }}" id="createNewsBtn" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#344E41] transition duration-200" style="display: none;">Add News</a>
                <a href="{{ route('article.create', ['sts' => 'article']) }}" id="createArticleBtn" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#344E41] transition duration-200" style="display: none;">Add Article</a>
            </div>

            {{-- Refresh Filter --}}
            <div>
                <button onclick="refreshFilters()" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#344E41] transition duration-200">Refresh Filters</button>
            </div>
        </div>

            {{-- Table --}}
            <div class="overflow-x-auto bg-[#2C4A37] p-4 rounded-lg shadow-lg">
                <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                    <thead>
                        <tr class="border-b border-gray-200 bg-[#3A5A40] text-[#DAD7CD]">
                            <th class="py-3 px-6 text-left text-sm font-semibold">Title</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold">Snippet</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold">Published By</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold">Categories</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold">Type</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold">Published On</th>
                            <th class="py-3 px-6 text-left text-sm font-semibold">Last Updated</th>
                            <th class="py-3 px-6 text-center text-sm font-semibold" colspan="2">Action</th>
                        </tr>
                    </thead>
                    {{-- Table body --}}
                    <tbody id="articleTable">
                        @foreach ($t_post as $article)
                            <tr class="border-b border-gray-200 hover:bg-[#3A5A40] transition duration-200">
                                <td class="py-4 px-6 text-gray-900">
                                    <a href="{{ route('article.show', $article->id) }}" class="text-[#588157] hover:text-[#DAD7CD] font-semibold">
                                    {{ Str::limit(strip_tags($article->title), 20, '...') }}
                                    </a>
                                </td>
                                <td class="py-4 px-4 text-gray-700">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($article->content), 50, '...') }}
                                </td>
                                <td class="flex flex-row py-4 px-4 text-gray-700">
                                    <img src="{{ asset('storage/' . $article->user->profile_picture) ?? 'https://i.pinimg.com/236x/ad/73/1c/ad731cd0da0641bb16090f25778ef0fd.jpg' }}"
                                    style="width: 25px; height: 25px;" class="rounded-full object-cover" alt="Profile Picture">
                                    <p class="pl-4">{{ Str::limit(strip_tags($article->user->name), 10, '...') ?? 'Guest' }}</p>
                                </td>
                                <td class="py-4 px-6 text-gray-700">
                                    {{ ucfirst($article->category ?? 'Unregistered')}}
                                </td>
                                <td class="py-4 px-6 text-gray-700">
                                    {{ ucfirst($article->sts ?? 'Unregistered') }}
                                </td>
                                <td class="py-4 px-4 text-gray-700">
                                    {{ $article->created_at->timezone('Asia/Jakarta')->format('F j, Y g:i A')  }}
                                </td>
                                <td class="py-4 px-4 text-gray-700">
                                    {{ $article->updated_at->timezone('Asia/Jakarta')->format('F j, Y g:i A') }}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <a href="{{ route('article.edit', $article->id) }}" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#3A5A40] transition duration-200">Edit</a>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <form action="{{ route('article.destroy', $article->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-[#B54242] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#6a1f1f] transition duration-200" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            <div class="mt-8">
                {{ $t_post->links('pagination::tailwind') }}
            </div>

        </section>
    </div>

<script>
window.onload = function(){
    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector("#btn");

    closeBtn.addEventListener("click", function(){
        sidebar.classList.toggle("open");
        menuBtnChange();
        closeAllDropdowns();
    });
}

function toggleDropdown(id) {
    var dropdown = document.getElementById(id);
    dropdown.classList.toggle("hidden");
}

function closeAllDropdowns() {
    var dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(function(dropdown) {
        dropdown.classList.add('hidden');
    });
}

// Function to update the path/address display
function updatePath(...segments) {
    const currentPath = segments.join(' > ');
    document.getElementById('pathDisplay').innerText = currentPath;
    document.getElementById('currentPath').value = currentPath;
}

function applyTitleFilter() {
    var titleFilter = document.getElementById('titleFilter').value.trim().toLowerCase();
    var articleTable = document.getElementById('articleTable');
    var rows = articleTable.getElementsByTagName('tr');

    for (var i = 0; i < rows.length; i++) {
        var titleCell = rows[i].getElementsByTagName('td')[0]; // Assuming title is in the first column
        if (titleCell) {
            var titleText = titleCell.textContent || titleCell.innerText;
            titleText = titleText.trim().toLowerCase(); // Trim spaces and convert to lowercase for comparison

            // Check if the title contains the filter text
            if (titleText.includes(titleFilter)) {
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
        var dateA = new Date(a.getElementsByTagName('td')[5].innerText);
        var dateB = new Date(b.getElementsByTagName('td')[5].innerText);

        if (isNaN(dateA) || isNaN(dateB)) return 0;

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

// Filter by 'sts' (news or article)
function filterBySts(sts) {
    var articleTable = document.getElementById('articleTable');
    var rows = articleTable.getElementsByTagName('tr');

    // Show/hide the relevant create buttons
    var createNewsBtn = document.getElementById('createNewsBtn');
    var createArticleBtn = document.getElementById('createArticleBtn');

    if (sts === 'news') {
        createNewsBtn.style.display = 'inline-block';
        createArticleBtn.style.display = 'none';
    } else if (sts === 'article') {
        createNewsBtn.style.display = 'none';
        createArticleBtn.style.display = 'inline-block';
    }

    // Filter articles by 'sts'
    for (var i = 0; i < rows.length; i++) {
        var stsCell = rows[i].getElementsByTagName('td')[4]; // Assuming 'Type' (sts) is in the 5th column
        if (stsCell) {
            var stsText = stsCell.textContent || stsCell.innerText;
            stsText = stsText.trim().toLowerCase(); // Normalize text

            // Show row if it matches the 'sts' filter (news or article)
            if (stsText === sts.toLowerCase()) {
                rows[i].style.display = ''; // Show matching rows
            } else {
                rows[i].style.display = 'none'; // Hide non-matching rows
            }
        }
    }
}

// Reset both buttons when showing all articles
function showAllArticles() {
    var articleTable = document.getElementById('articleTable');
    var rows = articleTable.getElementsByTagName('tr');

    // Show all rows
    for (var i = 0; i < rows.length; i++) {
        rows[i].style.display = '';
    }

    // Hide both create buttons when showing all articles
    var createNewsBtn = document.getElementById('createNewsBtn');
    var createArticleBtn = document.getElementById('createArticleBtn');

    createNewsBtn.style.display = 'none';
    createArticleBtn.style.display = 'none';
}


function menuBtnChange() {
    const closeBtn = document.querySelector("#btn");
    if (closeBtn.classList.contains("bx-menu")) {
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
    } else {
        closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    }
}

</script>
@endsection
