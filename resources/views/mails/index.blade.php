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
                    <a href="{{route('contacts.index')}}" class="pl-6" onclick="updatePath('Utilities', 'WhatsApp')">
                        <i class='bx bxl-whatsapp'></i>
                        <span class="link_name">WhatsApp</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('mails.index')}}" class="pl-6" onclick="updatePath('Utilities', 'WhatsApp')">
                        <i class='bx bx-envelope'></i>
                        <span class="link_name">Mails</span>
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
<div class="container mx-auto p-8 max-w-7xl">
    <div class="flex items-center justify-between">
        <h1 class="text-5xl font-extrabold mb-10 text-[#DAD7CD]">Mailbox</h1>
        <a href="{{ route('mails.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-lg hover:bg-blue-700 transition duration-300">
            Test Create
        </a>
    </div>

    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Sent by</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Sent at</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($mails as $mail)
                    <tr class="hover:bg-gray-100 transition duration-200 ease-in-out">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <a href="{{ route('mails.show', $mail->id) }}" class="text-blue-600 hover:text-blue-800">
                                {{ $mail->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mail->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mail->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mail->created_at->timezone('Asia/Jakarta')->format('F d, Y h:i:s A') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <form action="{{ secure_url('/mails', $mail->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 transition duration-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
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
