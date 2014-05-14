<?php
	session_start();
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
        <img src="../img/saborgroup.jpg" alt="group photo" height="400" width="600"><br>
        Founded in 1992, Sabor Latino Dance Ensemble strives to educate the Cornell and surrounding Ithaca community about Latino culture through music, dance, and visual arts. We are the first Latino dance troupe on Cornell University's campus and represent our Latin American and Caribbean roots through dances such as Merengue, Bachata, and Cumbia as well as our ties to our experience as Latinos in the U.S. through dances such as Salsa, Latin-Jazz, Latin Hip-Hop, Reggaeton, and Latino House. Through our annual concert, dance workshops, and community service, we present the significance of music and dance in our Latino cultures.

	</div>
	<?php
	
	//include the page footer
	createFooter();
	
?>
