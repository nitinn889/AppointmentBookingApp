
<?php
// Required if your environment does not handle autoloading
require __DIR__ . '/twilio-php-main/src/Twilio/autoload.php';

// Your Account SID and Auth Token from console.twilio.com
$sid = "AC2439df214339bd6120d9123ceab6cd13";
$token = "68bd88eedd6f5e49edc0b4a467d619b7";
$client = new Twilio\Rest\Client($sid, $token);

// Use the Client to make requests to the Twilio REST API
$client->messages->create(
    // The number you'd like to send the message to
    '+919497145317',
    [
        // A Twilio phone number you purchased at https://console.twilio.com
        'from' => '+919497145317',
        // The body of the text message you'd like to send
        'body' => "Hi, Is this working??"
    ]
);