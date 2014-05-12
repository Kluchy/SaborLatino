<?php
/** Karl
	  *@calling currentDate, defaultEndDate
	  *@spec retrieves and validates admin input
	  *@spec prepares input for DB submission
	  *@return associative array of values to insert to DB
	  *TODO behavior/logic when an input is missing
	  */
	function formatMemberInput() {
	    $memberInfo= array();
	    if ( isset( $_POST["firstName"] ) ) {
                $memberInfo["firstName"]= $_POST["firstName"];//cannot be null DB will complain
            }
            if ( isset( $_POST["lastName"] ) ) {
                $memberInfo["lastName"]= $_POST["lastName"];//cannot be null DB will complain
            }
            if ( isset( $_POST["year"] ) ) {
                $memberInfo["year"]= $_POST["year"];
            }
            if ( isset( $_POST["bio"] ) ) {
                $memberInfo["bio"]= $_POST["bio"];
            }
            if ( isset( $_POST["email"] )  ) {
                $memberInfo["email"]= $_POST["email"];
            }
            if ( isset( $_POST["phone"] ) ) {
                $memberInfo["phone"]= $_POST["phone"];
            }
            if ( isset( $_POST["state"] ) ) {
                $memberInfo["state"]= $_POST["state"];
            }
            if ( isset( $_POST["country"] ) ) {
                $memberInfo["country"]= $_POST["country"];
            }
            if ( isset( $_POST["city"] ) ) {
                $memberInfo["city"]= $_POST["city"];
            }
            //will never be null [positonID]
            $memberInfo["positionID"]= $_POST["positionID"];
            
            if ( isset( $_POST["startDate"] ) ) {
                $memberInfo["startDate"]= $_POST["startDate"];
            } else {
                $memberInfo["startDate"]= currentDate();
            }
            if ( isset( $_POST["endDate"] ) ) {
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
    
    /** Karl
      *@spec process, validate and format user input
      *@return associative array of values in proper format for DB submission
      *@caller currentDate
      */
    function formatPerformanceInput() {
        $performanceInfo= array();
        if ( $_POST["performanceTitle"] ) {
            $performanceInfo["performancetitle"]= $_POST["performanceTitle"];
        }
        if ( $_POST["performanceLocation"] ) {
            $performanceInfo["performanceLocation"]= $_POST["performanceLocation"];
        } 
         if ( $_POST["performanceDate"] ) {
            $performanceInfo["performanceDate"]= $_POST["performanceDate"];
        } else {
            $performanceInfo["performanceDate"]= currentDate();
        }
        return $performanceInfo; 
    }
    
    /** Karl
      *@spec process, validate and format user input
      *@return associative array  of values in proper format for DB submission
      */
    function formatGenreInput() {
        $genreInfo= array();
        if ( $_POST["genreName"] ) {
            $genreInfo["genreName"]= $_POST["genreName"];
        }
        return $genreInfo; 
    }
    
    /** Karl
      *@spec process, validate and format user input
      *@return associative array  of values in proper format for DB submission
      */
    function formatPositionInput() {
        $positionInfo= array();
        if ( $_POST["position"] ) {
            $positionInfo["position"]= $_POST["position"];
        }
        return $positionInfo; 
    }
    
    /** Karl
      *@spec process, validate and format user input
      *@return associative array  of values in proper format for DB submission
      */
    function formatPictureInput($photoName) { 
        $pictureInfo= array();
        $dir= "http://info230.cs.cornell.edu/users/skemab/www/Sabor/SaborLatino/img/";

        $pictureInfo["urlP"]= $dir.$photoName;
        if ( $_POST["captionP"] ) {
            $pictureInfo["captionP"]= $_POST["captionP"];
        }
        if ( $_POST["performanceID"] ) {
            $pictureInfo["performanceID"]=  $_POST["performanceID"];
        }
        if ( $_POST["memberID"] ) {
            $pictureInfo["memberID"]= $_POST["memberID"];
        }
        return $pictureInfo;
    }
?>