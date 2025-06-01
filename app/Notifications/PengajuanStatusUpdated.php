<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PengajuanStatusUpdated extends Notification
{
    use Queueable;

    protected $pengajuan;
    protected $status;
    protected $catatan;

    /**
     * Create a new notification instance.
     */
    public function __construct($pengajuan, $status, $catatan = null)
    {
        $this->pengajuan = $pengajuan;
        $this->status = $status;
        $this->catatan = $catatan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pembaruan Status Pengajuan Sertifikasi')
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Status pengajuan Anda untuk kegiatan "' . $this->pengajuan->nama . '" telah diperbarui.')
            ->line('Status Baru: ' . str_replace('_', ' ', $this->status))
            ->line('Tanggal Pembaruan: ' . now()->format('Y-m-d H:i'))
            ->when($this->catatan, fn ($mail) => $mail->line('Catatan: ' . $this->catatan))
            ->action('Lihat Detail', url('/pengajuan/' . $this->pengajuan->id))
            ->line('Terima kasih atas perhatiannya!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}