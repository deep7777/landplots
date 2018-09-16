<?php
// Required if your envrionment does not handle autoloading
require __DIR__ . '/vendor/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$sid = 'ACde2648c933e96c7dab4030c388179c7b';
$token = 'b8e45a23494fb14611cdbbf8e6e2dea2';
$client = new Client($sid, $token);

// Use the client to do fun stuff like send text messages!
$result = $client->messages->create(
    // the number you'd like to send the message to
    '+4915175713158',
    array(
        // A Twilio phone number you purchased at twilio.com/console
        'from' => '',//+12566641696
        // the body of the text message you'd like to send
        'body' => 'Hi Rahul! SMS integration from DPK Test MSG.Please ignore'
    )
);
echo __DIR__ . '/vendor/autoload.php';
echo "\n";
print_r($result);