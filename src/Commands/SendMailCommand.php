<?php

namespace Theanh\EmailTemplate\Commands;

use Theanh\EmailTemplate\Facades\SendEmailService;
use Theanh\EmailTemplate\Models\EmailList;
use Illuminate\Console\Command;

class SendMailCommand extends Command
{
    protected $signature = 'email:send';
    
    protected $description = 'Send email command';
    
    /**
     * Use command to send email to avoid affecting the user experience
     * Get email list in email_lists table and send
     * All you need to do is save the email to be sent to the table email_lists
     * */
    public function handle()
    {
        $limit = 10;
        $send = 0;
        
        while (true) {
            $mail = EmailList::with(['template'])
                ->where('status', '=', 'pending')
                ->orderBy('priority', 'DESC')
                ->first();
            
            if (empty($mail)) {
                return;
            }
            
            if (SendEmailService::send($mail)) {
                $this->info('Send mail successful: ' . $mail->id);
            }
            else {
                $this->error('Send mail error: ' . $mail->id);
            }
            
            $send++;
            
            if ($send >= $limit) {
                break;
            }
        }
    }
}
