<?php

namespace Theanh\EmailTemplate;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Theanh\EmailTemplate\Commands\SendMailCommand;
use Theanh\EmailTemplate\Contracts\EmailServiceContract;
use Theanh\EmailTemplate\Helpers\SendEmail;

class EmailTemplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('uploads:clear')->everyMinute();
        });
    }
    
    public function register()
    {
        $this->app->singleton(EmailServiceContract::class, function () {
            return new SendEmail();
        });
    
        $this->commands([
            SendMailCommand::class,
        ]);
    }
}