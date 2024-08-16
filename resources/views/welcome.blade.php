<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-900">
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md px-6 py-12 bg-gray-800 rounded-lg shadow-lg">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-white mb-2">Sign in to your account</h2>
            </div>


            <!-- Laravel Login Form -->
            <form method="POST" action="{{ route('login') }}" class="mt-6">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-300 font-bold mb-2">Email address</label>
                    <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your email" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-300 font-bold mb-2">Password</label>
                    <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your password" required>
                </div>

                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="text-red-500 list-disc list-inside">
                             @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                             @endforeach
                        </ul>
                    </div>
                 @endif

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="form-checkbox text-blue-400">
                        <label for="remember" class="ml-2 text-gray-300">Remember me</label>
                    </div>
                    <div class="flex flex-col text-right">
                        <a href="{{route('register')}}" class="text-blue-400 hover:text-blue-600">Register</a>
                        {{-- {{ route('password.request') }} --}}
                        <a href="" class="text-blue-400 hover:text-blue-600">Forgot password?</a>
                    </div>
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Sign in
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="text-gray-400">Or continue with</p>
            </div>

            <div class="flex items-center justify-center mt-4">
                <a href="{{ route('google-auth') }}" class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-16 rounded-lg shadow-md mr-2">
                    <span class="flex items-center justify-center">
                        <img src="https://cdn-icons-png.flaticon.com/128/300/300221.png" alt="google.logo" class="w-6 h-6 mr-2">
                        Google
                    </span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
