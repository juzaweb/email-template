<?php

namespace Theanh\EmailTemplate\Helpers;

use Theanh\EmailTemplate\Models\EmailList;
use Illuminate\Support\Facades\Mail;

class SendEmailService
{
    protected $mail;
    
    /**
     * Send email by row email_lists table
     *
     * @param EmailList $mail
     * @return bool
     * */
    public function send(EmailList $mail)
    {
        $this->mail = $mail;
        
        $validate = $this->validate();
        if ($validate !== true) {
            $this->updateError($validate);
            return false;
        }
        
        $this->updateStatus('processing');
    
        //try {
        
        if ($mail->data) {
        
        }
    
        Mail::send('layouts.email', [
            'content' => $this->mapParams($mail->content, $mail->params),
        ], function ($message) use ($mail) {
            $message->to([$mail->email])
                ->subject($this->mapParams($mail->subject, $mail->params));
        });
    
        if (Mail::failures()) {
            $this->updateError(array_merge([
                'title' => 'Mail failures',
            ], Mail::failures()));
            return false;
        }
    
        return true;
        
        /*}
            catch (\Exception $exception) {
                return [
                        'title' => 'Send mail exception',
                        'message' => $exception->getMessage(),
                        'code' => $exception->getCode(),
                        'line' => $exception->getLine(),
                    ];
            }*/
    
        
    }
    
    protected function updateStatus($status, array $error = [])
    {
        return $this->mail->update([
            'status' => $status,
        ]);
    }
    
    protected function updateError(array $error = [])
    {
        return $this->mail->update([
            'error' => $error,
            'status' => 'error',
        ]);
    }
    
    protected function mapParams($content, $params)
    {
        $params = json_decode($params);
        foreach ($params as $key => $param) {
            $content = str_replace('{'. $key .'}', $param, $content);
        }
        
        return $content;
    }
    
    protected function validate()
    {
        if (empty($this->mail->template)) {
            return [
                'title' => 'Empty email template',
                'message' => 'Email template does not exist.'
            ];
        }
        
        return true;
    }
}