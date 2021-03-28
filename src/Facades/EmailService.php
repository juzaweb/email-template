<?php

namespace Theanh\EmailTemplate\Facades;

use Illuminate\Support\Facades\Facade;
use Theanh\EmailTemplate\Contracts\EmailServiceContract;

/**
 * @method static EmailService withTemplate($templateCode)
 * @method EmailService setEmails(array $mails)
 * @method EmailService setParams(array $params)
 * @method EmailService setPriority(int $priority)
 * @method EmailService setSubject($subject)
 * @method EmailService setBody($body)
 * @method void send()
 **/
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