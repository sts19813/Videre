<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Provider;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProviderWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $provider;
    public $password;

    public function __construct(User $user, Provider $provider, string $password)
    {
        $this->user = $user;
        $this->provider = $provider;
        $this->password = $password;
    }

    public function build()
    {
        return $this
            ->subject('Bienvenido a Videre – Acceso como Afiliado')
            ->view('emails.provider-welcome');
    }
}
