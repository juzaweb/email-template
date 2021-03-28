<?php

namespace Theanh\EmailTemplate\Commands;

use Theanh\EmailTemplate\Models\EmailList;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

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
            $mail = EmailList::where('status', '=', 'pending')
                ->orderBy('priority', 'DESC')
                ->first();
            
            if (empty($mail)) {
                return;
            }
    
            $mail->update([
                'status' => 'processing',
            ]);
            
            try {
                $this->sendMail($mail);
            }
            catch (\Exception $exception) {
                $mail->update([
                    'error' => $exception->getMessage(),
                    'status' => 'error',
                ]);
            }
            
            $send++;
            
            if ($send >= $limit) {
                break;
            }
        }
    }
    
    /**
     * @param \Theanh\EmailTemplate\Models\EmailList $mail
     * @return bool
     * */
    protected function sendMail($mail) {
        Mail::send('layouts.email', [
            'content' => $this->mapParams($mail->content, $mail->params),
        ], function ($message) use ($mail) {
            $message->to(explode(',', $mail->email))
                ->subject($this->mapParams($mail->subject, $mail->params));
        });
    
        if (Mail::failures()) {
            $mail->update([
                'error' => @json_encode(Mail::failures()),
                'status' => 'error',
            ]);
            
            return false;
        }
    
        // Update status to success
        $mail->update([
                'status' => 'success',
            ]);
        
        return true;
    }
    
    /**
     * Map your paramaters to subject and content email
     *
     * @param string $content
     * @param array $params
     * @return string
     * */
    protected function mapParams($content, $params) {
        $params = json_decode($params);
        foreach ($params as $key => $param) {
            $content = str_replace('{'. $key .'}', $param, $content);
        }
        
        return $content;
    }
}
