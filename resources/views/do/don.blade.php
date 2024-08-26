<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation : Doin'</title>
    @vite('resources/css/app.css')
</head>
<body>
  <header class="bg-gray-800 text-white py-4 text-center">
    <h1 class="text-3xl font-bold">Donate</h1>
  </header>
  <main class="max-w-4xl mx-auto p-4 md:p-6 lg:p-8">
    <section class="bg-white shadow-md rounded p-4 mb-6">
      <h2 class="text-2xl font-bold mb-2">Make a Donation</h2>
      <form>
        <label class="block mb-2" for="amount">Amount:</label>
        <input class="w-full p-2 pl-10 text-sm text-gray-700" id="amount" type="number" placeholder="Enter amount">
        <label class="block mb-2" for="payment-method">Payment Method:</label>
        <select class="w-full p-2 pl-10 text-sm text-gray-700" id="payment-method">
          <option value="credit-card">Credit Card</option>
          <option value="paypal">PayPal</option>
          <option value="bank-transfer">Bank Transfer</option>
        </select>
        <button class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded" type="submit">Donate</button>
      </form>
    </section>
  </main>
</body>
</html>