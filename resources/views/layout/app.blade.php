<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.tiny.cloud/1/t4d8f3p0fnqaze0wj0rfr1kxftjdeulfrkzscrmzj1eokgrc/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Favicons -->
    @php
        $favicon = App\Models\Favicon::latest()->first();
    @endphp
    @if($favicon)
        <link id="dynamic-favicon" rel="icon" type="image/png" href="{{ asset('storage/' . $favicon->favicon_path) }}">
    @else
        <link id="dynamic-favicon" rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    @endif

</head>
<body>

    <div class="">
        @yield('content')
    </div>

</body>
</html>
