<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Inbox</title>
    @vite('resources/css/app.css')
</head>
<body>
<header class="bg-gray-800 text-white py-4 text-center">
    <h1 class="text-3xl font-bold">User Inbox</h1>
  </header>
  <main class="max-w-4xl mx-auto p-4 md:p-6 lg:p-8">
    <section class="bg-white shadow-md rounded p-4 mb-6">
      <h2 class="text-2xl font-bold mb-2">Messages</h2>
      <ul class="list-none mb-4">
        <li class="bg-gray-100 p-4 mb-2 rounded">
          <h3 class="text-lg font-bold">New Donation Receipt</h3>
          <p class="text-gray-600">You have received a new donation receipt from Charity Name.</p>
          <a class="text-orange-500 hover:text-orange-700" href="#">View Receipt</a>
        </li>
        <li class="bg-gray-100 p-4 mb-2 rounded">
          <h3 class="text-lg font-bold">Update on Your Donation</h3>
          <p class="text-gray-600">We wanted to update you on the impact of your recent donation to Charity Name.</p>
          <a class="text-orange-500 hover:text-orange-700" href="#">Read Update</a>
        </li>
        <li class="bg-gray-100 p-4 mb-2 rounded">
          <h3 class="text-lg font-bold">Charity News and Updates</h3>
          <p class="text-gray-600">Stay up-to-date on the latest news and updates from Charity Name.</p>
          <a class="text-orange-500 hover:text-orange-700" href="#">Read News</a>
        </li>
      </ul>
      <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded" type="button">Mark All as Read</button>
    </section>
  </main>
</body>
</html>