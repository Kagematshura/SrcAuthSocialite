<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .transition-margin {
            transition: margin-left 0.5s;
        }
    </style>
</head>
<body class="bg-gray-600">
<button class="absolute text-white text-4xl top-5 left-4 cursor-pointer xl:block" onclick="toggleSidebar()">
    <i class="bi bi-filter-left px-2 bg-gray-800 rounded-md"></i>
</button>

<div class="sidebar fixed top-0 bottom-0 xl:left-0 p-2 w-[300px] overflow-y-auto text-center bg-gray-800 -translate-x-full transition-all duration-300 ease-in-out" id="sidebar">
    <div class="text-gray-100 text-xl">
        <div class="p-2.5 mt-1 flex items-center">
            <i class="bi bi-app-indicator px-2 py-1 rounded-md bg-orange-600"></i>
            <h1 class="font-bold text-gray-200 text-[15px] ml-3">Dashboard</h1>
            <i class="bi bi-x cursor-pointer ml-28 lg:hidden xl:block" onclick="toggleSidebar()"></i>
        </div>
        <div class="my-2 bg-gray-600 h-px"></div>
    </div>
    
    <div class="p-2.5 flex items-center rounded-md px-4 duration-300 cursor-pointer bg-gray-700 text-white">
        <i class="bi bi-search text-sm"></i>
        <input type="text" placeholder="Search" class="text-[15px] ml-4 w-full bg-transparent focus:outline-none">
    </div>
    
    <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-orange-600 text-white">
        <i class="bi bi-house-door-fill"></i>
        <span class="text-[15px] ml-4 text-gray-200 font-bold">Home</span>
    </div>
    
    <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-orange-600 text-white">
        <i class="bi bi-bookmark-fill"></i>
        <span class="text-[15px] ml-4 text-gray-200 font-bold">Bookmark</span>
    </div>
    
    <div class="my-4 bg-gray-600 h-px"></div>
    
    <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-orange-600 text-white" onclick="dropdown()">
        <i class="bi bi-chat-left-text-fill"></i>
        <div class="flex justify-between w-full items-center">
            <span class="text-[15px] ml-4 text-gray-200 font-bold">Chatbox</span>
            <span class="text-sm rotate-180 transition-transform duration-200" id="arrow">
                <i class="bi bi-chevron-down"></i>
            </span>
        </div>
    </div>
    
    <div class="text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold hidden transition-all duration-300" id="submenu">
        <h1 class="cursor-pointer p-2 hover:bg-orange-600 rounded-md mt-1">Social</h1>
        <h1 class="cursor-pointer p-2 hover:bg-orange-600 rounded-md mt-1">Personal</h1>
        <h1 class="cursor-pointer p-2 hover:bg-orange-600 rounded-md mt-1">Friends</h1>
    </div>
    
    <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-orange-600 text-white">
        <i class="bi bi-box-arrow-in-right"></i>
        <span class="text-[15px] ml-4 text-gray-200 font-bold">Logout</span>
    </div>
