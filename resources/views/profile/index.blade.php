@extends('layout.profile')

@section('content')
<div class="bg-[#344E41] text-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-xl">
        <a href="{{route('article.index')}}">
            <i class='bx bx-arrow-back text-2xl'></i>
        </a>
        <!-- Profile Section -->
        <div class="flex flex-col items-center">
            <img src="{{ asset('storage/' . Auth::user()->profile_picture) ?? 'https://i.pinimg.com/236x/ad/73/1c/ad731cd0da0641bb16090f25778ef0fd.jpg' }}"
            style="width: 160px; height: 160px;" class="rounded-full object-cover" alt="Profile Picture">
            <h1 class="text-2xl font-semibold mt-4 text-[#DAD7CD]">{{ auth()->user()->name ?? 'Guest' }}</h1>
            <p class="text-[#A3B18A]">{{ Auth::user()->email }}</p>
            <div class="flex space-x-4 mt-4">
                <button id="settings-button" class="bg-[#3A5A40] hover:bg-[#588157] px-4 py-2 rounded-lg flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-white">Update Profile</span>
                </button>
                <button class="bg-[#3A5A40] hover:bg-[#588157] px-4 py-2 rounded-lg flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M15.75 4.5a3 3 0 1 1 .825 2.066l-8.421 4.679a3.002 3.002 0 0 1 0 1.51l8.421 4.679a3 3 0 1 1-.729 1.31l-8.421-4.678a3 3 0 1 1 0-4.132l8.421-4.679a3 3 0 0 1-.096-.755Z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-white">Share</span>
                </button>
            </div>
        </div>

<!-- Edit Profile Modal -->
<div id="edit-profile-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-[#2C4A37] p-6 rounded-lg shadow-lg w-full max-w-md" style="width: 500px; height: 550px;"> <!-- Fixed width and height -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-4 flex h-full">
            @csrf
            @method('PUT')

            <!-- Left-side Buttons -->
            <div class="flex flex-col text-left space-y-4 mr-6" id="left-side-buttons">
                <a href="#" class="text-[#DAD7CD] hover:text-[#588157]" id="b-profile">Profile</a>
                <a href="#" class="text-[#DAD7CD] hover:text-[#588157]" id="b-account">Account</a>
                <a href="#" class="text-[#DAD7CD] hover:text-[#588157]" id="b-preference">Preference</a>
            </div>

            <!-- Right-side Form Inputs -->
            <div class="flex-grow">
                <!-- Profile Section -->
                <div id="edit-profile" class="section active flex flex-col justify-between">
                    <img src="{{ asset('storage/' . Auth::user()->profile_picture) ?? 'https://i.pinimg.com/236x/ad/73/1c/ad731cd0da0641bb16090f25778ef0fd.jpg' }}"
                         class="rounded-full object-cover mx-auto"
                         style="width: 160px; height: 160px;" alt="Profile Picture">
                    <div class="mb-4">
                        <label for="profile_picture" class="block text-[#DAD7CD]">Profile Picture</label>
                        <input type="file" id="profile_picture" name="profile_picture" class="mt-1 p-2 w-full bg-[#1F2D14] text-white rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="name" class="block text-[#DAD7CD]">Name</label>
                        <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" class="mt-1 p-2 w-full bg-[#1F2D14] text-white rounded-lg">
                    </div>
                </div>

                <!-- Account Section -->
                <div id="account" class="section hidden h-full">
                    <p class="text-[#DAD7CD]">Email: {{ Auth::user()->email }}</p>
                </div>

                <!-- Preference Section -->
                <div id="preference" class="section hidden h-full">
                    <p class="text-[#DAD7CD]">Preference settings here...</p>
                </div>

                <!-- Save and Cancel Buttons -->
                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-[#3A5A40] hover:bg-[#588157] px-4 py-2 rounded-lg text-white">Save</button>
                    <button id="cancel-button" type="button" class="ml-4 bg-[#B54242] hover:bg-[#A12B2B] px-4 py-2 rounded-lg text-white">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabs in Column Layout -->
<div class="flex justify-center space-x-4 mt-8">
    <button class="text-[#DAD7CD] hover:text-[#A3B18A]" id="b-about">About</button>
    <button class="text-[#DAD7CD] hover:text-[#A3B18A]" id="b-liked">Liked</button>
    <button class="text-[#DAD7CD] hover:text-[#A3B18A]" id="b-saved">Saved</button>
</div>

<!-- Tabs Content Sections -->
<div class="mt-4">
    <div id="about-section" class="section active">
        <p class="text-[#DAD7CD]">About content goes here...</p>
    </div>

    <div id="liked-section" class="section hidden">
        <p class="text-[#DAD7CD]">Liked content goes here...</p>
    </div>

    <div id="saved-section" class="section hidden">
        <p class="text-[#DAD7CD]">Saved content goes here...</p>
    </div>
</div>

    </div>

</div>

<script>
    document.getElementById('settings-button').addEventListener('click', function() {
        document.getElementById('edit-profile-modal').classList.toggle('hidden');
    });

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('edit-profile-modal').classList.add('hidden');
    });

        // JavaScript for section toggling
        document.getElementById('b-profile').addEventListener('click', function() {
        showSection('edit-profile');
    });
    document.getElementById('b-account').addEventListener('click', function() {
        showSection('account');
    });
    document.getElementById('b-preference').addEventListener('click', function() {
        showSection('preference');
    });

    function showSection(sectionId) {
        // Hide all sections
        document.querySelectorAll('.section').forEach(function(section) {
            section.classList.add('hidden');
        });

        // Show the selected section
        document.getElementById(sectionId).classList.remove('hidden');
    }

     // JavaScript for section toggling
     document.getElementById('b-about').addEventListener('click', function() {
        showSection('about-section');
    });
    document.getElementById('b-liked').addEventListener('click', function() {
        showSection('liked-section');
    });
    document.getElementById('b-saved').addEventListener('click', function() {
        showSection('saved-section');
    });

    function showSection(sectionId) {
        // Hide all sections
        document.querySelectorAll('.section').forEach(function(section) {
            section.classList.add('hidden');
        });

        // Show the selected section
        document.getElementById(sectionId).classList.remove('hidden');
    }
</script>
@endsection
