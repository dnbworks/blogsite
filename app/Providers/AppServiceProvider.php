<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use App\Services\MailchimpNewsletter;
use Illuminate\Pagination\Paginator;
use MailchimpMarketing\ApiClient;
use App\Services\Newsletter;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Blade;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(Newsletter::class, function () {
            $client = (new ApiClient)->setConfig([
                'apiKey' => config('services.mailchimp.key'),
                'server' => 'us14'
            ]);

            return new MailchimpNewsletter($client);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useTailwind();

        Gate::define('admin', function(User $user){
            return $user->username === 'kiwononline';
        });

        Blade::if('admin', function () {
            return request()->user()?->can('admin');
        });
    }
}
