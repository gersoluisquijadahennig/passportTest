<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends ResetPassword
{
    public $token;
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail']; // Envía la notificación por correo
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Restablecimiento de contraseña')
                    ->line('Está recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.')
                    ->action('Restablecer contraseña', url(config('app.url').route('password.reset', $this->token, false)))
                    ->line('Si no solicitó un restablecimiento de contraseña, no se requiere ninguna acción adicional.');
    }
}
