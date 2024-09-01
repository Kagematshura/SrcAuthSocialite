<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#344E41]"> <!-- Brunswick Green for the background -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md px-6 py-12 bg-[#3A5A40] rounded-lg shadow-lg"> <!-- Hunter Green for the container -->
            <div class="text-center mb-6">
                <!-- Logo -->
                <img src="https://www.grahadhuafa.org/website/assets/images/custom/logo_gdi_long.png" alt="Logo" class="mx-auto mb-4"> <!-- Placeholder for the logo -->
                <h2 class="text-3xl font-bold text-[#DAD7CD] mb-2">Sign in to your account</h2> <!-- Timberwolf for the heading text -->
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="mt-6">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-[#DAD7CD] font-bold mb-2">Email address</label> <!-- Timberwolf for the label -->
                    <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your email" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-[#DAD7CD] font-bold mb-2">Password</label> <!-- Timberwolf for the label -->
                    <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-900 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your password" required>
                </div>

                @if ($errors->any())
                    <div class="mb-4">
                        <ul class="text-red-500 list-disc list-inside"> <!-- Error messages in Red-500 -->
                             @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                             @endforeach
                        </ul>
                    </div>
                 @endif

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="form-checkbox text-[#588157]"> <!-- Fern Green for the checkbox -->
                        <label for="remember" class="ml-2 text-[#DAD7CD]">Remember me</label> <!-- Timberwolf for the label -->
                    </div>
                    <div class="flex flex-col text-right">
                        <a href="{{route('register')}}" class="text-[#A3B18A] hover:text-[#588157]">Register</a> <!-- Sage for the link, Fern Green for hover -->
                        <a href="" class="text-[#A3B18A] hover:text-[#588157]">Forgot password?</a> <!-- Sage for the link, Fern Green for hover -->
                    </div>
                </div>

                <button type="submit" class="bg-[#588157] hover:bg-[#3A5A40] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Sign in
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="text-[#DAD7CD]">Or continue with</p> <!-- Timberwolf for the text -->
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
