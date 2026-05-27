<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $totalSales = Transaction::where('type', 'purchase')
            ->where('status', 'completed')
            ->sum('amount');

        $salesByMonth = Transaction::where('type', 'purchase')
            ->where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        $recentTransactions = Transaction::with('user')
            ->where('type', 'purchase')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.sales.index', compact('totalSales', 'salesByMonth', 'recentTransactions'));
    }
}