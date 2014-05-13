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
		<h2>Contact Sabor Latino</h2>
            <form method="post" action="contactForm.php">
                <label>To:</label><select name="to"> 
                    <option value="1" selected>Sabor Latino General</option> 
                    <option value="2">Choregrapher</option> 
                    <option value="3">Scheduling Team</option> 
                    </select> <br>
                <label>From:</label><input name="from" placeholder="Insert First and Last Name Here"><br>
                <label>Subject:</label><input name="subject" placeholder="Type of Inquiry Here"><br>
                <label>Message:</label><br>
                <textarea name="message" rows="10" cols="100" placeholder="Type Message Here"></textarea><br><br>
            <input id="send" name="send" type="submit" value="Send"><input type="reset" value="Clear">
        </form>
	</div>
	<?php
	//include the page footer
	createFooter();
	
?>