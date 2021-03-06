<?php
    require_once('../Database/config.php');
    include_once "../Database/helpers.php";
    include_once "displayfunctions.php";
?>
<?php

/** Derek
 * Function that can be placed at the top of a page to ensure one is logged in as an administator.
 * @param None
 * @return None
 * @Caller Any page that needs a login confirmation in order for the page to be viewed.
 *@caller admin.php (Karl)
 *@spec displays login form or logout form accordingly (Karl)
 */
function ensureLogin() {
    if(!isset($_SESSION['saborAdmin'])) {
        //Display a 'You are not logged in message'
        //Also, display a button that is part of a form that will redirect you to login page so you can access the current page.
        displayLogin();
		?>
		</div>
		<?php
        createFooter();
        exit(); //Makes it so that if you are not logged in, then the page stops rendering/loading.
    } else {
        displayLogout();
    }
}

/** Karl
  *@spec clear Session variables
  *@caller admin.php
  *@return logout message
  */
function logout() {
    $_SESSION['saborAdmin']= null;
    return "You have been logged out<br>";
}


/** Derek
 * Attempts to log in as administrator.
 * @param None
 * @return None
 *@caller admin.php (Karl)
 * */
function adminLogin() {
    if( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) {
         attemptLogin( htmlentities( $_POST['username'] ), htmlentities( $_POST['password'] ) );
    }
}

/** Karl
  *@spec displays login form as a div object
  *@caller ensureLogin
  */
function displayLogin() {
        ?>    
        <div class="content">
            Administrator Login
            <form action="admin.php" method="post">
            Username <input type="text" name="username"> <br>
            Password <input type="password" name="password"> <br>
            <input type="submit" name="Login" value="Login">
            </form>
        </div>
        <?php    
}

function displayLogout() {
        ?>
        <div class="content">
          <form action="admin.php" method="post">
          <input type="submit" name="logout" value="Logout">
          </form>
        </div>
        <?php
}
?>
