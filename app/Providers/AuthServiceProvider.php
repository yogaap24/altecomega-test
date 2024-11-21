<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Channels\FCMChannel;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Notification;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }

    /**
     * Register custom chanel.
     *
     * @return void
     */
    public function register()
    {
        Notification::extend('fcm', function ($app) {
            return new FCMChannel();
        });
    }
}
