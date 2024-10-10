<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
{
    $monthlyData = Transaction::select(
            DB::raw('SUM(gross_amount) as total'),
            DB::raw('MONTH(created_at) as month')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    $data = array_fill(0, 12, 0);  // Default array with 12 months filled with 0

    foreach ($monthlyData as $entry) {
        $data[$entry->month - 1] = $entry->total;
    }

    return view('dashboard', compact('data'));
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
