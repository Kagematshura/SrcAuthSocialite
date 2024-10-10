@extends('layout.app')

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="w-full max-w-md mx-auto bg-white shadow-lg rounded-lg p-8 mt-10">
    <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Payment Form</h2>

    <form id="payment-form" method="POST" action="{{ secure_url('/payment/store') }}">
        @csrf
        <div class="mb-6">
            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
            <input type="text" name="first_name" id="first_name" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:ring focus:ring-blue-200 focus:border-blue-400 transition duration-300 ease-in-out" placeholder="Enter your name..." required>
        </div>

        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input type="email" name="email" id="email" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:ring focus:ring-blue-200 focus:border-blue-400 transition duration-300 ease-in-out" placeholder="Enter your email..." required>
        </div>

        <div class="mb-6">
            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Amount (IDR)</label>
            <input type="number" name="amount" id="amount" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-300 focus:ring focus:ring-blue-200 focus:border-blue-400 transition duration-300 ease-in-out" placeholder="Enter the amount..." required>
        </div>

        <button type="button" id="pay-button" class="w-full bg-blue-500 text-white px-4 py-3 rounded-lg hover:bg-blue-600 focus:ring focus:ring-blue-200 focus:outline-none transition duration-300 ease-in-out">Pay with Snap</button>
    </form>
</div>

<table class="min-w-full divide-y divide-gray-200 mt-10 bg-white shadow-md rounded-lg overflow-hidden">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" colspan="2">Action</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach($transactions as $transaction)
        <tr class="hover:bg-gray-100 transition duration-300 ease-in-out">
            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->id }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->order_id }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->gross_amount }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->customer_first_name }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->customer_email }}</td>
            <td class="px-6 py-4 whitespace-nowrap">Edit</td>
            <td class="px-6 py-4 whitespace-nowrap">
            <form action="{{ secure_url('/payment', $transaction->id) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700 transition duration-300">Delete</button>
            </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
    // Get form data
    var firstName = document.getElementById('first_name').value;
    var email = document.getElementById('email').value;
    var amount = document.getElementById('amount').value;

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/payment/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            first_name: firstName,
            email: email,
            amount: amount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.snapToken) {
            snap.pay(data.snapToken);
        } else {
            console.error('Error: Snap token is missing', data);
            alert('Snap token is missing or failed to generate. Please try again.');
        }
    })
    .catch(error => console.error('Error:', error));
});

</script>
@endsection
