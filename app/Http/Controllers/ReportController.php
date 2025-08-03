<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view reports');
    }

    public function currentStock()
    {
        $items = Item::with('category')->get();
        return view('reports.current_stock', compact('items'));
    }

    public function stockMovement(Request $request)
    {
        $query = StockTransaction::with('item.category', 'user');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('item_id')) {
            $query->where('item_id', $request->item_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(10);
        $items = Item::orderBy('name')->get(); // For filter dropdown

        return view('reports.stock_movement', compact('transactions', 'items'));
    }
}
