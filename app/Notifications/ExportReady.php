<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExportReady extends Notification
{
    use Queueable;

    /**
     * The file path of the export.
     *
     * @var string
     */
    protected $filePath;

    /**
     * The type of export.
     *
     * @var string
     */
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @param  string  $filePath
     * @param  string  $type
     * @return void
     */
    public function __construct($filePath, $type)
    {
        $this->filePath = $filePath;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Export is Ready')
                    ->line('Your ' . ucfirst($this->type) . ' export is now ready for download.')
                    ->action('Download Export', url('/download/' . basename($this->filePath)))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'Your ' . ucfirst($this->type) . ' export is ready for download.',
            'type' => 'export',
            'file_path' => $this->filePath,
            'download_url' => '/download/' . basename($this->filePath),
        ];
    }
}
