<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use App\Models\Transaction;
use Midtrans\Config;

class PaymentController extends Controller
{
    // Initiates the payment
    public function processPayment(Request $request)
{
    try {
        // Step 1: Log request data for debugging
        \Log::info('Request Data:', $request->all());

        // Step 2: Set Midtrans config
        Config::$serverKey = 'SB-Mid-server-FoY3AmpHK8Hdgc4slGKgKJkL';
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Step 3: Prepare the transaction details
        $transaction_details = [
            'order_id' => uniqid(),
            'gross_amount' => $request->amount,
        ];

        // Step 4: Prepare customer details
        $customer_details = [
            'first_name' => $request->first_name,
            'email' => $request->email,
        ];

        $params = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
        ];

        \Log::info('Midtrans Params:', $params); // Log the params

        // Step 5: Request Snap Token
        $snapToken = Snap::getSnapToken($params);

        // Step 6: Store transaction in the database
        $transaction = Transaction::create([
            'order_id' => $params['transaction_details']['order_id'],
            'gross_amount' => $params['transaction_details']['gross_amount'],
            'customer_first_name' => $params['customer_details']['first_name'],
            'customer_email' => $params['customer_details']['email'],
            'payment_type' => 'pending',
            'status' => 'pending',
        ]);

        // Log the creation of the transaction
        \Log::info('Transaction created:', ['order_id' => $transaction->order_id]);

        // Step 7: Return the snap token
        return response()->json(['snapToken' => $snapToken]);

    } catch (\Exception $e) {
        // Log the error and return it in response
        \Log::error('Payment Process Error:', ['error' => $e->getMessage()]);

        return response()->json(['error' => 'Failed to process payment', 'details' => $e->getMessage()], 500);
    }
}

    // Handle payment notification
    public function handleMidtransNotification(Request $request)
{
    // Get the transaction ID from the notification
    $transaction_id = $request->input('order_id');

    // Find the corresponding transaction in your database
    $transaction = Transaction::where('order_id', $transaction_id)->first();

    if ($transaction) {
        // Update the payment type and transaction status based on the notification
        $transaction->payment_type = $request->input('payment_type');
        $transaction->status = $request->input('status_code') == 200 ? 'success' : 'failed';

        // Save the updated transaction
        $transaction->save();
    }

    return response()->json(['message' => 'Midtrans notification received and processed']);
}

    public function viewTransactions()
{
    $transactions = Transaction::all();

    return view('payment', compact('transactions'));
}
public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('payment.view');
    }
}
