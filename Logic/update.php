<?php
        session_start();
	// declare 'admin' as the active page
	$ACTIVEPAGE = 'admin';
	// set the title of the page
	$title = "Administration - Sabor Latino";
	
	// load necessary function files
	include_once "displayfunctions.php";
	include_once "loginCode.php";
	include_once "updateForms.php";
	include_once "checkinput.php";
    include_once "checkDeletes.php";
    include_once "updateDB.php";

	// include_once calendar.php;		will uncomment when file is repaired
	include_once "../Database/adders.php";
	include_once "../Database/getters.php";
	include_once "../Database/modifiers.php";
	
	// if a request was sent via form below
	// 		validate request inputs
	//		if inputs are valid, modify database accordingly
	//		else, generate error and allow admin to correct mistakes
	
	
	// include the page header
	// load admin.css
	createHeader($title, "add.css");
	
	// add title
	?>
	<h1> <a href="admin.php"> Admin > </a> Update </h1>
	<?php
	
	// include the menubar
	createMenubar($ACTIVEPAGE);
	//check if logging out
	if ( isset( $_POST["logout"] ) ) {
	    $msg= logout();
	    echo "$msg";
	}
	//check login
	adminLogin();
	ensureLogin(); //displays login form if not logged in
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
             //process addMember
             if ( isset( $_POST["addMember"] ) ) {
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
             }
             //process addPerformance
             elseif ( isset( $_POST["addPerformance"] ) ) {
                 //format input
                 $performanceInfo= formatPerformanceInput();
                 //make DB call
                 $error= addPerformance( $performanceInfo );
                 //check for error
                if ( $error ) {
                    echo "$error";
                } else {
                    echo "Successfully added new performance<br>";
                }
             }
             //process addGenre
             elseif ( isset( $_POST["addGenre"] ) ) {
                 //format input
                 $genreInfo= formatGenreInput();
                 //make a DB call
                 $error= addGenre( $genreInfo );
                 //check for error
                 if ( $error ) {
                     echo "$error";
                 } else {
                     echo "Successfully added new genre<br>";
                 }
            }
            //process addPosition
            elseif ( isset( $_POST["addPosition"] ) ) {
                //format input
                $positionInfo= formatPositionInput();
                //make DB call
                $error= addPosition( $positionInfo );
                //check for error
                if ( $error ) {
                    echo "$error";
                } else {
                    echo "Successfully added a new position<br>";
                }
            }
            //process addPicture (TODO)
            elseif ( isset( $_POST["addPicture"] ) ) {
                //format input
                if ($_FILES["file"]["error"] > 0) {
                    $error= $_FILES["file"]["error"] ;
                    echo "$error<br>";
                    exit();
                } else {
                    $photoName= $_FILES["file"]["name"];
                    $tempLocation= $_FILES["file"]["tmp_name"];
                    //echo "$photoName<br>";
                    //echo "$tempLocation<br>";'
                    $pictureInfo= formatPictureInput($photoName);
                    if ($_POST["memberID"]) {
                        $error= storePicture( $tempLocation, $photoName, $pictureInfo, 1 );
                    } else {
                        $error= storePicture( $tempLocation, $photoName, $pictureInfo, 0 );
                    }
                    if ( $error ) {
                        echo "$error";
                    } else {
                        echo "Successfully added picture<br>";
                    }
                }   
            }

             if ( isset( $_POST["updatePerformance"] ) ) {
                 //format input
                 $performanceInfo= formatPerformanceInput();
                 $dbInfo = $performanceInfo[0];
                 $id = $_POST['hidden'];

                 if (isset($dbInfo["performancetitle"])) {
                     //make DB call
                     $error= updatePerfInfo($id,$dbInfo );
                 }
                 //check for error
                if ( $error ) {
                    echo "$error";
                } else {
                    //Allows you to access Google Calendar API.
                    $user = 'saborlatinoeventscal@gmail.com';
                    $pass = 'skemabsabor';
                    $service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME; // predefined service name for calendar
                    $id = $_POST['hidden'];

                    $client = Zend_Gdata_ClientLogin::getHttpClient($user,$pass,$service);
                    //modifyCalendarEvent($performanceInfo[1], $client, $id);

                    echo "Successfully modified performance<br>";
                }
             }
             elseif(isset($_POST['updateGenre'])) {
                    $genreInfo = formatGenreInput();
                    $id = $_POST['hidden'];
                    if(isset($genreInfo["genreName"])) {
                        $error = updateGenreInfo($id, $genreInfo);

                    }
                    if ( $error ) {
                        echo "$error";
                    } else {
                        echo "Successfully modified genre";
                }
            }
            elseif(isset($_POST['updatePosition'])) {
                    $positionInfo = formatPositionInput();
                    $id = $_POST['hidden'];
                    if(isset($positionInfo["position"])) {
                        $error = updatePosition($id, $positionInfo);

                    }
                    if ( $error ) {
                        echo "$error";
                    } else {
                        echo "Successfully modified position";
                }
            }
            elseif(isset($_POST['updatePicture'])) {
                //format input
                if ($_FILES["file"]["error"] > 0) {
                    $error= $_FILES["file"]["error"] ;
                    echo "Error uploading picture: $error<br>";
                } else {
                    $photoName= $_FILES["file"]["name"];
                    $tempLocation= $_FILES["file"]["tmp_name"];
                    //echo "$photoName<br>";
                    //echo "$tempLocation<br>";'
                    $pictureInfo= formatPictureInput($photoName);
                    if ( isset( $pictureInfo["memberID"] ) ) {
                        $error= storePictureUpdate( $tempLocation, $photoName, $pictureInfo, 1 );
                    } else {
                        $error= storePictureUpdate( $tempLocation, $photoName, $pictureInfo, 0 );
                    }
                    if ( $error ) {
                        echo "$error";
                    } else {
                        echo "Successfully modified picture<br>";
                    }

            }
        }

            //Check deletes
            checkDeletes();        
            //Checks DB updates
            updateDB();

		?>
	</div>
	<?php
	
	//include the page footer, if not set
	if ( isset( $_SESSION["saborAdmin"] ) ) {
	   createFooter();
	}
	
	
?>
