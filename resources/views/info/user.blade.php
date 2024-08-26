<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Info</title>
    @vite('resources/css/app.css')
</head>
<body>
<header class="bg-gray-800 text-white py-4 text-center">
    <h1 class="text-3xl font-bold">User Information</h1>
  </header>
  <main class="max-w-4xl mx-auto p-4 md:p-6 lg:p-8">
    <section class="bg-white shadow-md rounded p-4 mb-6">
      <h2 class="text-2xl font-bold mb-2">Account Information</h2>
      <form>
        <label class="block mb-2" for="name">Name:</label>
        <input class="w-full p-2 pl-10 text-sm text-gray-700" id="name" type="text" value="John Doe">
        <label class="block mb-2" for="email">Email:</label>
        <input class="w-full p-2 pl-10 text-sm text-gray-700" id="email" type="email" value="johndoe@example.com">
        <label class="block mb-2" for="password">Password:</label>
        <input class="w-full p-2 pl-10 text-sm text-gray-700" id="password" type="password" placeholder="Enter new password">
        <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded" type="submit">Update Account Information</button>
      </form>
    </section>
    <section class="bg-white shadow-md rounded p-4 mb-6">
      <h2 class="text-2xl font-bold mb-2">Address Information</h2>
      <form>
        <label class="block mb-2" for="street">Street:</label>
        <input class="w-full p-2 pl-10 text-sm text-gray-700" id="street" type="text" value="123 Main St">
        <label class="block mb-2" for="city">City:</label>
        <input class="w-full p-2 pl-10 text-sm text-gray-700" id="city" type="text" value="Anytown">
        <label class="block mb-2" for="state">State:</label>
        <input class="w-full p-2 pl-10 text-sm text-gray-700" id="state" type="text" value="CA">
        <label class="block mb-2" for="zip">Zip:</label>
        <input class="w-full p-2 pl-10 text-sm text-gray-700" id="zip" type="text" value="12345">
        <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded" type="submit">Update Address Information</button>
      </form>
    </section>
    <section class="bg-white shadow-md rounded p-4 mb-6">
        <h2 class="text-2xl font-bold mb-2">Other</h2>
        <a href="/inbox" class="mb-1">Checkin' your mailbox?</a>
        <a href="/balance" class="mb-1">Lookin' fer yer balance?</a>
    </section>
  </main>
</body>
</html>