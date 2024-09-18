<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>
    @vite('resources/css/app.css')
    @vite('resources/css/sidebar.css')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.tiny.cloud/1/t4d8f3p0fnqaze0wj0rfr1kxftjdeulfrkzscrmzj1eokgrc/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body class="">

    <div class="">
        @yield('content')
    </div>

</body>
</html>
