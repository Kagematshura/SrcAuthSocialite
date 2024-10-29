@extends('layout.app')

@section('content')
@vite('resources/css/sidebar.css')
<head>
    @php
        $favicon = App\Models\Favicon::latest()->first();
    @endphp
</head>
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

<section class="home-section flex-1 p-8">
<div class="flex items-center justify-center">
    <form action="{{ route('upload.favicon') }}" method="POST" enctype="multipart/form-data" class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
        @csrf
        <h2 class="text-2xl font-bold text-center text-black mb-6">Upload Favicon</h2>
        @if($favicon && $favicon->favicon_path)
            <div class="mb-6 text-center">
                <img alt="Current Favicon" class="w-42 h-42 mx-auto border border-gray-300" src="{{ asset('storage/' . $favicon->favicon_path) }}">
                <p class="text-sm text-gray-500 mt-2">Current Image</p>
            </div>
        @endif
        <label for="favicon" class="block text-gray-700 text-sm font-semibold mb-2">Choose a new Favicon:</label>
        <input type="file" name="favicon" accept="image/x-icon,image/png" required class="block w-full text-sm text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-4 py-2 px-3 transition duration-200 ease-in-out">
        <button type="submit" class="w-full bg-[#588157] text-white px-4 py-2 rounded-lg hover:bg-[#3c573b] transition duration-300 ease-in-out shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Upload</button>
    </form>
</div>
<h3 class="text-lg font-semibold mb-4">Previous Favicons</h3>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b bg-[#2C4A37] text-white font-semibold text-left">Favicon</th>
                <th class="px-6 py-3 border-b bg-[#2C4A37] text-white font-semibold text-left">Uploaded</th>
                <th class="px-6 py-3 border-b bg-[#2C4A37] text-white font-semibold text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($favicons as $favicon)
                <tr class="border-b">
                    <td class="px-6 py-4">
                        <img src="{{ asset('storage/' . $favicon->favicon_path) }}" class="w-16 h-16 rounded-full" alt="Favicon">
                    </td>
                    <td class="px-6 py-4">
                        {{ \Carbon\Carbon::parse($favicon->created_at)->diffForHumans() }}
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('delete.favicon', $favicon->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</section>
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
</script>
@endsection
