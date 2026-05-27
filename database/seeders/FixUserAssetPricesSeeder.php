<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserAsset;
use Illuminate\Support\Facades\DB;

class FixUserAssetPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting to fix user_assets purchase prices...');
        
        // Get all user_assets yang purchase_price = 0 atau NULL
        $userAssets = UserAsset::with('asset')
            ->where(function($query) {
                $query->where('purchase_price', 0)
                      ->orWhereNull('purchase_price');
            })
            ->get();
        
        if ($userAssets->count() == 0) {
            $this->command->info('No records to fix. All purchase prices are already set!');
            return;
        }
        
        $this->command->info("Found {$userAssets->count()} records to fix...");
        
        $fixed = 0;
        
        foreach ($userAssets as $userAsset) {
            if ($userAsset->asset) {
                $oldPrice = $userAsset->purchase_price;
                $newPrice = $userAsset->asset->current_price;
                
                $userAsset->update([
                    'purchase_price' => $newPrice
                ]);
                
                $this->command->line("✓ Fixed UserAsset ID {$userAsset->id} ({$userAsset->asset->name}): {$oldPrice} → {$newPrice}");
                $fixed++;
            } else {
                $this->command->error("✗ UserAsset ID {$userAsset->id} has no related asset!");
            }
        }
        
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->command->info("✓ Successfully fixed {$fixed} records!");
        $this->command->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
    }
}