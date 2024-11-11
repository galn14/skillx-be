<?php

// app/Providers/FirebaseServiceProvider.php
namespace App\Providers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Illuminate\Support\ServiceProvider;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Database::class, function ($app) {
            return (new Factory)
                ->withServiceAccount(config('services.firebase.credentials'))
                ->createDatabase();
        });
    }
}
