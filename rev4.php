<?php

include 'credentials.php';
require 'vendor/Services/Twilio.php';
require 'vendor/PHP-ContextIO/class.contextio.php';

$json = file_get_contents('php://input');
$data = json_decode($json);

$message_id = $data->message_data->message_id;

//use the message id to create the reading url
$url = 'http://demo.caseysoftware.com/contextio/rev4-navigate.php?message_id=' . $message_id;

//send the text message
$client = new Services_Twilio($AccountSid, $AuthToken);
$message = $client->account->calls->create(
    $fromNumber, // From a Twilio number in your account
    $toNumber, // Text any number
    $url
);