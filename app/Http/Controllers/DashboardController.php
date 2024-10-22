<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));

        $transactions = Transaction::whereYear('created_at', $year)->get();

        $monthlyData = Transaction::select(
                DB::raw('SUM(gross_amount) as total'),
                DB::raw('MONTH(created_at) as month')
            )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $data = array_fill(0, 12, 0);

        foreach ($monthlyData as $entry) {
            $data[$entry->month - 1] = $entry->total;
        }

        // for the pie chart
        $divisionData = Transaction::select('division', DB::raw('SUM(gross_amount) as total'))
            ->whereYear('created_at', $year)
            ->groupBy('division')
            ->get();

        return view('dashboard', compact('data', 'transactions', 'divisionData', 'year'));
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
