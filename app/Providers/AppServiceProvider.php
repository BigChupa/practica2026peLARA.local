<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Order;
use App\Models\User;
use App\Policies\AppointmentPolicy;
use App\Policies\OrderPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
   
    public function register(): void
    {
        
    }


    public function boot(): void
    {
        if (app()->environment('production')) {
        URL::forceScheme('https');
        }
        Gate::policy(Appointment::class, AppointmentPolicy::class);
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}
