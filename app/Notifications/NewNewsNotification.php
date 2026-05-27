<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewNewsNotification extends Notification
{
    use Queueable;

    protected $news;

    public function __construct($news)
    {
        $this->news = $news;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type'    => 'new_news',
            'title'   => 'Berita Terbaru 📰',
            'message' => $this->news->title,
            'url'     => '/news/' . $this->news->id,
            'icon'    => 'fas fa-newspaper',
            'color'   => 'blue',
        ];
    }
}