@extends('layout.app')

@section('content')

@vite('resources/css/sidebar.css')

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
            <a href="{{ route('dashboard.index') }}" onclick="updatePath('Dashboard')">
                <i class="bx bx-grid-alt"></i>
                <span class="link_name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>
        <li>
            <a href="#" onclick="toggleDropdown('dropdown1')">
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
                <a onclick="openModal('news', 'news')" id="createNewsBtn" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#344E41] transition duration-200" style="display: none;">Add News</a>
                <a onclick="openModal('article', 'article')" id="createArticleBtn" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#344E41] transition duration-200" style="display: none;">Add Article</a>
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
                                    <button onclick="openEditModal('{{ $article->id }}')" class="bg-[#588157] text-white px-4 py-2 rounded-lg shadow-lg hover:bg-[#3A5A40] transition duration-200">Edit</button>
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

                <!-- Create Modal -->
<div id="createModals" enctype="multipart/form-data" class="hidden fixed inset-0 bg-gray-800 bg-opacity-70 flex justify-center items-center">
    <div class="bg-white rounded-xl p-8 shadow-2xl max-w-lg w-full transform transition-all duration-300 scale-95 hover:scale-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6" id="createModalTitle">Create Article</h2>
        <form id="createForm">
            <div id="error-messages" class="text-red-500 mb-4"></div>
            @csrf
            <input type="hidden" name="sts" id="sts" value="">

            <!-- Title -->
            <div class="mb-6">
                <label class="block text-gray-700 text-lg font-medium mb-2" for="title">Title</label>
                <input type="text" name="title" id="title" placeholder="Enter your title here..."
                       class="shadow-sm border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200">
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label class="block text-gray-700 text-lg font-medium mb-2" for="category">Category</label>
                <select name="category" id="category" required
                        class="shadow-sm border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200">
                    <option value="" disabled selected>Select a category</option>
                    <!-- Categories will be dynamically populated -->
                </select>
            </div>

            <!-- Image -->
            <div class="mb-6">
                <label class="block text-gray-700 text-lg font-medium mb-2" for="image">Image</label>
                <input type="file" name="image" id="image"
                       class="shadow-sm border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200">
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label class="block text-gray-700 text-lg font-medium mb-2" for="content">Content</label>
                <textarea name="content" id="content" rows="8" placeholder="Write your article content here..."
                          class="shadow-sm border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg focus:outline-none transition duration-200">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg focus:outline-none transition duration-200">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>


    <!-- Edit Modal -->
<div id="editModals" data-id="{{ $article->id ?? '' }}" enctype="multipart/form-data" class="hidden fixed inset-0 bg-gray-800 bg-opacity-70 flex justify-center items-center">
    <div class="bg-white rounded-xl p-8 shadow-2xl max-w-lg w-full transform transition-all duration-300 scale-95 hover:scale-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6" id="editModalTitle"></h2>
        <form id="editForm">
            <div id="error-messages" class="text-red-500 mb-4"></div>
            @csrf
            @method('PATCH')
            <input type="hidden" name="sts" id="stsEdit" value="">

            <!-- Title -->
            <div class="mb-6">
                <label class="block text-gray-700 text-lg font-medium mb-2" for="title">Title</label>
                <input type="text" name="title" id="titleEdit" value="" placeholder="Enter page's title" required
                       class="shadow-sm border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200">
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label class="block text-gray-700 text-lg font-medium mb-2" for="category">Category</label>
                <select name="category" id="categoryEdit" required
                        class="shadow-sm border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200">
                    <option value="" disabled selected>Null on category selection?</option>
                    <!-- Categories will be dynamically populated -->
                </select>
            </div>

            <!-- Image -->
            <div class="mb-6">
                <label class="block text-gray-700 text-lg font-medium mb-2" for="image">Image</label>
                <img id="post-image" alt="Image" class="w-32 h-32 object-cover rounded-lg shadow-md mt-4">
                <p class="text-sm text-gray-500 mt-2">Current Image</p>
                <input type="file" name="image" id="image"
                       class="block w-full text-gray-800 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200 mt-4">
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label class="block text-gray-700 text-lg font-medium mb-2" for="contentEdit">Content</label>
                <textarea name="content" id="contentEdit" rows="8" placeholder="Write your article content here..." required
                          class="shadow-sm border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200"></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeEditModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg focus:outline-none transition duration-200">
                    Cancel
                </button>
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg focus:outline-none transition duration-200">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

        </section>
    </div>

    <script src="https://cdn.tiny.cloud/1/t4d8f3p0fnqaze0wj0rfr1kxftjdeulfrkzscrmzj1eokgrc/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
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

