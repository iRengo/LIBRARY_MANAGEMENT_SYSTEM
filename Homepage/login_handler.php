<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // reCAPTCHA response
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Your Secret Key from Google reCAPTCHA
    $secret_key = "6LcbyK0qAAAAAPDOL2x3oYM8ZTRrgnKvRZR3QLWQ";

    // Verify the reCAPTCHA response
    $verify_url = "https://www.google.com/recaptcha/api/siteverify";
    $response = file_get_contents($verify_url . "?secret=" . $secret_key . "&response=" . $recaptcha_response);
    $response_keys = json_decode($response, true);

    // Check if the reCAPTCHA was successful
    if ($response_keys["success"]) {
        // reCAPTCHA validated successfully, proceed with login logic
        echo "reCAPTCHA verification passed!";
        // Continue with authentication process...
    } else {
        // reCAPTCHA failed
        echo "Please verify that you are not a robot!";
    }
}
?>
