<?php
	// declare 'events' as the active page
	$ACTIVEPAGE = 'events';
	// set the title of the page
	$title = "Events - Sabor Latino";
	
	// load necessary function files
	include_once "Logic/displayfunctions.php";
    include_once "Logic/calendar.php";
	
	// include the page header
	// load events.css
	createHeader($title, "events.css");
	
	// add title
	?>
	<h1>Events</h1>
	<?php
	
	// include the menubar
	createMenubar($ACTIVEPAGE);
	
	//main page content
	?>
		<div class="content">
			<?php
                $eventsString = displayCalendarEvents();
                echo $eventsString;
                
				// generate calendar of events
				// retrieve list of future and past events from database
				// list performers from each event
				// loop through events in chronological order to display event calendar
				// upcoming events are listed first, separately from past events
				// display list of performers under each event
				// display link to videos associated with event
			?>
			<!-- begin filler
			<h2>Upcoming Events</h2>
			<ul>
				<li>Date - Showcase</li>
				<li>Date - Showcase</li>
				<li>Date - Showcase</li>
				<li>Date - Showcase</li>
			</ul>
			<h2>Past Events</h2>
			<ul>
				<li>Date - Showcase</li>
				<li>Date - Showcase</li>
				<li>Date - Showcase</li>
				<li>Date - Showcase</li>
				<li>Date - Showcase</li>
				<li>Date - Showcase</li>
			</ul>
			end filler -->
		</div>
		
	<?php
	
	//include the page footer
	createFooter();
	
?>
