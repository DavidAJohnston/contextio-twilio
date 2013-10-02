<?php

include 'credentials.php';
require 'vendor/Services/Twilio.php';

$json = file_get_contents('php://input');
$data = json_decode($json);

//use the from/subject from the webhook call to create text message
$sms_body  = $data->message_data->addresses->from->name;
$sms_body .= " just emailed: \n";
$sms_body .= $data->message_data->subject;

//send the text message
$client = new Services_Twilio($AccountSid, $AuthToken);
$message = $client->account->messages->sendMessage(
    $fromNumber, // From a Twilio number in your account
    $toNumber, // Text any number
    $sms_body
);