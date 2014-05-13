<?php
	// declare 'contact' as the active page
	$ACTIVEPAGE = 'contact';
	// set the title of the page
	$title = "Contact - Sabor Latino";
	
	// load necessary function files
	include_once "displayfunctions.php";
	// include_once "contactForm.php"; 		will uncomment when file is fixed
	
	// process the email if the form has been submitted
	// uncomment line below when function is complete
	// collectInputs();
	
	// include the page header
	// load contact.css
	createHeader($title, "contact.css");
	
	// add a title
	?>
	<h1>Contact Us</h1>
	<?php
	
	// include the menubar
	createMenubar($ACTIVEPAGE);
	?>
	<!-- Add contact form box-->
	<div class='content'>
        <div id="contact">
		<h2>Contact Sabor Latino</h2>
            <form method="post" action="contactForm.php">
                <label for="category">Concerning: </label><select name="category"> 
                    <option value="general" selected>General</option> 
                    <option value="performance">Request a Performance</option> 
                    <option value="other">Other</option> 
                    </select> <br>
                <label for"sender">From: </label><input type="text" id="from" name="from" placeholder="Enter Your Full Name"><br>
                <label for="subject">Subject: </label><input type="text" id="subject" name="subject" placeholder="Your Specific Inquiry"><br>
                <label for="message">Message: </label><br>
                <textarea id="message" name="message" rows="10" cols="100" placeholder="Type Message Here"></textarea><br><br>
            <input id="send" name="send" type="submit" value="Send"><input type="reset" value="Clear">
            </form>
        </div>
	</div>
	<?php
	//include the page footer
	createFooter();
	
?>