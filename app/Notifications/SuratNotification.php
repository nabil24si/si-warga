<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Surat;

class SuratNotification extends Notification
{
    use Queueable;

    protected $surat;
    protected $pesan;

    public function __construct(Surat $surat, $pesan)
    {
        $this->surat = $surat;
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
            'judul' => 'Update Surat: ' . $this->surat->jenis_surat,
            'pesan' => $this->pesan,
            'url' => route('surat.show', $this->surat->id),
        ];
    }
}
