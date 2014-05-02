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
		<?php
			// insert contact form
			// form with subject and message fields
			// send button
		?>
		<!--begin filler-->
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam a augue id tortor euismod dignissim. Fusce ipsum urna, volutpat ac mi et, gravida iaculis elit. Nulla venenatis faucibus nulla in mattis. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nam viverra consequat feugiat. Duis turpis nulla, hendrerit quis porta vitae, ornare eu orci. Cras dictum erat justo, vitae vehicula ante tempor eu. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas id leo condimentum, varius nibh et, tristique nunc. Donec fringilla porttitor neque blandit feugiat. Donec tempor sapien quam, ac sollicitudin mauris tempus eu. Sed dictum odio eget velit placerat, vitae tincidunt eros lobortis. Sed sit amet luctus sapien.</p>

		<p>Etiam facilisis et nisi eget mattis. Mauris et odio varius, euismod leo egestas, aliquam urna. Nulla luctus nulla ac tellus bibendum cursus. Morbi magna odio, aliquam ac laoreet sed, porta eget leo. Maecenas ullamcorper, erat porta bibendum euismod, ipsum justo dictum augue, a lacinia ipsum magna et leo. Aliquam at vulputate felis, ut venenatis massa. Etiam convallis, leo ornare pellentesque scelerisque, nisi risus pulvinar nisl, ut laoreet metus magna sit amet augue. Suspendisse vehicula quis augue tristique consectetur. Pellentesque lobortis erat nec eros elementum, ac hendrerit lorem egestas. In hac habitasse platea dictumst. Sed venenatis ac nunc in venenatis.</p>
		<!--end filler-->
	</div>
	<?php
	//include the page footer
	createFooter();
	
?>