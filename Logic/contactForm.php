<?php
    require_once('config.php');
?>

<?php

/**
 * Collects inputs to fields from contact form and sends appropriate email.
 * @param None
 * @return boolean -> true or false - true if email was success, false otherwise
 * @calling Display logic helper functions
 * @caller contact form PHP page
 * @spec None */
function collectInputs() {

    $to = SABOR_EMAIL; //SABOR_EMAIL will be a defined constant in another file.
    $from = $_POST["from"];
    $subject = "From contact form: ".$category.$_POST["subject"];
    $message = $_POST["message"];
    mail("EMAIL", $subject, $message);
//    if($success) {
//        //echo "<p>Thank you for reaching out! Sabor Latino will try to respond to your inquiry as soon as possible.</p>";
//    }
//    else {
//        //echo "<p>Oh no! Looks like something went wrong. Please try again.</p>";
//    }

}
?>