</div>

    <<main class="transition-margin ml-64 mr-2" id="main-content">
    <!-- Uncomment the following section if needed -->
    <!-- 
    <div class="bg-gray-300 shadow-md rounded my-6 overflow-x-auto">
        <h1 class="text-black text-4xl p-4">Main Content</h1>
        <img src="{{ asset('img/illust.avif') }}" alt="illust" class="rounded-xl">
        <p class="text-lg text-black p-3">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse odit distinctio tenetur, doloremque eveniet, corporis quaerat quos fugiat rem delectus repudiandae quis reprehenderit dolorum impedit nulla sint. Dolorem, modi aperiam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus nemo incidunt voluptas ullam laudantium nihil est, aut natus sint exercitationem repudiandae nobis distinctio error voluptatum inventore excepturi cumque deleniti dolor?
        </p>
    </div> 
    -->
    <div class="bg-gray-300 shadow-md rounded my-6 overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-3 px-6 bg-gray-800 text-white font-semibold text-sm uppercase text-left">No</th>
                    <th class="py-3 px-6 bg-gray-800 text-white font-semibold text-sm uppercase text-left">Name</th>
                    <th class="py-3 px-6 bg-gray-800 text-white font-semibold text-sm uppercase text-left">Age</th>
                    <th class="py-3 px-6 bg-gray-800 text-white font-semibold text-sm uppercase text-left">Address</th>
                    <th class="py-3 px-6 bg-gray-800 text-white font-semibold text-sm uppercase text-left" colspan="2">Action</th>
                </tr>
            </thead>
            @foreach ($users as $row)
            <tbody class="text-gray-700">
                <tr>
                    <td class="py-3 px-6 border-b border-gray-200">{{isset($i) ? ++$i : $i = 1}}</td>
                    <td class="py-3 px-6 border-b border-gray-200">{{$row->name}}</td>
                    <td class="py-3 px-6 border-b border-gray-200">{{$row->age}}</td>
                    <td class="py-3 px-6 border-b border-gray-200">{{$row->address}}</td>
                    <td class="py-3 px-6 border-b border-gray-200">
                        <a class="p-2 bg-slate-400 hover:bg-slate-600 text-white rounded-md" href="{{url('/dashboard/edit/'. $row->id)}}">Edit</a>
                    </td>
                    <td class="py-3 px-6 border-b border-gray-200">
                        <form id="deleteForm-{{ $row->id }}" action="{{ url('/dashboard', $row->id) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="button" class="p-2 bg-slate-400 hover:bg-slate-600 text-white rounded-md" onclick="confirmDelete({{ $row->id }});">Delete</button>
                        </form>
                    </td>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
    <div class="bg-gray-300 shadow-md rounded my-6 p-3 overflow-x-auto">
        <form method="GET" action="{{ url('/dashboard') }}" class="flex items-center">
            <!-- Search Bar -->
            <input 
                type="text" 
                name="search" 
                placeholder="Search by name..." 
                value="{{ request('search') }}" 
                class="px-3 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mr-2"
            >
            
            <!-- Age Range Filter -->
            <select name="age_range" class="px-3 py-2 border border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 mr-2">
                <option value="">Select Age Range</option>
                <option value="18-25" {{ request('age_range') == '18-25' ? 'selected' : '' }}>18-25</option>
                <option value="26-35" {{ request('age_range') == '26-35' ? 'selected' : '' }}>26-35</option>
                <option value="36-45" {{ request('age_range') == '36-45' ? 'selected' : '' }}>36-45</option>
                <option value="46-60" {{ request('age_range') == '46-60' ? 'selected' : '' }}>46-60</option>
                <option value="60+" {{ request('age_range') == '60+' ? 'selected' : '' }}>60+</option>
            </select>

            <!-- Submit Button -->
            <button type="submit" class="p-3 bg-slate-400 hover:bg-slate-600 text-white rounded-lg">Filter</button>
            <!-- Refresh Filters Button -->
            <a href="{{ url('/dashboard') }}" class="p-3 bg-red-400 hover:bg-red-600 text-white rounded-lg">Refresh Filters</a>      
        </form>
    </div>
    <div class="bg-gray-300 shadow-md rounded my-6 p-3 overflow-x-auto">
        <a class="p-3 bg-slate-400 hover:bg-slate-600 text-white rounded-lg ml-4" href="{{url('/dashboard/create')}}">Create Data</a>
    </div>
</main>


    <script type="text/javascript">
        function dropdown() {
            document.querySelector("#submenu").classList.toggle("hidden");
            document.querySelector("#arrow").classList.toggle("rotate-0");
        }

        function toggleSidebar() {
            const sidebar = document.querySelector("#sidebar");
            const mainContent = document.querySelector("#main-content");
            sidebar.classList.toggle("-translate-x-full");
            mainContent.classList.toggle("ml-80");
        }

        function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Your data will be deleted forever!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm-' + id).submit();
            }
        });
        }
    </script>
</body>
</html>