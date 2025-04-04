<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['otp'])) {
        die("Error: No OTP found. Please request a new OTP.");
    }

    $entered_otp = $_POST['otp'];
    $correct_otp = $_SESSION['otp'];

    if ($entered_otp == $correct_otp) {
        // OTP Verified: Redirect to HomePage.html
        unset($_SESSION['otp']); // Clear OTP session
        header("Location: HomePage.html");
        exit();
    } else {
        echo "<script>alert('Invalid OTP! Try again.'); window.location.href='verify_otp.html';</script>";
    }
}
?>
