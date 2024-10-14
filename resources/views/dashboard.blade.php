@extends('layout.app')

@section('content')
@vite('resources/css/app.css')
@vite('resources/css/sidebar.css')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

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


{{-- Content --}}
<section class="home-section flex-1 p-8">
    <h1 class="my-8 text-center">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Bar Chart -->
        <div class="bg-white p-4 rounded-lg shadow-md">
            <canvas id="barChart"></canvas>
        </div>

        <!-- Pie Chart -->
        <div class="bg-white p-4 rounded-lg shadow-md">
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white p-4 rounded-lg shadow-md mt-8">
        <h2 class="text-xl font-semibold mb-4">Recent Transactions</h2>
        <div class="overflow-x-auto">
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="px-4 py-2 border">Order Id</th>
                        <th class="px-4 py-2 border">Customer Name</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border">Amount</th>
                        <th class="px-4 py-2 border">Payment Type</th>
                        <th class="px-4 py-2 border">Categories</th>
                        <th class="px-4 py-2 border">Institution</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Date</th>
                        <th class="px-4 py-2 border" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr data-transaction-id="{{ $transaction->id }}">
                            <td class="px-4 py-2 border">{{ $transaction->order_id }}</td>
                            <td class="px-4 py-2 border">{{ $transaction->customer_first_name }}</td>
                            <td class="px-4 py-2 border">{{ $transaction->customer_email }}</td>
                            <td class="px-4 py-2 border">{{ number_format($transaction->gross_amount, 2) }}</td>
                            <td class="px-4 py-2 border">{{ $transaction->payment_type }}</td>
                            <td class="px-4 py-2 border">{{ $transaction->division }}</td>
                            <td class="px-4 py-2 border">
                                <span class="institution-display">{{ $transaction->institution }}</span>
                                <input type="text" value="{{ $transaction->institution }}" class="institution-input hidden" />                            </td>
                            </td>

                            <td class="px-4 py-2 border">
                                @if ($transaction->status === 'success')
                                    <span class="text-green-500 font-semibold">{{ ucfirst($transaction->status) }}</span>
                                @elseif ($transaction->status === 'pending')
                                    <span class="text-yellow-500 font-semibold">{{ ucfirst($transaction->status) }}</span>
                                @else
                                    <span class="text-red-500 font-semibold">{{ ucfirst($transaction->status) }}</span>
                                @endif
                            </td>

                            <td class="px-4 py-2 border">{{ $transaction->created_at->format('Y-m-d') }}</td>
                            <td class="px-4 py-2 border">
                                <button type="button" class="edit-button bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition duration-300">Edit</button>
                            </td>
                            {{-- <td class="px-4 py-2 border">
                                <form action="{{ secure_url('/payment', $transaction->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 transition duration-300">Delete</button>
                                </form>
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center px-4 py-2 border">No transactions available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sidebar
    window.onload = function() {
    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector("#btn");

    closeBtn.addEventListener("click", function(){
        sidebar.classList.toggle("open");
        menuBtnChange();
        closeAllDropdowns();
    });

    // Bar Chart
const barChartCtx = document.getElementById('barChart').getContext('2d');
const barChartData = @json(array_values($data));

console.log(barChartData);  // Check if the data is passed correctly

const barChart = new Chart(barChartCtx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'Amount Raised',
            data: barChartData,
            backgroundColor: ['#588157', '#3A5A40', '#DAD7CD', '#D9EAD3', '#2C4A37', '#588157', '#3A5A40', '#DAD7CD', '#D9EAD3', '#2C4A37', '#588157', '#3A5A40'],
            borderColor: ['#344E41'],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

   // Pie Chart
   const pieChartCtx = document.getElementById('pieChart').getContext('2d');

        const divisionLabels = @json($divisionData->pluck('division'));
        const divisionAmounts = @json($divisionData->pluck('total'));

        const pieChart = new Chart(pieChartCtx, {
            type: 'pie',
            data: {
                labels: divisionLabels,  // Dynamic labels
                datasets: [{
                    label: 'Amount per Division',
                    data: divisionAmounts,
                    backgroundColor: ['#588157', '#3A5A40', '#DAD7CD'],
                    borderColor: ['#2C4A37'],
                    borderWidth: 1
                }]
            }
        });
    }

    // Dropdown toggle
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

// Edit institution
document.querySelectorAll('.edit-button').forEach(button => {
    button.addEventListener('click', function() {
        const row = this.closest('tr');
        const input = row.querySelector('.institution-input');
        const display = row.querySelector('.institution-display');

        if (this.innerText === 'Edit') {
            input.classList.remove('hidden');
            display.classList.add('hidden');
            this.innerText = 'Save';
        } else {
            input.classList.add('hidden');
            display.classList.remove('hidden');

            display.innerText = input.value;

            this.innerText = 'Edit';

            // Send updated data via AJAX
            const formData = {
                _token: '{{ csrf_token() }}',
                institution: input.value,
            };

            const transactionId = row.getAttribute('data-transaction-id');

            fetch(`/payment/${transactionId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                console.log('Success:', data);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }
    });
});


</script>
@endsection
