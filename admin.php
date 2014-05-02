<?php
	// declare 'admin' as the active page
	$ACTIVEPAGE = 'admin';
	// set the title of the page
	$title = "Administration - Sabor Latino";
	
	// load necessary function files
	include_once "displayfunctions.php";
	// include_once loginCode.php;		will uncomment when file is repaired
	// include_once calendar.php;		will uncomment when file is repaired
	// include_once "adders.php"; 		will uncomment when file is repaired
	// include_once "getters.php"; 		will uncomment when file is repaired
	// include_once "modifiers.php"; 	will uncomment when file is repaired
	
	// if a request was sent via form below
	// 		validate request inputs
	//		if inputs are valid, modify database accordingly
	//		else, generate error and allow admin to correct mistakes
	
	
	// include the page header
	// load admin.css
	createHeader($title, "admin.css");
	
	// add title
	?>
	<h1>Administration</h1>
	<?php
	
	// include the menubar
	createMenubar($ACTIVEPAGE);
	
	// add form
	?>
	<div class="content">
		<?php
			/* generate administration form
			 * create form that has options to add/delete/modify members,
			 * events, and videos
			 * on submission, page validates entry and reloads admin.php for processing
			 */

            /**Page must react to when choice has been made to add/delete/modify an event.
             * First, check when the page loads, if the event form was submitted.
             * If it was, then call either addNewCalendarEvent(), deleteCalendarEvent(...), or modifyCalendarEvent(...).
             * Which one is called is dependent on whether user chose to add, delete, or modify a calendar event. Error message
             * will be displayed if any of these function calls went wrong */

            /**Also must react to request to add/delete/modify members or videos
             * First, check if the video or member form was submitted.
             * There are several helper functions in getters.php, adders.php, and modifiers.php that deal with adding/modifying the 
             * videos/members. Call the appropriate one based on which option the admin chose. Also, call a delete video or delete member function 
             * if that option was chosen. The skeletons for these two functions have not been written yet, but they will basically run a query
             * to delete the chosen member/video.
             * */
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
