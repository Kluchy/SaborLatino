<?php
	session_start();
	// declare 'contact' as the active page
	$ACTIVEPAGE = 'contact';
	// set the title of the page
	$title = "Contact - Sabor Latino";
	
	// load necessary function files
	include_once "displayfunctions.php";
	include_once "contactForm.php";
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
			<?php
				//send email if submitted
				if ( isset( $_POST['send'] ) ){
					collectInputs();
				}
			?>
            <form method="post" action="contact.php">
                <label for="category">What is this concerning?</label><div id="dropdown"><select id="category" name="category"> 
                    <option value="general" selected>General</option> 
                    <option value="performance">Request a Performance</option> 
                    <option value="other">Other</option> 
                    </select> </div><br>
               <input type="text" id="from" name="from" placeholder="Enter Your Full Name"><br><br>
			   <input type="email" id="email" name="email" placeholder="Enter Your Email Address"><br><br>
               <input type="text" id="subject" name="subject" placeholder="Your Specific Inquiry"><br><br>
                <textarea id="message" name="message" rows="10" cols="30" placeholder="Type Message Here"></textarea><br><br>
            <input id="send" name="send" type="submit" value="Send"><br>
                <input id="reset" type="reset" value="Clear">
            </form>
        </div>
	</div>
	<?php
	//include the page footer
	createFooter();
	
?>