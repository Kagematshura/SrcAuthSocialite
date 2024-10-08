<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    for ($i = 1; $i <= 12; $i++) {
        $date = Carbon::now()->subMonths($i);  // Create a new instance for each month
        Transaction::create([
            'user_id' => 1,  // Assume a test user with ID 1
            'amount' => rand(100, 1000),  // Random amounts for testing
            'transaction_status' => 'success',
            'midtrans_transaction_id' => 'TRX-' . uniqid(),
            'paid_at' => $date, // Use the newly created date
            'created_at' => $date, // Use the same date
            'updated_at' => $date, // Use the same date
        ]);
    }
}
}
