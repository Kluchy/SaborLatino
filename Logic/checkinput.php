<?php
include_once "../Database/helpers.php";
/** Karl
	  *@calling currentDate, defaultEndDate, validateText, validateDate, validatePhone
	  *@spec retrieves and validates admin input. If input missing, skips over it
	  *@spec prepares input for DB submission
	  *@return associative array of values to insert to DB
	  *@note validate incorporated + tested each field individually (except state/country etc because same as firstName)
	  */
	function formatMemberInput() {
	    $memberInfo= array();
	    if ( validateText( $_POST["firstName"] ) ) {
                $memberInfo["firstName"]= $_POST["firstName"];//cannot be null DB will complain
            }
            if ( validateText( $_POST["lastName"] ) ) {
                $memberInfo["lastName"]= $_POST["lastName"];//cannot be null DB will complain
            }
            if ( validateDate( $_POST["year"] ) ) {
                $memberInfo["year"]= $_POST["year"];
            }
            if ( validateText( $_POST["bio"] ) ) {
                $memberInfo["bio"]= $_POST["bio"];
            }
            if ( validateEmail( $_POST["email"] )  ) {
                $memberInfo["email"]= $_POST["email"];
            }
            if ( validatePhone( $_POST["phone"] ) ) {
                $memberInfo["phone"]= $_POST["phone"];
            }
            if ( validateText( $_POST["state"] ) ) {
                $memberInfo["state"]= $_POST["state"];
            }
            if ( validateText( $_POST["country"] ) ) {
                $memberInfo["country"]= $_POST["country"];
            }
            if ( validateText( $_POST["city"] ) ) {
                $memberInfo["city"]= $_POST["city"];
            }
            //will never be null [positonID]
            $memberInfo["positionID"]= $_POST["positionID"];
            
            if ( validateDate( $_POST["startDate"] ) ) {
                $memberInfo["startDate"]= $_POST["startDate"];
            } else {
                $memberInfo["startDate"]= currentDate();
            }
            if ( validateDate( $_POST["endDate"] ) ) {
                $memberInfo["endDate"]= $_POST["endDate"];
            } else {
                //default end date is a year from current date.
                $memberInfo["endDate"]= defaultEndDate();
            }
            return $memberInfo;
	}
    
    /** Karl
      *@spec processes/validates user input
      *@spec prepares data for DB submission
      *@return associative array of values to insert
      *@calling validateUrl, validateText
      *@note validation incorporated + tested each individual field
      */
    function formatVideoInput() {
	    $videoInfo= array();
	    if (  validateUrl( $_POST["urlV"] ) ) {
	       $videoInfo["urlV"]= $_POST["urlV"];
	   }
	   if (  validateText( $_POST["captionV"] ) ) {
	       $videoInfo["captionV"]= $_POST["captionV"];
	   }
	   //will never be null
	   $videoInfo["genreID"]= $_POST["genreID"];
	   $videoInfo["performanceID"]= $_POST["performanceID"];
	   return $videoInfo;
    }
    
    /** Karl
      *@spec process, validate and format user input
      *@return associative array of values in proper format for DB submission. Returns two arrays. One for usage in query and the other 
      only for adding to calendar.
      *@calling currentDate, validateText, validateDate
      *@note incorporated validation BUT Derek's google calendar code is pushing a Fatal Error
      */
    function formatPerformanceInput() {
        $performanceInfo= array();
        if ( validateText( $_POST["performanceTitle"] ) ) {
            $performanceInfo["performancetitle"]= $_POST["performanceTitle"];
        }
        if ( validateText( $_POST["performanceLocation"] ) ) {
            $performanceInfo["performanceLocation"]= $_POST["performanceLocation"];
        } 
        else {
			echo "HELLO";
            $performanceInfo["performanceLocation"] = "Unknown";
        }
         if ( validateDate( $_POST["performanceDate"] ) ) {
            $performanceInfo["performanceDate"]= $_POST["performanceDate"];
        } else {
            $performanceInfo["performanceDate"]= currentDate();
        }

        $calInfo = $performanceInfo;
        $perfInfo[0] = $performanceInfo;

        $startHour = $_POST['startHour'];
        $endHour = $_POST['endHour'];
        $startMin = $_POST['startMinutes'];
        $endMin = $_POST['endMinutes'];
        $startAMPM = $_POST['startampm'];
        $endAMPM = $_POST['endampm'];

        if($startAMPM == "PM" && $startHour != "12") {
            $newTint = intval($startHour) + 12;
            $startHour = strval($newTint); 
        }
        elseif($startAMPM == "AM" && $startHour == "12") {
            $startHour = "00";
        }

        if($endAMPM == "PM" && $endHour != "12") {
            $newTint = intval($endHour) + 12;
            $endHour = strval($newTint); 
        }
        elseif($endAMPM == "AM" && $endHour == "12") {
            $endHour = "00";
        }
        $calInfo["startTime"] = $startHour.":".$startMin;
        $calInfo["endTime"] = $endHour.":".$endMin;
        $perfInfo[1] = $calInfo;
        return $perfInfo; 
    }
    
    /** Karl
      *@spec process, validate and format user input
      *@return associative array  of values in proper format for DB submission
      *@note incorporated validation + tested field
      */
    function formatGenreInput() {
        $genreInfo= array();
        if ( validateText( $_POST["genreName"] ) ) {
            $genreInfo["genreName"]= $_POST["genreName"];
        }
        return $genreInfo; 
    }
    
    /** Karl
      *@spec process, validate and format user input
      *@return associative array  of values in proper format for DB submission
      *@note incorporated validation + tested field
      */
    function formatPositionInput() {
        $positionInfo= array();
        if ( validateText( $_POST["position"] ) ) {
            $positionInfo["position"]= $_POST["position"];
        }
        return $positionInfo; 
    }
    
    /** Karl
      *@spec process, validate and format user input
      *@return associative array  of values in proper format for DB submission
      *@calling validateText, validateID
      *@note incorporated validation
      */
    function formatPictureInput($photoName) { 
        $pictureInfo= array();


        if ( validateText( $_POST["captionP"] ) ) {
            $pictureInfo["captionP"]= $_POST["captionP"];
        }
        if ( validateID( $_POST["performanceID"] ) ) {
            $pictureInfo["performanceID"]=  $_POST["performanceID"];
        }
        if ( validateID( $_POST["memberID"] ) ) {
            $pictureInfo["memberID"]= $_POST["memberID"];
            $pictureInfo["urlP"]= "../img/profilePics/".$photoName;
        } else {
            $pictureInfo["urlP"]= "../img/".$photoName;
        }
        return $pictureInfo;
    }
?>
