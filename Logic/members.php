<?php
	// declare 'members' as the active page
	$ACTIVEPAGE = 'members';
	// set the title of the page
	$title = "Members - Sabor Latino";
	
	// load necessary function files
	include_once "displayfunctions.php";
	// include_once "getters.php";		will uncomment when file is repaired
	include_once "membersFunctions.php";		//will uncomment when file is repaired
	
	// include the page header
	// load members.css
	createHeader($title, "members.css");
	
	// create a title
	?>
	<h1>Ensemble Members</h1>
	<?php
	
	// include the menubar
	createMenubar($ACTIVEPAGE);
	
	?>
    <script src = "JavaScript/jquery-1.11.1.min.js"></script>

	<div class="content">
		<?php
			/* create list of officers and members
			 * php code for this functionality may be stored in separate file
			 * officers are listed first under heading
			 * general members are listed afterwards
			 *
			 *
			 * request list of officers, positions and bios
			 *		(via appropriate getter function)
			 * display list of officers and their positions
			 * names have expandable boxes for bios
			 * (if name is clicked reload page with bio expanded for clicked name)
			 * 
			 * request list of choreographers and bios
			 *		(via appropriate getter function)
			 * display list of choreographers
			 * names have expandable boxes for bios
			 * (if name is clicked reload page with bio expanded for clicked name)
			 *
			 * request list of non-officer members and bios
			 *		(via appropriate getter function)
			 * display list of general members
			 * names have expandable boxes for bios
			 * (if name is clicked reload page with bio expanded for clicked name)
			 * 
			 * displayMembers();
			 */
			 groupMembers();
		?>
	</div>
	<?php
	
	//include the page footer
	createFooter();
	
?>
