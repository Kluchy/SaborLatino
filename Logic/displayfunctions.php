<?php
/* Functions for formatting pages are stored here
 */


/* Allan
 * displays the menu bar for each page
 * $ACTIVEPAGE is the current page that the user is on
 */
function createMenubar($ACTIVEPAGE){
	?>
	<div id='menubar'>
	
		<!--This header will be hidden everywhere but on the homepage -->
		<h1>Sabor Latino Dance Ensemble</h1>
		
		<!--The menubar-->
		<ul>
			<li><a href='index.php' <?php if ($ACTIVEPAGE == 'home'){echo "id='activepage'";} ?>>Home</a></li>
			<li><a href='admin.php' <?php if ($ACTIVEPAGE == 'about'){echo " id='activepage'";} ?>>About</a></li>
			<li><a href='events.php' <?php if ($ACTIVEPAGE == 'events'){echo "id='activepage'";} ?>>Events</a></li>
			<li><a href='members.php' <?php if ($ACTIVEPAGE == 'members'){echo "id='activepage'";} ?>>Members</a></li>
			<li><a href='videos.php' <?php if ($ACTIVEPAGE == 'videos'){echo "id='activepage'";} ?>>Videos</a></li>
			<li><a href='contact.php' <?php if ($ACTIVEPAGE == 'contact'){echo "id='activepage'";} ?>>Contact</a></li>
			
			<!-- Add a simple login form for administration
			<li>
				<form>...</form>
				* form has username, password, and login fields
			</li>
			-->
			
		</ul>
	</div>
	<?php
}

/* Allan
 * generates the header for a page
 * $title is the title of the page
 * $style is the filename for a specific stylesheet for the page ending in .css
 */
function createHeader($title, $style = null){
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<title><?php echo $title; ?></title>
			<link href="http://fonts.googleapis.com/css?family=Gilda+Display|Oxygen:300|Kaushan+Script" rel='stylesheet' type='text/css'>
			<link rel="stylesheet" type="text/css" href="../style/style.css">
			<?php
				//use additional stylesheet if $style is set
				if (isset($style)){
					?>
					<link rel="stylesheet" type="text/css" <?php echo "href=\"../style/$style\""; ?>>
					<?php
				}
				if ($style == "add.css") {
				    ?>
				    <script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="3ehc33g5hx8oo6w">
				    </script>
				    <?php
				}
			?>
		</head>
		<body>
	<?php
}


/* Allan
 * generates the footer for a page
 */
function createFooter(){
	?>
	</body>
	</html>
	<?php
}
?>
