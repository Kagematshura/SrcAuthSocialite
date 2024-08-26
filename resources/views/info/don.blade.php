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
    <h1 class="text-3xl font-bold">Donation Information</h1>
  </header>
  <main class="max-w-4xl mx-auto p-4 md:p-6 lg:p-8">
    <section class="bg-white shadow-md rounded p-4 mb-6">
      <h2 class="text-2xl font-bold mb-2">Your Donation History</h2>
      <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
          <tr>
            <th scope="col">Date</th>
            <th scope="col">Amount</th>
            <th scope="col">Payment Method</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>March 10, 2023</td>
            <td>$50.00</td>
            <td>Credit Card</td>
          </tr>
          <tr>
            <td>February 20, 2023</td>
            <td>$25.00</td>
            <td>PayPal</td>
          </tr>
          <tr>
            <td>January 15, 2023</td>
            <td>$100.00</td>
            <td>Bank Transfer</td>
          </tr>
        </tbody>
      </table>
    </section>
    <section class="bg-white shadow-md rounded p-4 mb-6">
      <h2 class="text-2xl font-bold mb-2">Your Total Donations</h2>
      <p class="text-4xl font-bold">$175.00</p>
      <p class="text-gray-600">Thank you for your generosity!</p>
    </section>
  </main>
</body>
</html>