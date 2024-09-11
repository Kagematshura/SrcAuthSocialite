<!-- resources/views/profile/show.blade.php -->
@extends('layout.profile')

@section('content')
<div class="bg-[#344E41] text-white min-h-screen flex items-center justify-center" x-data="{ open: false }"> <!-- Alpine.js data object -->
    <div class="w-full max-w-xl">
        <!-- Profile Section -->
        <div class="flex flex-col items-center">
            <img src="{{ auth()->user()->profile_picture_url ?? 'https://i.pinimg.com/236x/ad/73/1c/ad731cd0da0641bb16090f25778ef0fd.jpg' }}"
            style="width: 160px; height: 160px;" class="rounded-full object-cover" alt="Profile Picture">
            <h1 class="text-2xl font-semibold mt-4 text-[#DAD7CD]">{{ auth()->user()->name ?? 'Guest' }}</h1>
            <p class="text-[#A3B18A]">{{ Auth::user()->email }}</p>
            <div class="flex space-x-4 mt-2 text-[#DAD7CD]">
                <span>0 talent</span>
                <span>•</span>
                <span>0 trust</span>
                <span>•</span>
                <span>0 life</span>
            </div>
            <div class="flex space-x-4 mt-4">
                <button @click="open = !open" class="bg-[#3A5A40] hover:bg-[#588157] px-4 py-2 rounded-lg flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-white">Settings</span>
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
        <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-[#2E3A24] p-6 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-2xl font-semibold text-[#DAD7CD]">Edit Profile</h2>
                <form action="{{ route('profile.update') }}" method="POST" class="mt-4">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-[#DAD7CD]">Name</label>
                        <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" class="mt-1 p-2 w-full bg-[#1F2D14] text-white rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-[#DAD7CD]">Email</label>
                        <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" class="mt-1 p-2 w-full bg-[#1F2D14] text-white rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="profile_picture" class="block text-[#DAD7CD]">Profile Picture URL</label>
                        <input type="text" id="profile_picture" name="profile_picture" value="{{ auth()->user()->profile_picture_url }}" class="mt-1 p-2 w-full bg-[#1F2D14] text-white rounded-lg">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#3A5A40] hover:bg-[#588157] px-4 py-2 rounded-lg text-white">Save</button>
                        <button @click="open = false" type="button" class="ml-4 bg-[#B54242] hover:bg-[#A12B2B] px-4 py-2 rounded-lg text-white">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabs -->
        <div class="flex justify-center space-x-4 mt-8">
            <button class="text-[#DAD7CD] hover:text-[#A3B18A]">About</button>
            <button class="text-[#DAD7CD] hover:text-[#A3B18A]">Liked</button>
            <button class="text-[#DAD7CD] hover:text-[#A3B18A]">Followed</button>
        </div>
    </div>
</div>
@endsection
