<?php
    require_once('config.php');
?>
<?php

/** Derek
 * Function that can be placed at the top of a page to ensure one is logged in as an administator.
 * @param None
 * @return None
 * @Caller Any page that needs a login confirmation in order for the page to be viewed.
 */
function ensureLogin() {
    session_start();
    if(!isset($_SESSION['saborAdmin'])) {
        //Display a 'You are not logged in message'
        //Also, display a button that is part of a form that will redirect you to login page so you can access the current page.
        exit(); //Makes it so that if you are not logged in, then the page stops rendering/loading.
    }
}


/** Derek
 * Attempts to log in as administrator.
 * @param None
 * @return None
 * */
function adminLogin() {
    if(isset($_POST['username'] && isset($_POST['password'])) {
         attemptLogin(htmlentities($_POST['username']), htmlentities($_POST['password']));
    }
}
?>
