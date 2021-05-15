<?php require_once('../admin/initialize.php');


// $args['to']     = 'edwardarilla@gmail.com';
// $args['subject'] = 'test Proposal';
// $args['from'] = 'support@californila.com'; 
// $args['message'] = 'test-email';
// $product = new Email();
// $data = $product->sendEmailData();
// echo $data;


// <?php
$to = "edwardarilla@gmail.com";
$subject = "Subject";

// compose headers
$headers = "From: support@californila.com\r\n";
$headers .= "Reply-To: support@californila.com\r\n";
$headers .= "X-Mailer: PHP/".phpversion();

// compose message
$message = " Lorem ipsum dolor sit amet, consectetuer adipiscing elit.";
$message .= " Nam iaculis pede ac quam. Etiam placerat suscipit nulla.";
$message .= " Maecenas id mauris eget tortor facilisis egestas.";
$message .= " Praesent ac augue sed enim aliquam auctor. Ut dignissim ultricies est.";
$message .= " Pellentesque convallis tempor tortor. Nullam nec purus.";
$message = wordwrap($message, 70);

// send email
mail($to, $subject, $message, $headers);
?>