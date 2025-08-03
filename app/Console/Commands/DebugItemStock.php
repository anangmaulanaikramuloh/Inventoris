<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Item;

class DebugItemStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:item-stock {item_name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug item stock calculation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $itemName = $this->argument('item_name');
        
        if ($itemName) {
            $items = Item::where('name', 'like', "%{$itemName}%")->get();
        } else {
            $items = Item::all();
        }

        if ($items->isEmpty()) {
            $this->error("❌ Tidak ada barang ditemukan dengan nama '{$itemName}'");
            return;
        }

        foreach ($items as $item) {
            $this->info("🔍 DEBUG: {$item->name}");
            $this->line("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
            
            // Basic info
            $this->line("📦 ID: {$item->id}");
            $this->line("📂 Kategori: {$item->category->name}");
            $this->line("📅 Dibuat: {$item->created_at}");
            $this->line("🔢 Minimum Stock: " . ($item->minimum_stock ?? 'NULL'));
            
            // Stock calculation breakdown
            $stockIn = $item->stockTransactions()->where('type', 'in')->sum('quantity');
            $stockOut = $item->stockTransactions()->where('type', 'out')->sum('quantity');
            $currentStock = $stockIn - $stockOut;
            
            $this->line("📈 Total Stok Masuk: {$stockIn}");
            $this->line("📉 Total Stok Keluar: {$stockOut}");
            $this->line("📊 Stok Saat Ini: {$currentStock}");
            $this->line("🎯 Minimum Stock: " . ($item->minimum_stock ?? 10));
            
            // Status calculation
            $isLowStock = $currentStock < ($item->minimum_stock ?? 10);
            $status = $isLowStock ? "⚠️ MENIPIS" : "✅ NORMAL";
            $this->line("🏷️ Status: {$status}");
            
            // Transaction history
            $transactions = $item->stockTransactions()->orderBy('created_at', 'desc')->limit(5)->get();
            if ($transactions->count() > 0) {
                $this->line("\n📋 5 Transaksi Terakhir:");
                foreach ($transactions as $transaction) {
                    $type = $transaction->type == 'in' ? '⬆️ MASUK' : '⬇️ KELUAR';
                    $this->line("  {$type}: {$transaction->quantity} - {$transaction->created_at->format('d/m/Y H:i')}");
                }
            } else {
                $this->line("\n❌ Belum ada transaksi stok!");
            }
            
            $this->line("\n");
        }
        
        // Summary
        $lowStockItems = $items->filter(function($item) {
            return $item->stock < ($item->minimum_stock ?? 10);
        });
        
        $this->info("📊 RINGKASAN:");
        $this->line("Total Barang: " . $items->count());
        $this->line("Stok Normal: " . ($items->count() - $lowStockItems->count()));
        $this->line("Stok Menipis: " . $lowStockItems->count());
    }
}
