<?php

include 'credentials.php';
require 'vendor/Services/Twilio.php';
require 'vendor/PHP-ContextIO/class.contextio.php';

$message_id = $_GET['message_id'];

$contextIO = new ContextIO($consumerKey, $consumerSecret);

//use the message id to get the message body
$message = $contextIO->getMessage($account_id,
    array('message_id' => $message_id, 'type' => 'text/plain'));

$welcome = '';
//use the message id to get the message information
if (is_object($message)) {
    $content = $message->getData();
    $welcome  = $content['addresses']['from']['name'];
    $welcome .= ' just emailed ';
    $welcome .= $content['subject'];
}

//use the message id to get the message body
$message = $contextIO->getMessageBody($account_id,
    array('message_id' => $message_id, 'type' => 'text/plain'));

if (is_object($message)) {
    $content = $message->getData();
    $body = $content[0]['content'];
}

// create the body of the Twiml
$response = new Services_Twilio_Twiml();
$response->say($welcome);
$response->say("Here's the message");
$response->say($body);

print $response;