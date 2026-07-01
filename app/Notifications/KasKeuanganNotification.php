<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\KasKeuangan;

class KasKeuanganNotification extends Notification
{
    use Queueable;

    protected $kas;
    protected $pesan;

    public function __construct(KasKeuangan $kas, $pesan)
    {
        $this->kas = $kas;
        $this->pesan = $pesan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'judul' => 'Update Kas Keuangan',
            'pesan' => $this->pesan,
            'url' => route('keuangan.index'),
        ];
    }
}
