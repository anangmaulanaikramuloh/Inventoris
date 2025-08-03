<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'category_id', 'image', 'minimum_stock'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    public function getStockAttribute()
    {
        $stockIn = $this->stockTransactions()->where('type', 'in')->sum('quantity');
        $stockOut = $this->stockTransactions()->where('type', 'out')->sum('quantity');
        return $stockIn - $stockOut;
    }

    public function getIsLowStockAttribute()
    {
        return $this->stock < $this->minimum_stock;
    }

    public static function getLowStockItems()
    {
        return static::all()->filter(function($item) {
            return $item->is_low_stock;
        });
    }
}
