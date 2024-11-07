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
<div class="mb-4">
    <button id="defaultContactButton" class="bg-green-500 text-white px-4 py-2 rounded-lg shadow hover:bg-green-600 transition duration-300">
        Add Default Contact
    </button>
    <a href="{{ route('mails.index') }}" class="bg-red-600 text-white px-6 py-2 rounded-lg shadow-lg hover:bg-red-700 transition duration-300 ml-4">
        To Mails
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
    @foreach($contacts as $contact)
    <div data-contact-id="{{ $contact->id }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out relative">
        <h3 class="text-lg font-semibold mb-4">Contacts</h3>
        <div class="flex flex-col space-y-4">
            <div>
                <label class="text-gray-700 font-semibold">WhatsApp</label>
                <span class="contact-display text-green-600 block">{{ $contact->whatsappnum ?? 'N/A' }}</span>
                <input type="text" name="whatsappnum" value="{{ $contact->whatsappnum }}" class="contact-input hidden w-full mt-2 border-2 border-green-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
            </div>

            <div>
                <label class="text-gray-700 font-semibold">Facebook</label>
                <span class="contact-display block">{{ $contact->facebook ?? 'N/A' }}</span>
                <input type="text" name="facebook" value="{{ $contact->facebook }}" class="contact-input hidden w-full mt-2 border-2 border-green-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
            </div>

            <div>
                <label class="text-gray-700 font-semibold">Instagram</label>
                <span class="contact-display block">{{ $contact->instagram ?? 'N/A' }}</span>
                <input type="text" name="instagram" value="{{ $contact->instagram }}" class="contact-input hidden w-full mt-2 border-2 border-green-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
            </div>

            <div>
                <label class="text-gray-700 font-semibold">Twitter</label>
                <span class="contact-display block">{{ $contact->twitter ?? 'N/A' }}</span>
                <input type="text" name="twitter" value="{{ $contact->twitter }}" class="contact-input hidden w-full mt-2 border-2 border-green-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
            </div>

            <div>
                <label class="text-gray-700 font-semibold">TikTok</label>
                <span class="contact-display block">{{ $contact->tiktok ?? 'N/A' }}</span>
                <input type="text" name="tiktok" value="{{ $contact->tiktok }}" class="contact-input hidden w-full mt-2 border-2 border-green-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" />
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <button type="button" class="edit-button bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition duration-300">Edit</button>
            <form action="{{ url('/contact', $contact->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-600 transition duration-300">Delete</button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<a id="whatsappLink" href="#" class="fixed bottom-16 right-5 bg-green-500 text-white w-16 h-16 rounded-full text-center shadow-lg z-50 hover:bg-green-600 transition">
    <i class='bx bxl-whatsapp text-3xl my-4'></i>
</a>

</section>

<script type="text/javascript">
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

$(document).ready(function() {
    $.ajax({
        url: '/contacts/getData',
        type: 'GET',
        success: function(pNumber) {
            $('#pNumber').text(pNumber.whatsappnum);
            let phoneNumber = pNumber.whatsappnum;
            let message = 'Hello, My Niichan!';
            document.getElementById('whatsappLink').href = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodeURIComponent(message)}`;
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
        }
    });

    function checkContactData() {
        const contactCards = document.querySelectorAll('div[data-contact-id]');

        if (contactCards.length > 0) {
            defaultContactButton.disabled = true;
            defaultContactButton.classList.add('cursor-not-allowed', 'opacity-50');
        } else {
            defaultContactButton.disabled = false;
            defaultContactButton.classList.remove('cursor-not-allowed', 'opacity-50');
        }
    }

    checkContactData();

    $('#defaultContactButton').on('click', function() {
        const defaultData = {
            _token: '{{ csrf_token() }}',
            id: '1',
            whatsappnum: 'whatsapp',
            facebook: 'facebook',
            instagram: 'instagram',
            twitter: 'twitter',
            tiktok: 'tiktok',
        };

        fetch('{{ url('/contact') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(defaultData),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Default contact added:', data);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    });

    // Toggle Edit Button Functionality
    $('.edit-button').on('click', function() {
    const card = $(this).closest('div[data-contact-id]');
    const isEditing = $(this).text() === 'Edit';

    // Toggle display and input fields
    card.find('.contact-input').toggleClass('hidden');
    card.find('.contact-display').toggleClass('hidden');
    $(this).text(isEditing ? 'Save' : 'Edit');

    // Update contact on save
    if (!isEditing) {
        const contactId = card.data('contact-id');
        const updatedData = {
            _token: '{{ csrf_token() }}',
            whatsappnum: card.find('input[name="whatsappnum"]').val(),
            facebook: card.find('input[name="facebook"]').val(),
            instagram: card.find('input[name="instagram"]').val(),
            twitter: card.find('input[name="twitter"]').val(),
            tiktok: card.find('input[name="tiktok"]').val(),
        };

        // Show loading indication (optional)
        $(this).addClass('loading').prop('disabled', true).text('Saving...');

        fetch(`{{ url('/contact') }}/${contactId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(updatedData),
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            console.log('Updated contact:', data);

            // Success message and reset button text
            $(this).removeClass('loading').prop('disabled', false).text('Edit');
            alert('Contact updated successfully!');
            location.reload();
        })
        .catch(error => {
            $(this).removeClass('loading').prop('disabled', false).text('Save');
      alert('There was an error updating the contact.');
            console.error(error);
        });
    }
});
});
</script>
@endsection
