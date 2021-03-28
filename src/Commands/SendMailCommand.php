<?php

namespace Theanh\EmailTemplate\Commands;

use Theanh\EmailTemplate\Models\EmailList;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

class SendMailCommand extends Command
{
    protected $signature = 'email:send';
    
    protected $description = 'Send email command';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * TAD CMS: Use command to send email to avoid affecting the user experience
     * Get email list in email_lists table and send
     * All you need to do is save the email to be sent to the table email_lists
     * */
    public function handle()
    {
        $limit = 10;
        
        $send = 0;
        
        while (true) {
    
            $mail = EmailList::where('status', '=', 2)
                ->orderBy('priority', 'DESC')
                ->first();
    
            if (!$mail) {
                return;
            }
            
            $this->sendMail($mail);
            $send++;
            
            if ($send >= $limit) {
                break;
            }
        }
        
        
    }
    
    /**
     * @param \Theanh\EmailTemplate\Models\EmailList $template
     * @return bool
     * */
    protected function sendMail($template) {
        $template->update([
                'status' => 3,
            ]);
        
        
    
        // Send mail in list
        Mail::send('emails.template', [
            'content' => $this->mapParams($row->content, $row->params),
        ], function ($message) use ($row) {
            $message->to(explode(',', $row->emails))
                ->subject($this->mapParams($row->subject, $row->params));
        });
    
        if (Mail::failures()) {
            $template->update([
                    'error' => @json_encode(Mail::failures()),
                    'status' => 0,
                ]);
            
            return false;
        }
    
        // Update status to success
        EmailList::where('id', '=', $row->id)
            ->update([
                'status' => 1,
            ]);
        
        return true;
    }
    
    /**
     * TAD CMS: Map your paramaters to subject and content email
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
