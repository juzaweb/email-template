<?php

namespace Theanh\EmailTemplate\Helpers;

use Theanh\EmailTemplate\Models\EmailList;
use Theanh\EmailTemplate\Models\EmailTemplate;

class SendEmail
{
    protected $emails;
    protected $template;
    protected $params = [];
    protected $priority = 1;
    protected $subject;
    protected $body;
    
    /**
     * Set template for email by template code
     *
     * @param string $templateCode
     * */
    public function withTemplate(string $templateCode)
    {
        $this->template = $templateCode;
    }
    
    /**
     * Set emails will send
     *
     * @param string|array $emails
     * */
    public function setEmails($emails)
    {
        if (is_array($emails)) {
            $this->emails = array_unique($emails);
        }
        
        $this->emails = [$emails];
    }
    
    /**
     * Set params for email
     *
     * @param array $params
     * */
    public function setParams(array $params)
    {
        $this->params = $params;
    }
    
    public function setPriority(int $priority)
    {
        $this->priority = $priority;
    }
    
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
    
    public function setBody($body)
    {
        $this->body = $body;
    }
    
    public function send()
    {
        $templateId = $this->validate();
        $data = [];
        
        if ($this->subject) {
            $data['subject'] = $this->subject;
        }
        
        if ($this->body) {
            $data['body'] = $this->body;
        }
        
        foreach ($this->emails as $email) {
            EmailList::create([
                'email' => $email,
                'template_id' => $templateId,
                'params' => $this->params,
                'priority' => $this->priority,
                'data' => $data,
            ]);
        }
    }
    
    protected function validate()
    {
        if (empty($this->template)) {
            throw new \Exception('Email template is required.');
        }
        
        $template = EmailTemplate::where(['code' => $this->template])
            ->first(['id']);
        if (empty($template)) {
            throw new \Exception("Email template [{$this->template}] does not exist.");
        }
        
        return $template->id;
    }
}
