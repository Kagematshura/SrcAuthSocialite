<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Query to get total donations per month
        $monthlyDonations = DB::table('transactions')
            ->select(DB::raw('SUM(amount) as total'), DB::raw('MONTH(paid_at) as month'))
            ->where('transaction_status', 'success')  // Only successful transactions
            ->groupBy(DB::raw('MONTH(paid_at)'))
            ->orderBy(DB::raw('MONTH(paid_at)'))
            ->pluck('total', 'month');

        // Fill an array with 12 months, defaulting to 0 if no data for that month
        $data = array_fill(1, 12, 0);
        foreach ($monthlyDonations as $month => $total) {
            $data[$month] = $total;
        }

        return view('dashboard', compact('data'));  // Pass data to the view
    }

    public function pie()
    {
    // Get the sum of contributions per category
    $contributions = Transaction::select('category', \DB::raw('SUM(amount) as total_amount'))
        ->groupBy('category')
        ->get();

    return view('dashboard', [
        'contributions' => $contributions,
        ]);
    }

    //store function
}
