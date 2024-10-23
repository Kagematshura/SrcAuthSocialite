<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Change to true in production
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function create(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'amount' => 'required|numeric|min:1',
            'division' => 'required|string|max:255',
        ]);

        // Create transaction data
        $transactionData = [
            'transaction_details' => [
                'order_id' => uniqid(),
                'gross_amount' => $request->amount,
            ],
            'customer_details' => [
                'first_name' => $request->first_name,
                'email' => $request->email,
            ],
        ];

        // Create Snap token
        try {
            $snapToken = Snap::getSnapToken($transactionData);
            // Store transaction details in the database
            $this->storeTransaction($transactionData, $request->division, $request->first_name, $request->email);
            return response()->json(['snapToken' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate Snap token: ' . $e->getMessage()], 500);
        }
    }

    private function storeTransaction($transactionData, $division, $firstName, $email)
    {
        $transaction = new Transaction();
        $transaction->order_id = $transactionData['transaction_details']['order_id'];
        $transaction->gross_amount = $transactionData['transaction_details']['gross_amount'];
        $transaction->customer_first_name = $firstName;
        $transaction->customer_email = $email;
        $transaction->division = $division;
        $transaction->status = 'pending'; // Initial status
        $transaction->payment_type = 'pending'; // Initial payment type
        $transaction->save();
    }

    public function handleMidtransNotification(Request $request)
    {
        $transaction_id = $request->input('order_id');
        $transaction = Transaction::where('order_id', $transaction_id)->first();

        if ($transaction) {
            // Update transaction status based on notification data
            $transaction->payment_type = $request->input('payment_type');
            $transaction->status = $request->input('status_code') == '200' ? 'success' : 'failed';
            $transaction->save();
        }

        return response()->json(['message' => 'Notification processed']);
    }
}
