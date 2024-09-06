<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#344E41]"> <!-- Brunswick Green for the background -->
    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md px-6 py-12 bg-[#3A5A40] rounded-lg shadow-lg"> <!-- Hunter Green for the container -->
            <div class="text-center mb-6">
                <!-- Logo -->
                <img src="https://www.grahadhuafa.org/website/assets/images/custom/logo_gdi_long.png" alt="Logo" class="mx-auto mb-4"> <!-- Placeholder for the logo -->
            </div>
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold text-[#DAD7CD] mb-2">Create an account</h2> <!-- Timberwolf for the heading text -->
            </div>

            <form action="{{ route('register') }}" method="POST" class="mt-6">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-[#DAD7CD] font-bold mb-2">Name</label> <!-- Timberwolf for the label -->
                    <input type="text" id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-200 bg-[#DAD7CD] leading-tight focus:outline-none focus:border-[#588157] focus:ring-[#588157] focus:ring-2" placeholder="Enter your name" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-[#DAD7CD] font-bold mb-2">Email address</label> <!-- Timberwolf for the label -->
                    <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-200 bg-[#DAD7CD] leading-tight focus:outline-none focus:border-[#588157] focus:ring-[#588157] focus:ring-2" placeholder="Enter your email" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-[#DAD7CD] font-bold mb-2">Password</label> <!-- Timberwolf for the label -->
                    <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-200 bg-[#DAD7CD] leading-tight focus:outline-none focus:border-[#588157] focus:ring-[#588157] focus:ring-2" placeholder="Enter your password" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-[#DAD7CD] font-bold mb-2">Confirm password</label> <!-- Timberwolf for the label -->
                    <input type="password" id="password_confirmation" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-200 bg-[#DAD7CD] leading-tight focus:outline-none focus:border-[#588157] focus:ring-[#588157] focus:ring-2" placeholder="Confirm your password" required>
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

                <button type="submit" class="bg-[#588157] hover:bg-[#3A5A40] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Register
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="text-[#DAD7CD]">Already have an account? <a href="{{ route('welcome') }}" class="text-[#A3B18A] hover:text-[#588157]">Sign in</a></p> <!-- Sage for the link, Fern Green for hover -->
            </div>
        </div>
    </div>
</body>
</html>
