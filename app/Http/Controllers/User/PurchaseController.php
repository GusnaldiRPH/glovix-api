<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\UserAsset;
use App\Models\Transaction; // ← tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\TopUpNotification;
use App\Notifications\PurchaseNotification;

class PurchaseController extends Controller
{
    public function index()
    {
        $assets = Asset::all();

        $userAssets = UserAsset::with('asset')
            ->where('user_id', auth()->id())
            ->get();

        return view('user.purchase.index', compact('assets', 'userAssets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'quantity' => 'required|numeric|min:0.001',
        ]);

        $asset        = Asset::findOrFail($request->asset_id);
        $currentPrice = $asset->current_price;
        $quantity     = $request->quantity;
        $wallet       = Auth::user()->wallet;

        $usdToIdr     = 15000;
        $isUsd        = in_array($asset->type, ['crypto', 'precious_metal']);
        $totalCostIdr = $isUsd
            ? $currentPrice * $quantity * $usdToIdr
            : $currentPrice * $quantity;

        if (!$wallet || $wallet->balance < $totalCostIdr) {
            return redirect()->back()
                ->with('error', 'Saldo tidak mencukupi. Saldo Anda: Rp ' .
                    number_format($wallet->balance ?? 0, 0, ',', '.') .
                    ', dibutuhkan: Rp ' . number_format($totalCostIdr, 0, ',', '.'));
        }

        DB::beginTransaction();

        try {
            $wallet->decrement('balance', $totalCostIdr);

            $userAsset = UserAsset::where('user_id', auth()->id())
                ->where('asset_id', $asset->id)
                ->first();

            if ($userAsset) {
                $oldQuantity  = $userAsset->quantity;
                $oldPrice     = $userAsset->purchase_price;
                $totalQty     = $oldQuantity + $quantity;
                $averagePrice = (($oldPrice * $oldQuantity) + ($currentPrice * $quantity)) / $totalQty;

                $userAsset->update([
                    'quantity'       => $totalQty,
                    'purchase_price' => $averagePrice,
                ]);
            } else {
                UserAsset::create([
                    'user_id'        => auth()->id(),
                    'asset_id'       => $asset->id,
                    'quantity'       => $quantity,
                    'purchase_price' => $currentPrice,
                ]);
            }

            // ✅ Simpan ke tabel transactions
            Transaction::create([
                'user_id'     => auth()->id(),
                'type'        => 'purchase',
                'amount'      => $totalCostIdr,
                'description' => 'Beli ' . number_format($quantity, 4) . ' ' . $asset->name,
                'status'      => 'completed',
            ]);

            DB::commit();

            $currency = $isUsd ? 'USD' : 'IDR';
            $total    = $isUsd ? $currentPrice * $quantity : $totalCostIdr;
            Auth::user()->notify(new PurchaseNotification($asset->name, $quantity, $total, $currency));

            return redirect()->route('purchase.index')
                ->with('success', 'Pembelian berhasil! Rp ' .
                    number_format($totalCostIdr, 0, ',', '.') .
                    ' telah dipotong dari saldo Anda.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Purchase failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function topup(Request $request)
    {
        $request->validate([
            'amount'         => 'required|numeric|min:10000',
            'payment_method' => 'required|string',
        ]);

        $user   = Auth::user();
        $wallet = $user->wallet;
        $amount = $request->amount;

        DB::beginTransaction();

        try {
            if ($wallet) {
                $wallet->increment('balance', $amount);
            } else {
                $user->wallet()->create(['balance' => $amount]);
            }

            // ✅ Simpan ke tabel transactions
            Transaction::create([
                'user_id'     => $user->id,
                'type'        => 'topup',
                'amount'      => $amount,
                'description' => 'Top up saldo via ' . $request->payment_method,
                'status'      => 'completed',
            ]);

            DB::commit();

            $newBalance = $user->fresh()->wallet->balance;
            $user->notify(new TopUpNotification($amount, $newBalance));

            return redirect()->route('purchase.index')
                ->with('success', 'Top up sebesar Rp ' . number_format($amount, 0, ',', '.') . ' berhasil!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Topup failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Top up gagal: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $request->validate([
            'sell_quantity' => 'required|numeric|min:0.0001',
        ]);

        $userAsset = UserAsset::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $sellQty = (float) $request->sell_quantity;

        if ($sellQty > $userAsset->quantity) {
            return redirect()->back()
                ->with('error', 'Jumlah jual melebihi jumlah aset yang dimiliki (' .
                    number_format($userAsset->quantity, 4) . ').');
        }

        $asset  = $userAsset->asset;
        $wallet = Auth::user()->wallet;

        DB::beginTransaction();

        try {
            $usdToIdr  = 15000;
            $isUsd     = in_array($asset->type, ['crypto', 'precious_metal']);
            $returnIdr = $isUsd
                ? $asset->current_price * $sellQty * $usdToIdr
                : $asset->current_price * $sellQty;

            if ($wallet) {
                $wallet->increment('balance', $returnIdr);
            }

            $remainingQty = $userAsset->quantity - $sellQty;

            if ($remainingQty <= 0.00001) {
                $userAsset->delete();
                $msg = 'Semua aset ' . $asset->name . ' berhasil dijual.';
            } else {
                $userAsset->update(['quantity' => $remainingQty]);
                $msg = number_format($sellQty, 4) . ' ' . $asset->name . ' berhasil dijual.';
            }

            // ✅ Simpan ke tabel transactions
            Transaction::create([
                'user_id'     => auth()->id(),
                'type'        => 'sell',
                'amount'      => $returnIdr,
                'description' => 'Jual ' . number_format($sellQty, 4) . ' ' . $asset->name,
                'status'      => 'completed',
            ]);

            DB::commit();

            Log::info('Sell asset', [
                'user_id'    => auth()->id(),
                'asset_id'   => $asset->id,
                'sell_qty'   => $sellQty,
                'return_idr' => $returnIdr,
            ]);

            return redirect()->route('purchase.index')
                ->with('success', $msg . ' Saldo bertambah Rp ' . number_format($returnIdr, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Sell failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal menjual aset: ' . $e->getMessage());
        }
    }
}