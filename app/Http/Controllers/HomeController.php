<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalCategories = Category::count();
        $totalItems = Item::count();
        $lowStockItems = Item::getLowStockItems();
        $totalStock = Item::all()->sum('stock');

        return view('home', compact('totalCategories', 'totalItems', 'lowStockItems', 'totalStock'));
    }
}