// Start of modals script
    tinymce.init({
        selector: '#content',
        menubar: false,
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image code',
        height: 200,
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }
    });

    tinymce.init({
        selector: '#contentEdit',
        menubar: false,
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image code',
        height: 200,
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }
    });

    // Open the modal and set the sts value
    function openModal(stsType) {
        const form = document.getElementById('createForm');

        form.reset();
        form.removeAttribute('data-id');
        form.action = '{{ route('article.store') }}';
        form.method = 'POST';

        document.getElementById('sts').value = stsType;
        document.getElementById('createModalTitle').innerText = stsType === 'news' ? 'Create News' : 'Create Article';

        populateCategories(stsType);

        // Reinitialize TinyMCE to ensure the content field is functional
    tinymce.get('content').setContent('');
    tinymce.init({
        selector: '#content',
        menubar: false,
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image code',
        height: 200,
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }
    });
        document.getElementById('createModals').classList.remove('hidden');
    }

    // Open the modal for editing an article
    function openEditModal(id) {
    fetch(`/articles/${id}/edit`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(article => {
    const form = document.getElementById('editForm');
    document.getElementById('titleEdit').value = article.title;
    document.getElementById('categoryEdit').value = article.category;
    document.getElementById('contentEdit').value = article.content;
    document.getElementById('stsEdit').value = article.sts;

    tinymce.get('contentEdit').setContent(article.content);

    document.getElementById('editModalTitle').innerText = article.sts === 'news' ? 'Edit News' : 'Edit Article';

    populateImageEdit(article.image_path);
    populateCategoriesEdit(article.sts, article.category);

    form.setAttribute('data-id', article.id);
    form.action = `/articles/${id}`;
    form.method = 'PATCH';
    let formData = new FormData(form);
    formData.append('_method', 'PATCH');

    // Reinitialize TinyMCE to ensure the content field is functional
    tinymce.init({
        selector: '#contentEdit',
        menubar: false,
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image code',
        height: 200,
        setup: function(editor) {
            editor.on('change', function() {
                tinymce.triggerSave();
            });
        }
    });

    document.getElementById('editModals').classList.remove('hidden');
})
    .catch(error => {
        console.error('Error fetching article:', error);
    });
}

    function closeModal() {
        clearCategories();
        document.getElementById('createModals').classList.add('hidden');
    }

    function closeEditModal() {
        clearCategories();
        document.getElementById('editModals').classList.add('hidden');
    }


    // Handle form submission
    document.getElementById('createForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const id = this.getAttribute('data-id');
    const formData = new FormData(this);

    const method = 'POST';
    const url = '{{ route('article.store') }}';

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal();
            location.reload();
        } else if (data.errors) {
            displayValidationErrors(data.errors);
        }
    })

    .catch(error => {
        console.error('Fetch error:', error);
    });

    for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }
});

    document.getElementById('editForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const id = this.getAttribute('data-id');
        const url = `/articles/${id}`;

        const formData = new FormData(this);

        $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-HTTP-Method-Override': 'PATCH',
        },
        success: function(response) {
            console.log(response);
            closeEditModal();
            location.reload();
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseJSON);
        }
        });

        // formData debugging
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }
    });


    // Function to display validation errors on the form
    function displayValidationErrors(errors) {
        let errorList = '';

        Object.keys(errors).forEach((field) => {
            errors[field].forEach((errorMsg) => {
                errorList += `<p>${errorMsg}</p>`;
            });

            let inputField = document.querySelector(`[name=${field}]`);
            if (inputField) {
                inputField.classList.add('border-red-500');
            }
        });

        document.querySelectorAll('input, select, textarea').forEach((field) => {
            field.addEventListener('input', function() {
                this.classList.remove('border-red-500');
            });
        });

        document.getElementById('error-messages').innerHTML = errorList;
    }

    function populateCategories(stsType) {
    let categories = {
        news: ['Culture', 'Smile', 'Love'],
        article: ['Information', 'Knowledge']
    };

    let categorySelect = document.getElementById('category');

    categorySelect.innerHTML = '';

    categories[stsType].forEach(category => {
        let option = document.createElement('option');
        option.value = category.toLowerCase();
        option.text = category;
        categorySelect.appendChild(option);
    });
};

function populateCategoriesEdit(stsType, selectedCategory) {
    let categories = {
        news: ['Culture', 'Smile', 'Love'],
        article: ['Information', 'Knowledge']
    };

    let categorySelectEdit = document.getElementById('categoryEdit');
    categorySelectEdit.innerHTML = '';

    categories[stsType].forEach(category => {
        let option = document.createElement('option');
        option.value = category.toLowerCase();
        option.text = category;

        // Check if the current option matches the article's category
        if (category.toLowerCase() === selectedCategory.toLowerCase()) {
            option.selected = true;
        }

        categorySelectEdit.appendChild(option);
    });
}

    function clearCategories() {
        let categorySelect = document.getElementById('category');
        categorySelect.innerHTML = '';
        let categorySelectEdit = document.getElementById('categoryEdit');
        categorySelectEdit.innerHTML = '';
    }

    function populateImageEdit(imageUrl) {
    const imageElement = document.getElementById('post-image');
    if (imageUrl) {
        imageElement.src = `storage/${imageUrl}`;
    } else {
        imageElement.src = 'https://github.com/WardenHi/lavarel-intern/blob/lavarel-intern/public/img/image-post-default.png?raw=true';  // If no image, set a default placeholder
    }
}
</script>
@endsection
