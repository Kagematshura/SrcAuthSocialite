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
              <a href="{{route('article.index')}}">
                <i class="bx bx-grid-alt"></i>
                <span class="link_name">Dashboard</span>
              </a>
              <span class="tooltip">Dashboard</span>
            </li>
            <li>
              <a href="{{route('profile.index')}}">
                <i class="bx bx-user"></i>
                <span class="link_name">User</span>
              </a>
              <span class="tooltip">User</span>
            </li>
            <li>
                <a href="{{route('drafts.index')}}">
                <i class='bx bx-send'></i>
                  <span class="link_name">Drafts</span>
                </a>
                <span class="tooltip">Pending</span>
              </li>
            <li>
              <a href="{{route('article.home')}}">
                <i class='bx bx-home-alt' ></i>
                <span class="link_name">Home</span>
              </a>
              <span class="tooltip">Home</span>
            </li>
            <li class="profile">
                <div class="profile_details">
                        <div class="flex items-center space-x-2">
                          <img src="{{ asset('storage/' . Auth::user()->profile_picture) ?? 'https://i.pinimg.com/236x/ad/73/1c/ad731cd0da0641bb16090f25778ef0fd.jpg' }}"
                          class="w-10 h-10 rounded-full">
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
            {{-- Filters n Sorting --}}
            <div class="flex justify-between items-center mb-4">
                {{-- Title Filter --}}
                <div class="flex items-center space-x-4">
                    <input type="text" id="titleFilter" class="bg-[#] border border-[#2C4A37] text-[#588157] rounded-lg p-2" placeholder="Filter by title">
                    <button onclick="applyTitleFilter()" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#3A5A40] transition duration-200">Apply Filter</button>
                </div>

                <!-- Sorting -->
                <div class="flex items-center space-x-4">
                    <select id="sortOrder" class="bg-[#2C4A37] border border-[#2C4A37] text-[#DAD7CD] rounded-lg p-2">
                        <option value="asc">Oldest</option>
                        <option value="desc">Newest</option>
                    </select>
                    <button onclick="sortArticles()" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#3A5A40] transition duration-200">Sort</button>
                </div>

                <!-- Sts Filter -->
                <div class="items-center">
                    <button onclick="filterBySts('news')" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">Show News</button>
                    <button onclick="filterBySts('article')" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">Show Article</button>
                    <button onclick="showAllArticles()" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">Show All</button>
                </div>

                <!-- Refresh Filter -->
                <div>
                    <button onclick="refreshFilters()" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#344E41] transition duration-200">Refresh Filters</button> <!-- Darker Green for the button -->
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

            {{-- create article button --}}
            <div class="items-center mt-8">
                <a href="{{ route('article.create', ['sts' => 'news']) }}" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">Add News</a>
                <a href="{{ route('article.create', ['sts' => 'article']) }}" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">Add Article</a>
            </div>
        </section>
    </div>

<script>
    window.onload = function(){
    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector("#btn");
    const searchBtn = document.querySelector(".bx-search")

    closeBtn.addEventListener("click",function(){
        sidebar.classList.toggle("open")
        menuBtnChange()
    })

    searchBtn.addEventListener("click",function(){
        sidebar.classList.toggle("open")
        menuBtnChange()
    })

    function menuBtnChange(){
        if(sidebar.classList.contains("open")){
            closeBtn.classList.replace("bx-menu","bx-menu-alt-right")
        }else{
            closeBtn.classList.replace("bx-menu-alt-right","bx-menu")
        }
    }
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
                rows[i].style.display = ''; // Show row if it matches the filter
            } else {
                rows[i].style.display = 'none'; // Hide row if it doesn't match
            }
        }
    }
}

function sortArticles() {
    var sortOrder = document.getElementById('sortOrder').value;
    var articleTable = document.getElementById('articleTable');
    var rows = Array.from(articleTable.getElementsByTagName('tr'));

    rows.sort(function(a, b) {
        var dateA = new Date(a.getElementsByTagName('td')[5].innerText); // Published On is in 6th column
        var dateB = new Date(b.getElementsByTagName('td')[5].innerText);

        if (isNaN(dateA) || isNaN(dateB)) return 0; // Handle invalid dates

        return sortOrder === 'asc' ? dateA - dateB : dateB - dateA;
    });

    // Append sorted rows back to the table
    rows.forEach(function(row) {
        articleTable.appendChild(row);
    });
}

function refreshFilters() {
    document.getElementById('titleFilter').value = '';
    document.getElementById('sortOrder').value = 'asc';
    applyTitleFilter(); // Reset title filter
    sortArticles(); // Reset sorting to default (ascending)
}

// Filter by 'sts' (news or article)
function filterBySts(sts) {
    var articleTable = document.getElementById('articleTable');
    var rows = articleTable.getElementsByTagName('tr');

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

// Show all articles (reset 'sts' filter)
function showAllArticles() {
    var articleTable = document.getElementById('articleTable');
    var rows = articleTable.getElementsByTagName('tr');

    for (var i = 0; i < rows.length; i++) {
        rows[i].style.display = ''; // Show all rows
    }
}

</script>
@endsection
