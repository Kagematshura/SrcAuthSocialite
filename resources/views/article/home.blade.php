@extends('layout.app')

@section('content')

@vite('resources/css/sidebar.css')

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
            <a href="{{ route('dashboard.index') }}" onclick="updatePath('Dashboard')">
                <i class="bx bx-grid-alt"></i>
                <span class="link_name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>
        <li>
            <a href="{{route('article.index')}}" onclick="toggleDropdown('dropdown1')">
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
                <a href="{{ route('favicon.index') }}" class="pl-6" onclick="updatePath('Utilities', 'User')">
                    <i class='bx bx-image-add'></i>
                    <span class="link_name">Favicons</span>
                </a>
                <li>
                    <a href="" class="pl-6" onclick="updatePath('Utilities', 'WhatsApp')">
                        <i class='bx bxl-whatsapp'></i>
                        <span class="link_name">WhatsApp</span>
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

  <div class="home-section px-4 py-8">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-4xl font-extrabold text-[#DAD7CD]">Latest Articles</h1>

        <!-- Sts Filter -->
        <div class="items-center">
            <button onclick="filterBySts('news')" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">Show News</button>
            <button onclick="filterBySts('article')" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">Show Article</button>
            <button onclick="showAllArticles()" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">Show All</button>
        </div>

        <a href="{{ route('article.home') }}" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
        </a>

        <a href="{{ route('drafts.create') }}" class="bg-[#588157] text-white px-6 py-2 rounded-lg shadow-lg hover:bg-[#3A5A40] transition duration-300">
            Feeling like writing something?
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="articleGrid">
        @foreach ($t_post as $article)
            <div class="article-card bg-[#3A5A40] shadow-lg rounded-lg overflow-hidden transition-transform transform hover:scale-105" data-sts="{{ $article->sts }}">
                <img src="{{ $article->image_path ? asset('storage/' . $article->image_path) : 'https://via.placeholder.com/400x200' }}"
                     alt="Article Image" class="w-full h-48 object-cover">

                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-3 text-[#DAD7CD] truncate">
                        <a href="{{ route('article.show', $article->id) }}" class="transition duration-300">
                            {{ $article->title }}
                        </a>
                    </h2>

                    <p class="text-[#DAD7CD] mb-4 leading-relaxed">
                        {{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($article->content)), 70, '...') }}
                    </p>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('article.show', $article->id) }}" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow hover:bg-[#3A5A40] transition duration-300">
                            Read More
                        </a>
                        <span class="text-white text-sm">
                            {{ $article->created_at->format('M d, Y - H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-10 flex justify-center">
        {{ $t_post->links('pagination::tailwind') }}
    </div>
</div>

<script>
  window.onload = function () {
        const sidebar = document.querySelector(".sidebar");
        const closeBtn = document.querySelector("#btn");

        closeBtn.addEventListener("click", function () {
            sidebar.classList.toggle("open");
            closeDropdowns(); // Close dropdowns when collapsing sidebar
            menuBtnChange();
        });

        function menuBtnChange() {
            if (sidebar.classList.contains("open")) {
                closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else {
                closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
            }
        }

        // Function to close all dropdowns when sidebar is collapsed
        function closeDropdowns() {
            var dropdowns = document.querySelectorAll('.dropdown');
            dropdowns.forEach(function (dropdown) {
                dropdown.classList.add('hidden');
            });
        }
    };

    // Function to toggle individual dropdowns
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        dropdown.classList.toggle('hidden');
    }

    function filterBySts(sts) {
        var articles = document.querySelectorAll('.article-card');
        articles.forEach(function (article) {
            if (article.getAttribute('data-sts') === sts) {
                article.style.display = 'block';
            } else {
                article.style.display = 'none';
            }
        });
    }

    function showAllArticles() {
        var articles = document.querySelectorAll('.article-card');
        articles.forEach(function (article) {
            article.style.display = 'block';
        });
    }
</script>
<style>
    body{
        background-color:#344E41
    }
</style>
@endsection
