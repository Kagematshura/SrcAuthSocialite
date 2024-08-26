<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    @vite('resources/css/app.css')
</head>
<body>
  <main class="max-w-4xl mx-auto p-4 md:p-6 lg:p-8">
    <section class="bg-white shadow-md rounded p-4 mb-6">
      <h2 class="text-2xl font-bold mb-2">Latest Announcements</h2>
      <ul class="list-none mb-4">
        <li class="bg-gray-100 p-4 mb-2 rounded">
          <h3 class="text-lg font-bold">New Partnership with Local Business</h3>
          <p class="text-gray-600">We are excited to announce a new partnership with Local Business to support our mission.</p>
          <a class="text-orange-500 hover:text-orange-700" href="#">Learn More</a>
        </li>
        <li class="bg-gray-100 p-4 mb-2 rounded">
          <h3 class="text-lg font-bold">Upcoming Charity Event</h3>
          <p class="text-gray-600">Join us on March 12th for our annual charity gala, featuring live music, auctions, and more!</p>
          <a class="text-orange-500 hover:text-orange-700" href="#">Get Tickets</a>
        </li>
        <li class="bg-gray-100 p-4 mb-2 rounded">
          <h3 class="text-lg font-bold">New Volunteer Opportunities</h3>
          <p class="text-gray-600">We have new volunteer opportunities available, including event planning and fundraising.</p>
          <a class="text-orange-500 hover:text-orange-700" href="#">Sign Up</a>
        </li>
      </ul>
      <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded" type="button">View All Announcements</button>
    </section>
  </main>
</body>
</html>