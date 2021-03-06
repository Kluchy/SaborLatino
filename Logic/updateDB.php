<?php
	
	// load necessary function files
	include_once "displayfunctions.php";
	include_once "loginCode.php";
	include_once "updateForms.php";
	include_once "checkinput.php";
	// include_once calendar.php;		will uncomment when file is repaired
	include_once "../Database/adders.php";
	include_once "../Database/getters.php";
	include_once "../Database/modifiers.php";
	
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
             //process addMember
             /*if ( isset( $_POST["updateMember"] ) ) {
                    //format input
                   $memberInfo= formatMemberInput();
                    //make DB call
                    $error= addMember($memberInfo);
                    //check for error
                    if ( $error ) {
                        echo "$error";
                    } else {
                        echo "Sucessfully added new member<br>";    
                    }
             }
             //process addVideo
             elseif ( isset( $_POST["addVideo"] ) ) {
                 //format input
                 $videoInfo= formatVideoInput();
                 //make DB call
                 $error= addVideo($videoInfo);
                 //check for error
                 if ( $error ) {
                     echo "$error";
                } else {
                    echo "Succesfully added new video<br>";
                }
             }*/
    function updateDB() {
             //process addPerformance
             if ( isset( $_POST["updatePerf"] ) ) {
                 updatePerformancesActionForm($_POST["performanceSelect"]);
             }
             elseif(isset($_POST["updateGen"])) {
                 updateGenreActionForm($_POST["genreSelect"]);
             }
             elseif(isset($_POST["updatePos"])) {
                 updatePositionActionForm($_POST["positionSelect"]);
             }
             elseif(isset($_POST["updatePic"])) {
                 updatePictureActionForm($_POST["pictureSelect"]);
             }
             else {

                //display  add forms
                 //updateMemberForm();
                 //updateVideoForm();
                 updatePerformanceForm();
                 updateGenreForm();
                 updatePositionForm();
                 updatePictureForm();
             }
                   
            
        }
		?>
	<?php
	
	
?>
