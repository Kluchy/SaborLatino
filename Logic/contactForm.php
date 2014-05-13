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
    $subject = $_POST["subject"];
    $message = $_POST["message"];
//	Allan: Commenting all of this out because currently generates an error
//    if(isset($_POST[/*Input field for contact 1 */])) {
//        /*Sets the subject or adds something to message depending on what the input field this is referring to. */ 
//    }
//    /*Repeat above if statement for all input fields from the contact PHP form. Required fields that are not
//     * filled will also display an error message and not allow the email to be sent. Will send you back to form page
//     * for unfilled required fields.
//     *
//
//     /* Once all variables at the top of this function have been set, the email is sent if everything went accordingly.
//      * Display a confirmation message also.
//      *
//    */
//    $success = $mail($to, $subject, $message);
//    if($success) {
//        //Display confirmation message
//    }
//    else {
//        //Tell them something went wrong and that the email did not go through.
//    }

}
?>
