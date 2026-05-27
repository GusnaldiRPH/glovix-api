<?php

namespace Database\Seeders;

use App\Models\Asset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Asset::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $assets = [
            // Crypto (4)
            ['name' => 'Bitcoin',  'symbol' => 'BTC/USD',  'type' => 'crypto',         'current_price' => 50000],
            ['name' => 'Ethereum', 'symbol' => 'ETH/USD',  'type' => 'crypto',         'current_price' => 3000],
            ['name' => 'Solana',   'symbol' => 'SOL/USD',  'type' => 'crypto',         'current_price' => 100],
            ['name' => 'BNB',      'symbol' => 'BNB/USD',  'type' => 'crypto',         'current_price' => 400],

            // Saham IDX (4)
            ['name' => 'Bank BCA',     'symbol' => 'BBCA.IDX', 'type' => 'stock', 'current_price' => 9500],
            ['name' => 'Bank Mandiri', 'symbol' => 'BMRI.IDX', 'type' => 'stock', 'current_price' => 6500],
            ['name' => 'Telkom',       'symbol' => 'TLKM.IDX', 'type' => 'stock', 'current_price' => 3500],
            ['name' => 'BRI',          'symbol' => 'BBRI.IDX', 'type' => 'stock', 'current_price' => 4500],

            // Logam Mulia (4)
            ['name' => 'Gold',     'symbol' => 'XAU/USD', 'type' => 'precious_metal', 'current_price' => 2000],
            ['name' => 'Silver',   'symbol' => 'XAG/USD', 'type' => 'precious_metal', 'current_price' => 25],
            ['name' => 'Platinum', 'symbol' => 'XPT/USD', 'type' => 'precious_metal', 'current_price' => 1000],
            ['name' => 'Palladium','symbol' => 'XPD/USD', 'type' => 'precious_metal', 'current_price' => 1500],
        ];

        foreach ($assets as $asset) {
            Asset::create($asset);
        }
        \Artisan::call('assets:update-prices');
    }
}