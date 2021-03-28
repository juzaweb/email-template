<?php

namespace Theanh\EmailTemplate;

use Illuminate\Support\ServiceProvider;
use Theanh\EmailTemplate\Contracts\EmailServiceContract;
use Theanh\EmailTemplate\Helpers\SendEmail;

class EmailTemplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }
    
    public function register()
    {
        $this->app->singleton(EmailServiceContract::class, function () {
            return new SendEmail();
        });
    }
}