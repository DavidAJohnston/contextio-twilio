<?php

include 'credentials.php';
require 'vendor/Services/Twilio.php';

$digits = (int) $_POST['Digits'];
$message_id = $_GET['message_id'];

$contextIO = new ContextIO($consumerKey, $consumerSecret);

switch($digits) {
    case 7:
        $result = $contextIO->deleteMessage($accountId, array('message_id' => $message_id));
        $message = "This message has been deleted";
        break;
    default:
        $message = "I have no clue what you're doing. Stop it.";
        //do nothing
}

$response = new Services_Twilio_Twiml();
$response->say($message);
$response->hangup();