<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="bg-gray-800 flex items-center justify-center min-h-screen">

    <div class="bg-gray-200 p-8 rounded-lg shadow-2xl w-96">
        <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Form</h1>
        <form id="createForm" action="{{ url('/dashboard', @$users->id) }}" method="POST" class="space-y-6">
            @csrf
            @if (!empty(@$users))
                @method('PATCH')
            @endif
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700">Enter your name:</label>
                <input value="{{ old('name', @$users->name) }}" type="text" name="name" id="name" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Your name is..." required>
            </div>
            <div>
                <label for="age" class="block text-sm font-semibold text-gray-700">Enter your age:</label>
                <input value="{{ old('age', @$users->age) }}" type="number" name="age" id="age" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Your age currently..." required>
            </div>
            <div>
                <label for="address" class="block text-sm font-semibold text-gray-700">Enter your address:</label>
                <input value="{{ old('address', @$users->address) }}" type="text" name="address" id="address" class="mt-1 p-3 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Your address..." required>
            </div>
            <div class="text-center">
                <button type="submit" class="w-full bg-indigo-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-indigo-600 transition duration-300 ease-in-out transform hover:scale-105">
                    Submit
                </button>
            </div>
        </form>
    </div>

</div>


<script>
    document.getElementById('createForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting immediately
        confirmSubmit().then((confirmed) => {
            if (confirmed) {
                // Submit the form if the user confirmed
                event.target.submit();
            }
        });
    });

    function confirmSubmit() {
        var name = document.getElementById('name').value;
        var age = document.getElementById('age').value;
        var address = document.getElementById('address').value;

        var confirmationMessage = `Name: ${name}<br>Age: ${age}<br>Address: ${address}<br><br>Do you want to submit this form?`;

        return Swal.fire({
            title: 'Are you sure?',
            html: confirmationMessage, // Use 'html' instead of 'text' to render HTML
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            return result.isConfirmed;
        });
    }
</script>
</body>
</html>