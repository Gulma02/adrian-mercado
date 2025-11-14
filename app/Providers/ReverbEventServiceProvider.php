<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Listener\SocketListener;

class ReverbEventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Escuchar todos los mensajes entrantes en el canal "frontend"
        #Reverb::listen('frontend', function ($payload) {(new SocketListener())->handle($payload);});
    }
}
