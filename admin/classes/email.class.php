
<?php


class Email extends DatabaseObject {


    public $to;
    public $subject;
    public $from;
    public  $message;
    public function __construct($args=[]) {
        $this->to = $args['to'] ?? '';
        $this->subject = $args['subject'] ?? '';
        $this->from = $args['from'] ?? '';
        $this->message = $args['message'] ?? '';
    }

    public function sendEmailData(){
        
        // To send HTML mail, the Content-type header must be set
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

        // Sending email
        if(mail( $this->$to,  $this->$subject,  $this->$message, $headers)){
           return true;
        } else{
          return false;
        }
    
    }

}