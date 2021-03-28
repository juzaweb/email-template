<?php

namespace Theanh\EmailTemplate\Facades;

use Illuminate\Support\Facades\Facade;
use Theanh\EmailTemplate\Contracts\EmailServiceContract;

class EmailService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return EmailServiceContract::class;
    }
}