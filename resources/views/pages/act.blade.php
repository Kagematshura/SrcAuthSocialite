<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity</title>
    @vite('resources/css/app.css')
</head>
<body>
<header class="bg-gray-800 text-white py-4 text-center">
    <h1 class="text-3xl font-bold">Activity?</h1>
  </header>
  <main class="max-w-4xl mx-auto p-4 md:p-6 lg:p-8">
    <section class="bg-white shadow-md rounded p-4 mb-6">
      <h2 class="text-2xl font-bold mb-2">Activity</h2>
      <img src="{{ asset('img/illust.avif') }}" alt="illust" class="md:relative h-40 mb-3 w-auto rounded-xl">
      <p class="text-gray-600 mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet nulla auctor, vestibulum magna sed, convallis ex. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
      <p class="text-gray-600 mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet nulla auctor, vestibulum magna sed, convallis ex. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
      <p class="text-gray-600 mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet nulla auctor, vestibulum magna sed, convallis ex. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
    </section>
    <section class="bg-white shadow-md rounded p-4 mb-6">
      <h2 class="text-2xl font-bold mb-2">Activity Lainnya</h2>
      <ul class="list-none mb-0">
        <li class="mb-2">
          <a class="text-blue-600 hover:text-blue-900" href="#">Activity</a>
        </li>
        <li class="mb-2">
          <a class="text-blue-600 hover:text-blue-900" href="#">Activity</a>
        </li>
        <li class="mb-2">
          <a class="text-blue-600 hover:text-blue-900" href="#">Activity</a>
        </li>
      </ul>
    </section>
  </main>
</body>
</html>