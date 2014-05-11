<?php
	// declare 'about' as the active page
	$ACTIVEPAGE = 'about';
	// set the title of the page
	$title = "About - Sabor Latino";
	
	// load necessary function files
	include_once "displayfunctions.php";
	
	// include the page header
	// load about.css
	createHeader($title, "about.css");
	
	// create a title
	?>
	<h1>About Sabor Latino</h1>
	<?php
	
	// include the menubar
	createMenubar($ACTIVEPAGE);
	
	?>

	<div class="content">
		<!-- Need to add about content here -->
	</div>
	<?php
	
	//include the page footer
	createFooter();
	
?>
