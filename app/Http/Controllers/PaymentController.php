<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;

class PaymentController extends Controller
{
    // Initiates the payment
    public function initiatePayment(Request $request)
    {
        // Transaction details
        $transactionDetails = [
            'order_id' => uniqid(),
            'gross_amount' => $request->amount, // Donation amount
        ];

        // Customer details
        $customerDetails = [
            'first_name' => $request->name,
            'email' => $request->email,
        ];

        // Full transaction details
        $transaction = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
        ];

        // Get Snap token for Midtrans pop-up
        $snapToken = Snap::getSnapToken($transaction);

        // Return the token as JSON response
        return response()->json(['snap_token' => $snapToken]);
    }

    // Handle payment notification
    public function handleNotification(Request $request)
    {
        // Logic to handle notifications from Midtrans (e.g., transaction status updates)
    }
}
