<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Laporan;

class LaporanNotification extends Notification
{
    use Queueable;

    protected $laporan;
    protected $pesan;

    /**
     * Create a new notification instance.
     */
    public function __construct(Laporan $laporan, $pesan)
    {
        $this->laporan = $laporan;
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
            'judul' => 'Info Laporan Warga',
            'pesan' => $this->pesan,
            'url' => route('laporan.show', $this->laporan->id),
        ];
    }
}
