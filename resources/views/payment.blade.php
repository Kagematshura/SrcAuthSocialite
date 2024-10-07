<div class="max-w-md mx-auto bg-gray-800 shadow-lg rounded-lg p-6 text-white">
    <h2 class="text-2xl font-bold mb-6">Donate</h2>
    <form id="donation-form">
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2" for="name">Name</label>
            <input id="name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2" for="email">Email</label>
            <input id="email" type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2" for="amount">Donation Amount</label>
            <input id="amount" type="number" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" required>
        </div>
        <button type="button" id="pay-button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Donate Now
        </button>
    </form>
</div>

<!-- Midtrans Snap.js Script -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function() {
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const amount = document.getElementById('amount').value;

        fetch('/payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                name: name,
                email: email,
                amount: amount
            })
        })
        .then(response => response.json())
        .then(data => {
            window.snap.pay(data.snap_token); // Trigger the Midtrans payment pop-up
        });
    };
</script>
