<?php

include 'credentials.php';
require 'vendor/Services/Twilio.php';
require 'vendor/PHP-ContextIO/class.contextio.php';

$json = file_get_contents('php://input');
$data = json_decode($json);

$message_id = $data->message_data->message_id;

$contextIO = new ContextIO($consumerKey, $consumerSecret);

//use the message id to get the message body
$message = $contextIO->getMessageBody($account_id,
    array('message_id' => $message_id, 'type' => 'text/plain'));

if (is_object($message)) {
    $content = $message->getData();
    $body = $content[0]['content'];
}

//use the from/subject/body to create text message
$sms_body  = $data->message_data->addresses->from->name;
$sms_body .= " just emailed: \n";
$sms_body .= $data->message_data->subject;
$sms_body .= "\n\n" . $body;

//send the text message
$client = new Services_Twilio($AccountSid, $AuthToken);
$message = $client->account->messages->sendMessage(
    $fromNumber, // From a Twilio number in your account
    $toNumber, // Text any number
    $sms_body
);