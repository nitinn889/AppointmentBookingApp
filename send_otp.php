<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '/Applications/XAMPP/xamppfiles/htdocs/WebDev/new/twilio-php-main/src/Twilio/autoload.php';


use Twilio\Rest\Client;

// Twilio Credentials
$account_sid = 'AC2439df214339bd6120d9123ceab6cd13';
$auth_token = '68bd88eedd6f5e49edc0b4a467d619b7';
$twilio_phone_number = '+18608095377';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['phone']) || empty($_POST['phone'])) {
        die("Error: Phone number is required.");
    }

    $phone = $_POST['phone'];
    $otp = rand(100000, 999999); // Generate a 6-digit OTP

    // Store OTP in session
    $_SESSION['otp'] = $otp;
    $_SESSION['phone'] = $phone;

    // Initialize Twilio Client
    $client = new Client($account_sid, $auth_token);

    try {
        // Send OTP via Twilio SMS
        $message = $client->messages->create(
            $phone,
            [
                'from' => $twilio_phone_number,
                'body' => "Your OTP is: $otp"
            ]
        );

        // Redirect to OTP verification page
        header("Location: verify_otp.html");
        exit();
    } catch (Exception $e) {
        die("Error sending OTP: " . $e->getMessage());
    }
}
?>
