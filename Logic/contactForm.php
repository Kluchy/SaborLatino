<?php
include_once "..database/helpers.php";

/**
 * Collects inputs to fields from contact form and sends appropriate email.
 * @param None
 * @return boolean -> true or false - true if email was success, false otherwise
 * @calling Display logic helper functions
 * @caller contact form PHP page
 * @spec None */
function collectInputs() {
	$success = true;
	if ( isset($_POST["from"]) && validateText($_POST["from"]) ){
		$from = $_POST["from"];
	} else{
		$success = false;
	}
	if ( isset($_POST["email"]) && validateEmail($_POST["email"]) ){
		$email = $_POST["email"];
	} else{
		$success = false;
	}
	$category = $_POST['category'];
	if ( isset($_POST["subject"]) && validateText($_POST["subject"]) 
			&& isset($_POST["message"]) && validateText($_POST["message"])){
		$subject = "From contact form: ".$category.$_POST["subject"];
		$message = $from." says: ".$_POST["message"];
	} else {
	$success = false;
	}
	if($success) {
		$success = mail("kfm53@cornell.edu", $subject, $message, "From: $email");
	}
    if($success) {
       echo "<p>Thank you for reaching out! Sabor Latino will try to respond to your inquiry as soon as possible.</p>";
    }else {
        echo "<p>Oh no! Looks like something went wrong. Please try again.</p>";
    }
	
}
?>
