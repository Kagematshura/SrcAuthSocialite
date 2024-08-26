<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balance</title>
    @vite('resources/css/app.css')
</head>
<body>
  <header class="bg-gray-800 text-white py-4 text-center">
    <h1 class="text-3xl font-bold">Balance</h1>
  </header>
  <main class="max-w-4xl mx-auto p-4 md:p-6 lg:p-8">
    <section class="bg-white shadow-md rounded p-4 mb-6">
      <h2 class="text-2xl font-bold mb-2">Current Balance</h2>
      <p class="text-4xl font-bold">$10,000.00</p>
      <p class="text-gray-600">Last updated: March 12, 2023</p>
    </section>
    <a href="/balance">Refresh the page?</a>
  </main>
</body>
</html>