<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view items')->only(['index', 'show']);
        $this->middleware('can:create item')->only(['create', 'store']);
        $this->middleware('can:edit item')->only(['edit', 'update']);
        $this->middleware('can:delete item')->only(['destroy']);
    }

    public function index()
    {
        $items = Item::latest()->paginate(5);
        return view('items.index',compact('items'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'minimum_stock' => 'required|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        Item::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'minimum_stock' => $request->minimum_stock,
        ]);

        return redirect()->route('items.index')
                        ->with('success','Barang berhasil ditambahkan.');
    }

    public function show(Item $item)
    {
        return view('items.show',compact('item'));
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('items.edit',compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'minimum_stock' => 'required|integer|min:0',
        ]);

        $imagePath = $item->image;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('items', 'public');
        }

        $item->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'minimum_stock' => $request->minimum_stock,
        ]);

        return redirect()->route('items.index')
                        ->with('success','Barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        $item->delete();

        return redirect()->route('items.index')
                        ->with('success','Barang berhasil dihapus.');
    }
}