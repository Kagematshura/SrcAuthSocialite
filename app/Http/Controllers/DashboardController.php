<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index(Request $request)
{
    $query = Transaction::query();

    if ($request->filled('month')) {
        $query->whereMonth('created_at', $request->month);
    }

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    $transactions = $query->paginate(10);

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

    $divisionData = Transaction::select('division', DB::raw('SUM(gross_amount) as total'))
        ->groupBy('division')
        ->get();

    return view('dashboard', compact('data', 'transactions', 'divisionData'));
}


    public function pie()
    {
        $contributions = Transaction::select('category', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('category')
            ->get();

        return view('dashboard', ['contributions' => $contributions]);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return response()->json(['success' => true, 'message' => 'Transaction deleted successfully.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'institution' => 'nullable|string|max:255',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->institution = $request->institution;
        $transaction->save();

        return response()->json(['success' => true, 'message' => 'Transaction updated successfully.']);
    }
}
