<?php
        session_start();
	// declare 'admin' as the active page
	$ACTIVEPAGE = 'admin';
	// set the title of the page
	$title = "Administration - Sabor Latino";
	
	// load necessary function files
	include_once "displayfunctions.php";
	include_once "loginCode.php";
	// include_once calendar.php;		will uncomment when file is repaired
	include_once "../Database/adders.php";
	include_once "../Database/getters.php";
	//include_once "modifiers.php"; 	will uncomment when file is repaired
	
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
             addMemberForm();
             addVideoForm();
		?>
	</div>
	<?php
	
	//include the page footer
	createFooter();
	
	/** Karl
	  *@calling currentDate, defaultEndDate
	  *@spec retrieves and validates admin input
	  *@spec prepares input for DB submission
	  *@return associative array of values to insert to DB
	  *TODO behavior/logic when an input is missing
	  */
	function formatMemberInput() {
	    $memberInfo= array();
	    if ( $_POST["firstName"] ) {
                $memberInfo["firstName"]= $_POST["firstName"];//cannot be null DB will complain
            }
            if ( $_POST["lastName"] ) {
                $memberInfo["lastName"]= $_POST["lastName"];//cannot be null DB will complain
            }
            if ( $_POST["year"] ) {
                $memberInfo["year"]= $_POST["year"];
            }
            if ( $_POST["bio"] ) {
                $memberInfo["bio"]= $_POST["bio"];
            }
            if ( $_POST["email"]  ) {
                $memberInfo["email"]= $_POST["email"];
            }
            if ( $_POST["phone"] ) {
                $memberInfo["phone"]= $_POST["phone"];
            }
            if ( $_POST["state"] ) {
                $memberInfo["state"]= $_POST["state"];
            }
            if ( $_POST["country"] ) {
                $memberInfo["country"]= $_POST["country"];
            }
            if ( $_POST["city"] ) {
                $memberInfo["city"]= $_POST["city"];
            }
            //will never be null [positonID]
            $memberInfo["positionID"]= $_POST["positionID"];
            
            if ( $_POST["startDate"] ) {
                $memberInfo["startDate"]= $_POST["startDate"];
            } else {
                $memberInfo["startDate"]= currentDate();
            }
            if ( $_POST["endDate"] ) {
                $memberInfo["endDate"]= $_POST["endDate"];
            } else {
                //default end date is a year from current date.
                $memberInfo["endDate"]= defaultEndDate();
            }
            return $memberInfo;
	}
	
	/** Karl
	  *@calling getPositions
	  *@spec displays the "Add Member" section of the Admin Page
	  */
	function addMemberForm() {
        ?>
        <form action="admin.php" method="post">
          <h1>Add a new member to the group</h1>
          <br>
        
          First Name <input type="text" name="firstName">
          <br>
          Last Name <input type="text" name="lastName">
          <br>
          Class Year <input type="text" name="year"> (yyyy)
          <br>
          Bio <textarea name="bio"> Enter a short biography here </textarea>
          <br>
        
          E-Mail <input type="text" name="email">
          <br>
          Phone <input type="text" name="phone"> (9 digits e.g:1234567890)
          <br>
          Country of Residence <input type="text" name="country">
          <br>
          State <input type="text" name="state"> (if U.S. e.g: NY, NJ)
          <br>
          City <input type="text" name="city">
          <br>
        
        If you wish, add one position this member has held or is currently holding.
        If this person can be associated with more than one role, you may add the
        others by using the Update Form.
          
          <br>
          Position <select name="positionID">
        <?php
            $res= getPositions();
            $positions= $res[0];
            $error= $res[1];
            $options= "";
            if ( $error ) {
                echo "$error";
                exit();
            }
            foreach( $positions as $record ) {
                $id= $record["idPositions"];
                $name= $record["position"];
                $options= $options."<option value=$id> $name </option>";
            }
            print($options);
        ?>
        </select>
          <br>
          Start Date <input type="text" name="startDate"> (yyy-mm-dd)
          <br>
          If this is not a role currently undertaken by this person, enter
          an end date below:
          <br>
          End Date <input type="text" name="endDate"> (yyyy-mm-dd)
          <br>
          <input type="submit" name="addMember" value="Add Member">
        
        <br><br><br>
        </form>
        <?php
    }
    
    /** Karl
      *@calling getGenres, getPerformances
      *@spec displays the "addVideo" section of the Admin Page
      */
    function addVideoForm() {
        ?>
        <form action="admin.php" method="post">
         <h1> Add a new Video </h1>
         <br>
         Paste a link to the video here:
         <input type="text" name="urlV">
         <br>
         Add a short description for this video:
         <input type="text" name="captionV">
         <br>
         Dance genre depicted in video:
         <br>
         <select name="genreID">
         <?php
         $res= getGenres();
         $genres= $res[0];
         $error= $res[1];
         $options= "";
         if ( $error ) {
             echo "$error";
             exit();
         }
         foreach ( $genres as $genre ) {
             $id= $genre["idGenres"];
             $name= $genre["genreName"];    
             $options= $options."<option value=$id> $name </option>"; 
         }
         print($options);
         ?>
         </select>
         <br>
         Link this video to a Sabor performance:
         <br>
         <select name="performanceID">
         <?php
         $res= getPerformances();
         $performances= $res[0];
         $error= $res[1];
         $options="";
         if ( $error ) {
             echo "$error";
             exit();
         }
         foreach( $performances as $performance ) {
            $id= $performance["idPerformances"];
            $title= $performance["performanceTitle"];
            $location= $performance["performanceLocation"];
            $date= $performance["performanceDate"];
            $options= $options."<option value=$id> $title - $location - $date </option>";
         }
         print($options);
         ?>
         </select>
         <input type="submit" name="addVideo" value="Add Video">
         
         <br><br><br>
        </form>
        <?php
    }
    
    /** Karl
      *@spec processes/validates user input
      *@spec prepares data for DB submission
      *@return associative array of values to insert
      */
    function formatVideoInput() {
	    $videoInfo= array();
	    if (  $_POST["urlV"] ) {
	       $videoInfo["urlV"]= $_POST["urlV"];
	   }
	   if (  $_POST["captionV"] ) {
	       $videoInfo["captionV"]= $_POST["captionV"];
	   }
	   //will never be null
	   $videoInfo["genreID"]= $_POST["genreID"];
	   $videoInfo["performanceID"]= $_POST["performanceID"];
	   return $videoInfo;
    }
?>
