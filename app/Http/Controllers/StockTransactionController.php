<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockTransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:record stock transaction');
    }

    public function stockIn(Request $request, Item $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        StockTransaction::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'type' => 'in',
            'quantity' => $request->quantity,
            'notes' => $request->notes,
        ]);

        return redirect()->route('items.show', $item->id)->with('success', 'Stok berhasil ditambahkan!');
    }

    public function stockOut(Request $request, Item $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        // Optional: Add logic to prevent stock from going negative
        if ($request->quantity > $item->stock) {
            return redirect()->route('items.show', $item->id)->with('error', 'Kuantitas yang dikurangi melebihi stok yang tersedia.');
        }

        StockTransaction::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'type' => 'out',
            'quantity' => $request->quantity,
            'notes' => $request->notes,
        ]);

        return redirect()->route('items.show', $item->id)->with('success', 'Stok berhasil dikurangi!');
    }
}
