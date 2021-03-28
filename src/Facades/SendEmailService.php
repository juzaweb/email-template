<?php

namespace Theanh\EmailTemplate\Facades;

use Illuminate\Support\Facades\Facade;
use Theanh\EmailTemplate\Contracts\SendEmailServiceContract;

/**
 * @method static bool send(\Theanh\EmailTemplate\Models\EmailList $mail)
 * */
class SendEmailService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SendEmailServiceContract::class;
    }
}