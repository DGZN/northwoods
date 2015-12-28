<?php

namespace App\Mailer;

use \Mail;
use Exception;

class SendMail extends Exception
{
    protected $data = null;

    public function send($data)
    {
      $this->data = $data;
      Mail::send('emails.project', $data, function ($message) {
        $message->from('approval@giant-interactive.com', 'Giant Interactive Approval Site');
        $message->to($this->data['to']);
        if ($this->data['cc']) $message->cc($this->data['cc']);
      });
    }
}
