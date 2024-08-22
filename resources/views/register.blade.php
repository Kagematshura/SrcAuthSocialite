<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md px-6 py-12 bg-gray-800 rounded-lg shadow-lg">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-white mb-2">Create an account</h2>
            </div>

            <form action="{{ route('register') }}" method="POST" class="mt-6">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-300 font-bold mb-2">Name</label>
                    <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your name" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-300 font-bold mb-2">Email address</label>
                    <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your email" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-300 font-bold mb-2">Password</label>
                    <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your password" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-300 font-bold mb-2">Confirm password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" placeholder="Confirm your password" required>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                    <div class="text-red-500 list-disc list-inside">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="text-red-500 list-disc list-inside">
                        {{ session('error') }}
                    </div>
                @endif

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Register
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="text-gray-400">Already have an account? <a href="{{ route('welcome') }}" class="text-blue-400 hover:text-blue-600">Sign in</a></p>
            </div>
        </div>
    </div>
</body>
</html>
