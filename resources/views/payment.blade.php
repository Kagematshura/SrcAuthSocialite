@extends('layout.app')

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="w-full max-w-md mx-auto bg-white shadow-lg rounded-lg p-8 mt-10">
    <h2 class="text-3xl font-bold text-gray-800 text-center mb-6">Payment Form</h2>

    <form id="payment-form">
        @csrf
        <div class="mb-4">
            <label for="division" class="block text-sm font-medium text-gray-700">Select Payment Division</label>
            <select id="division" name="division" required>
                <option value="Budaya">Budaya</option>
                <option value="Cinta">Cinta</option>
                <option value="Senyum">Senyum</option>
            </select>
        </div>

        <div class="mb-6">
            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" name="first_name" id="first_name" required>
        </div>

        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="mb-6">
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount (IDR)</label>
            <input type="number" name="amount" id="amount" required>
        </div>

        <button type="button" id="pay-button" class="bg-blue-500 text-white px-4 py-2 rounded">Pay with Snap</button>
    </form>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        var division = document.getElementById('division').value;
        var firstName = document.getElementById('first_name').value;
        var email = document.getElementById('email').value;
        var amount = document.getElementById('amount').value;

        fetch('/payment/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ first_name: firstName, email: email, amount: amount, division: division })
        })
        .then(response => response.json())
        .then(data => {
            if (data.snapToken) {
                snap.pay(data.snapToken, {
                    onSuccess: function(result) {
                        // Handle successful payment response
                        alert('Payment successful!');
                        console.log(result);
                    },
                    onPending: function(result) {
                        // Handle pending payment response
                        alert('Payment is pending.');
                        console.log(result);
                    },
                    onError: function(result) {
                        // Handle error response
                        alert('Payment failed.');
                        console.log(result);
                    }
                });
            } else {
                alert('Failed to generate Snap token.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
@endsection
