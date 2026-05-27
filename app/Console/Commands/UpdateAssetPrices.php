<?php

namespace App\Console\Commands;

use App\Models\Asset;
use App\Models\AssetPrice;
use App\Services\TwelveDataService;
use Illuminate\Console\Command;

class UpdateAssetPrices extends Command
{
    protected $signature = 'assets:update-prices';
    protected $description = 'Update asset prices from API';

    private $twelveData;

    public function __construct(TwelveDataService $twelveData)
    {
        parent::__construct();
        $this->twelveData = $twelveData;
    }

    public function handle()
    {
        $this->info('🚀 Starting update...');

        $assets  = Asset::all();
        $updated = 0;
        $failed  = 0;

        foreach ($assets as $asset) {
            $symbol = TwelveDataService::formatSymbol($asset->symbol, $asset->type);

            // Pilih source API berdasarkan type
            if ($asset->type === 'stock') {
                // Saham IDX → Yahoo Finance
                $priceData = $this->twelveData->getStockPriceIDX($symbol);
            } elseif ($asset->type === 'precious_metal' && $asset->symbol === 'XAU/USD') {
                // Gold → Twelve Data (support free plan)
                $priceData = $this->twelveData->getPrice($symbol);
            } elseif ($asset->type === 'precious_metal') {
                // Silver, Platinum, Palladium → Yahoo Finance Futures
                $priceData = $this->twelveData->getPreciousMetalPrice($symbol);
            } else {
                // Crypto → Twelve Data
                $priceData = $this->twelveData->getPrice($symbol);
            }

            if ($priceData && isset($priceData['price'])) {
                $asset->update(['current_price' => $priceData['price']]);

                AssetPrice::create([
                    'asset_id'   => $asset->id,
                    'price'      => $priceData['price'],
                    'price_date' => now(),
                ]);

                $this->info("✅ {$asset->name}: Rp " . number_format($priceData['price'], 2));
                $updated++;
            } else {
                $this->warn("❌ Failed: {$asset->name}");
                $failed++;
            }

            sleep(1);
        }

        $this->info("\n📊 Summary:");
        $this->info("   Updated: {$updated}");
        $this->warn("   Failed: {$failed}");

        return 0;
    }
}