<?php
	// declare 'videos' as the active page
	$ACTIVEPAGE = 'videos';
	// set the title of the page
	$title = "Videos - Sabor Latino";
	
	// load necessary function files
	include_once "displayfunctions.php";
	// include_once "videoSearch.php";		// will uncomment once file is debugged
	
	// include the page header
	// load videos.css
	createHeader($title, "videos.css");
	
	//create title
	?>
	<h1>Videos</h1>
	<?php
	
	// include the menubar
	createMenubar($ACTIVEPAGE);
	
	//main page body
	?>
		<div class="content">
			<div id="vidbox">
				<?php
					// load a youtube video based on GET information
					// if no set GET info, load a "default" video
					// video information retrieved from database
					// video selected from choice in vidmenu
					// display performance info underneath video
					
				?>
			</div>
			<div id="vidmenu">
				<?php
					// load clickable thumbnails as described in videoSearch.php
					// search bar will allow searching of videos by performance, etc.
					// more information found in videoSearch.php
				?>
			</div>
		</div>
	<?php
	
	//include the page footer
	createFooter();
	
?>