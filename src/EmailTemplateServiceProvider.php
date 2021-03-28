<?php

namespace Theanh\EmailTemplate;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Theanh\EmailTemplate\Commands\SendMailCommand;
use Theanh\EmailTemplate\Contracts\EmailServiceContract;
use Theanh\EmailTemplate\Contracts\SendEmailServiceContract;
use Theanh\EmailTemplate\Helpers\EmailService;
use Theanh\EmailTemplate\Helpers\SendEmailService;

class EmailTemplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'emailtemplate');
        
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('email:send')->everyMinute();
        });
    }
    
    public function register()
    {
        $this->app->singleton(EmailServiceContract::class, function () {
            return new EmailService();
        });
    
        $this->app->singleton(SendEmailServiceContract::class, function () {
            return new SendEmailService();
        });
    
        $this->commands([
            SendMailCommand::class,
        ]);
    }
}