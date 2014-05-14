<?php

/**
 * Collects inputs to fields from contact form and sends appropriate email.
 * @param None
 * @return boolean -> true or false - true if email was success, false otherwise
 * @calling Display logic helper functions
 * @caller contact form PHP page
 * @spec None */
function collectInputs() {
    $from = $_POST["from"];
	$category = $_POST['category'];
    $subject = "From contact form: ".$category.$_POST["subject"];
    $message = $from." says: ".$_POST["message"];
    mail("kfm53@cornell.edu", $subject, $message, "From: $from");
	/*
    if($success) {
       echo "<p>Thank you for reaching out! Sabor Latino will try to respond to your inquiry as soon as possible.</p>";
    }
    else {
        echo "<p>Oh no! Looks like something went wrong. Please try again.</p>";
    }
	*/
}
?>
