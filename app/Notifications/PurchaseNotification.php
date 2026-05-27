<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PurchaseNotification extends Notification
{
    use Queueable;

    protected $assetName;
    protected $quantity;
    protected $total;
    protected $currency;

    public function __construct($assetName, $quantity, $total, $currency = 'IDR')
    {
        $this->assetName = $assetName;
        $this->quantity  = $quantity;
        $this->total     = $total;
        $this->currency  = $currency;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $totalFormatted = $this->currency === 'USD'
            ? '$' . number_format($this->total, 2, '.', ',')
            : 'Rp ' . number_format($this->total, 0, ',', '.');

        return [
            'type'    => 'purchase',
            'title'   => 'Pembelian Berhasil 📈',
            'message' => 'Kamu berhasil membeli ' . number_format($this->quantity, 4) . ' ' . $this->assetName . ' senilai ' . $totalFormatted,
            'url'     => '/purchase',
            'icon'    => 'fas fa-shopping-cart',
            'color'   => 'amber',
        ];
    }
}