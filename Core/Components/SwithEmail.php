<?php
/**
 * SwithEmail.php
 * User: Swith
 * Date: 02/02/15
 */

namespace Core\Components;


class SwithEmail {

    private $to;
    private $subject;
    private $message;

    public function to($mails){
        $this->to = $mails;
        return $this;
    }

    public function subject($subject){
        $this->subject = $subject;
        return $this;
    }

    public function message($message){
        $this->message = $message;
        return $this;
    }

    public function send(){
        $headers = 'From: webmaster@example.com';
        mail($this->to,$this->subject,$this->message,$headers);
    }


} 