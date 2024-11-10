<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class UserNotificationExcel extends Notification
{
    use Queueable;

    private $user;
    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!')
            ->line(new HtmlString('This email may contain <strong>Hola ' . $this->user->name . '</strong>'));

        // Verificar y adjuntar el primer archivo
        if (Storage::disk('public')->exists('documentos/users.xlsx')) {
            $filePath = Storage::disk('public')->path('documentos/users.xlsx');
            $mailMessage->attach($filePath, [
                'as' => 'users.xlsx',
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        }

        // Verificar y adjuntar el segundo archivo
        // if (Storage::disk('public')->exists('documentos/users.pdf')) {
        //     $filePath = Storage::disk('public')->path('documentos/users.pdf');
        //     $mailMessage->attach($filePath, [
        //         'as' => 'users.pdf',
        //         'mime' => 'application/pdf',
        //     ]);
        // }

        return $mailMessage;
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
