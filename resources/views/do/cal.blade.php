<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    @vite('resources/css/app.css')
</head>
<body>
<header class="bg-gray-800 text-white py-4 text-center">
    <h1 class="text-3xl font-bold">Charity Schedule Calendar</h1>
  </header>
  <main class="max-w-4xl mx-auto p-4 md:p-6 lg:p-8">
    <section class="bg-white shadow-md rounded p-4 mb-6">
      <h2 class="text-2xl font-bold mb-2">July 2024</h2>
      <div class="grid grid-cols-7 gap-4">
        <div class="text-gray-600 text-sm">Sun</div>
        <div class="text-gray-600 text-sm">Mon</div>
        <div class="text-gray-600 text-sm">Tue</div>
        <div class="text-gray-600 text-sm">Wed</div>
        <div class="text-gray-600 text-sm">Thu</div>
        <div class="text-gray-600 text-sm">Fri</div>
        <div class="text-gray-600 text-sm">Sat</div>
        <div class="bg-gray-200 h-12 w-full rounded p-2">1</div>
        <div class="bg-orange-100 h-12 w-full rounded p-2">5</div>
        <div class="bg-orange-100 h-12 w-full rounded p-2">9</div>
        <div class="bg-orange-100 h-12 w-full rounded p-2">13</div>
        <div class="bg-orange-100 h-12 w-full rounded p-2">17</div>
        <div class="bg-orange-100 h-12 w-full rounded p-2">21</div>
        <div class="bg-orange-100 h-12 w-full rounded p-2">25</div>
      </div>
    </section>
  </main>
</body>
</html>