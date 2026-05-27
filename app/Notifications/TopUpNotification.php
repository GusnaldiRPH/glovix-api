<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TopUpNotification extends Notification
{
    use Queueable;

    protected $amount;
    protected $newBalance;

    public function __construct($amount, $newBalance)
    {
        $this->amount     = $amount;
        $this->newBalance = $newBalance;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'    => 'topup',
            'title'   => 'Top Up Berhasil ✅',
            'message' => 'Saldo kamu bertambah Rp ' . number_format($this->amount, 0, ',', '.') . '. Saldo sekarang: Rp ' . number_format($this->newBalance, 0, ',', '.'),
            'url'     => '/purchase',
            'icon'    => 'fas fa-wallet',
            'color'   => 'green',
        ];
    }
}