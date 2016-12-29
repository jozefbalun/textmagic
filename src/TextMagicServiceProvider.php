<?php

namespace NotificationChannels\TextMagic;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class TextMagicServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->when(TextMagicChannel::class)
            ->needs(TextMagic::class)
            ->give(function () {
                return new TextMagic(
                    new Client(),
                    config('services.textmagic.api_key'),
                    config('services.textmagic.username')
                );
            });

        $this->app['router']->post('textmagic-sms-callback', 'NotificationChannels\TextMagic\TextMagic@callback');
    }
}
