<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
	// declare 'home' as the active page
	$ACTIVEPAGE = 'home';
	// set the title of the page
	$title = "Sabor Latino";
	
	// load necessary function files
	include_once "displayfunctions.php";
	
	// include the page header
	// load home.css
	createHeader($title, "home.css");
	
	// include the menubar
	createMenubar($ACTIVEPAGE);
	
	//include the page footer
	createFooter();
	
?>