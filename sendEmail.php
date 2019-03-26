<?php
    $name = $_POST['name'];
    $email = $_POST['email'];
    $enquiry = $_POST['enquiry'];

    $message = "Hi Ash, \n";
    $message .= "You have received an enquiry from your Uncouth Studios website from " . $name . "\n";
    $message .= "Here is their message: \n";
    $message .= $enquiry;
    $message .= "\n\n";
    $message .= "You can get back to them on " . $email;
    $message .= "\n\n";
    $message .= "Thank you";

    $message = wordwrap($message, 70);

    $message = stripslashes(mb_convert_encoding( $message, "HTML-ENTITIES", "UTF-8" ));

    mail("ash.duckett@outlook.com", "Uncouth Studios", $message);
