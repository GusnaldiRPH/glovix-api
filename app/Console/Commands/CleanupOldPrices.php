<?php

namespace App\Console\Commands;

use App\Models\AssetPrice;
use Illuminate\Console\Command;

class CleanupOldPrices extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'assets:cleanup-old-prices {--days=90 : Keep prices for the last N days}';

    /**
     * The console command description.
     */
    protected $description = 'Clean up old asset prices from database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = now()->subDays($days);
        
        $this->info("Cleaning up asset prices older than {$days} days...");
        $this->info("Cutoff date: {$cutoffDate->format('Y-m-d H:i:s')}");
        
        // Count old records
        $count = AssetPrice::where('price_date', '<', $cutoffDate)->count();
        
        if ($count === 0) {
            $this->info('No old records to clean up.');
            return 0;
        }
        
        $this->warn("Found {$count} old records.");
        
        if ($this->confirm('Do you want to delete these records?', true)) {
            // Delete old records
            $deleted = AssetPrice::where('price_date', '<', $cutoffDate)->delete();
            
            $this->info("✅ Deleted {$deleted} old price records.");
            $this->info('Database cleaned successfully!');
        } else {
            $this->info('Cleanup cancelled.');
        }
        
        return 0;
    }
}
