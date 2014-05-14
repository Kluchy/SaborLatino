<?php
    include_once "helpers.php";
?>
<?php
 
    /************************ UPDATE FUNCTIONS **************************
    /*All functions that modify (and delete) an existing entity in the database */
    
    /** Karl
      *@param query - query inserting/deleting into/from relationship set
      *@spec executes input query (must be single query)
      *@return null for success, error message otherwise
      *@note helper
      *@caller remGenreFromVideo, addGenreToVideo, addChoreographerOfVid,
                    addMemToVideo, remMemFromVideo, remChoreographerOfVid,
                    updatePerfInfo, updateGenreInfo, updatePicInfo, updatePosition,
                    deletePosition, deleteGenre, deleteVideo, deletePicture,
                    deletePerformance, deleteHistory
                    
      */
    function updateRelationship( $query ) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>";
        }
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            $err = "$mysqli->error<br>";
            $mysqli->close();
            return $err;
        }
        $mysqli->close();
        return null;
    }
    
    /******************** START VIDEO UPDATERS ***/
    
    /** Karl
      *@param genreID - genre to remove
      *@param videoID - video from which to remove it
      *@return null for success, error message otherwise
      *@spec removes relationship between given dance genre and video
      *@note  helper - use updateVidInfo instead
      *@caller updateVidInfo
      *@calling updateRelationship
      */
    function remGenreFromVideo($genreID, $videoID) {
        $query= "DELETE FROM GenresInVid 
                       WHERE genreID = $genreID
                             AND videoID = $videoID;";
        return updateRelationship( $query );
    }
    
    /** Karl
      *@param genreID - genre to add
      *@param videoID - video to add it to
      *@return null for success, error message otherwise
      *@spec adds relationship between given dance genre and video
      *@note  helper - use updateVidInfo instead
      *@caller updateVidInfo
      *@calling updateRelationship
      */
    function addGenreToVideo($genreID, $videoID) {
        $query= "INSERT INTO GenresInVid VALUES genreID = $genreID, videoID = $videoID";
        return updateRelationship( $query );          
    } 
    
    /** Karl
      *@param videoID - target video
      *@param newInfo - associative array fieldToUpdate => newValue
      *                 fieldToUpdate can be in Videos, Performances or Genres
      *@return null for success, error message otherwise
      *@spec only updates entities that already exist, returns o and error if any one query fails
      *@TODO explicitly start/end transaction?? -- do rollback on single error?
      *@calling remGenreFromVideo, addGenreToVideo
      */
    function updateVidInfo($videoID, $newInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>.";
        }
        //the fields from Videos that can be updated through admin input
        $videosSchema= array( 'urlV', 'captionV' );
        //removeGenre will cause a call to remGenreFromVideo, similarly for addGenre
        $genreSchema= array('removeGenre','addGenre');
        //update all fields based on admin input
        $videoQuery= "UPDATE Videos SET idVideos = $videoID";
        $success= 1; //to check if error occurred on addGenre or remGenre
        foreach ( $newInfo as $fieldToUpdate => $newValue ) {
            if ( in_array( $fieldToUpdate, $videosSchema ) ) {
                $videoQuery= $videoQuery.", $fieldToUpdate = \"$newValue\"";
                         
            } elseif ( $fieldToUpdate == 'removeGenre') {
                $success= remGenreFromVideo( $newValue, $videoID );
            } elseif ( $fieldToUpdate == 'addGenre' ) {
                $success= addGenreToVideo( $newValue, $videoID ); 
            }
            $videoQuery= $videoQuery." WHERE idVideos = $videoID";
            $result= $mysqli->query ( $videoQuery );
            if (!$result || !$success) {
                $mysqli->close();
                return "$mysqli->error<br>";
            }
        }
        $mysqli->close();
        return  null;
    }
    
    /** Karl
      *@param videoID - target video
      *@return null for success, error message otherwise
      *@spec deleting video should cascade deletes in GenresInVid and MembersInVid
      *@calling updateRelationship
      */
    function deleteVideo( $videoID ) {
        $query= "DELETE FROM Videos WHERE idVideos = $videoID";
        return updateRelationship( $query  );
    }
    
    /*  END VIDEO UPDATERS **************************************/
    
    /******************** START MEMBER UPDATERS ***/
    
    /** Karl
      *@param memberID - member to update
      *@param newInfo - associative array fieldToUpdate => newValue
                         fieldToUpdate can be in Members, MembersHistory or MemberContactInfo
      *@return null for success, error message otherwise
      */
    function updateMemInfo($memberID, $newInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>";
        }
        //the fields from Members that can be updated through admin input
        $membersSchema= array( 'firstName', 'lastName', 'year', 'bio', 'pictureID' );
        //the fields from MemberContactInfo that can be updated through admin input
        $contactSchema= array( 'email', 'phone', 'country', 'state', 'city' );
        //the fields from MembersHistory that can be updated through admin input
        $historySchema= array();
        
        $memberQuery= "UPDATE Members SET idMembers = $memberID";
        $contactQuery= "UPDATE MemberContactInfo SET memberID = $memberID";
        $historyQuery= "";
        if ( isset( $newInfo["idHistory"] ) ) {
            //flag for history update set: proceed with query.
            //if not, updates to hisotry cannot be made
            $historySchema= array( 'positionID', 'startDate', 'endDate' );
            $historyID= $newInfo["idHistory"];
            $historyQuery= "UPDATE MembersHistory 
                            SET idHistory = $historyID, memberID = $memberID";
        }
        //for each entry to add to the database, determine the appropriate
        //table and IDs associated with that table.
        foreach ( $newInfo as $fieldToUpdate => $newValue ) {
            if ( in_array( $fieldToUpdate, $membersSchema ) ) {
                $memberQuery= $memberQuery.", $fieldToUpdate = \"$newValue\"";
            } elseif ( in_array( $fieldToUpdate, $contactSchema ) ) {
                 $contactQuery= $contactQuery.", $fieldToUpdate = \"$newValue\"";
            } elseif ( in_array( $fieldToUpdate, $historySchema ) ) {
                if ( $fieldToUpdate == "positionID" ) {
                    $historyQuery= $historyQuery.", $fieldToUpdate = $newValue";
                } else {
                    $historyQuery= $historyQuery.", $fieldToUpdate = \"$newValue\"";
                }
            }
        }
        //Then, build the query accordingly
        $memberQuery= $memberQuery." WHERE idMembers = $memberID";
        $contactQuery= $contactQuery." WHERE memberID = $memberID";
        if ($historyQuery != "") {
            $historyQuery= $historyQuery." WHERE idHistory = $historyID;";
        }
        $multiQuery= $memberQuery.";".$contactQuery.";".$historyQuery;
        //echo "MultiQuery is: $multiQuery<br>";
                     
        $results= $mysqli->multi_query ( $multiQuery );
        $memberRes= $mysqli->store_result();
        $contactRes= $mysqli->more_results();
        $historyRes= $mysqli->more_results();//null if there was no query

        if (!$memberRes || !$contactRes || !$historyID || !$historyRes) {
            $msg= "$mysqli->error<br>";
            $mysqli->close();
            return $msg;
        }   
        $mysqli->close();
        return  null;
    }
    
    /** Karl
      *@param memberID - member whose picture we are changing
      *@param newPicID - valid picID from Pictures table 
      *@return null for success, error message otherwise
      *@spec assumes newPicID is already in Pictures table (else return 0)
      */
    function changeProfilePic($memberID, $newPicID) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>";
        }
        //check if newPicID is in database.
        $query= "SELECT * FROM Pictures WHERE idPictures = $newPicID;";
        $result= $mysqli->query ( $query );
        if ( ($result && $result->num_rows == 0) || !$result ) {
            $mysqli->close();
            return "Error: invalid picture id, or connection problem<br>";
        }
        $query= "UPDATE Members SET pictureID = $newPicID 
                 WHERE idMembers = $memberID";
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            $mysqli->close();
            return "$mysqli->error<br>";
        }
        $mysqli->close();
        return null;
    }
        
    /** Karl
      *@param memberID - target member
      *@param videoID - target video
      *@spec add a choreographing relationship between
                   target member and video
      *@return null for success, error message otherwise
      *@calling updateRelationship
      */
    function addChoreographerOfVid($memberID,$videoID) {
        $query= "INSERT INTO ChoreographersOfVid
                        VALUES memberID = $memberID,
                                       videoID = $videoID";
        return updateRelationship( $query );
    }
    
     /** Karl
      *@param memberID - choreographer to unlink from video
      *@param videoID - video to unlink from choreographer
      *@return null for success, error message otherwise
      *@spec ChoreographersOfVid: removes relationship between given member and video
      *@calling updateRelationship
      */
    function remChoreographerOfVid($memberID, $videoID) {
        $query= "DELETE FROM ChoreographersOfVid
                       WHERE memberID = $memberID
                             AND videoID = $videoID";
         return updateRelationship( $query );    
    }
    
    /** Karl
      *@param memberID - member to link to video
      *@param videoID - video to link to member
      *@return null for success, error message otherwise
      *@spec MembersInVid: adds relationship between given member and video
      *@calling updateRelationship
      */
    function addMemToVideo($memberID, $videoID) {
        $query= "INSERT INTO MembersInVid 
                        VALUES memberID = $memberID,
                                       videoID = $videoID";
        return updateRelationship( $query );
    }
    
    /** Karl
      *@param memberID - member to unlink from video
      *@param videoID - video to unlink from member
      *@return null for success, error message otherwise
      *@spec MembersInVid: removes relationship between given member and video
      *@calling updateRelationship
      */
    function remMemFromVideo($memberID, $videoID) {
        $query= "DELETE FROM MembersInVid
                       WHERE memberID = $memberID
                             AND videoID = $videoID;";
        return updateRelationship( $query );
    }
    
    /** Karl
      *@param memberID - target member
      *@return null for success, error message otherwise
      *@spec deleting member should cascade deletes in MemberContactInfo, 
             MemberHistory(?), MembersInVid
      *@calling updateRelationship
      */
    function deleteMember( $memberID ) {
        $query= "DELETE FROM Members WHERE idMembers = $memberID";
        return updateRelationship( $query );     
    }
    
    /** Karl
      *@param historyID - target history
      *@return null for success, error message otherwise
      *@spec deleting history record does not cascade
      *@calling updateRelationship
      */
    function deleteHistory( $historyID ) {
        $query= "DELETE FROM MembersHistory WHERE idHistories = $historyID";
        return updateRelationship( $query );    
    }
    
    /*   END MEMBER UPDATERS ***********************************/
    
    /******************** START PERFORMANCE UPDATERS ***/
    
    /** Karl
      *@param performanceID - target performance
      *@param newInfo - associative array fieldToUpdate => newValue
                          fieldToUpdate is in Performances
      *@return null for success, error message otherwise
      *@calling updateRelationship
      */ 
    function updatePerfInfo($performanceID, $newInfo) {
        $query= "UPDATE Performances SET idPerformances = $performanceID";
        foreach( $newInfo as $fieldToUpdate => $newValue ) {
                $query= $query.", $fieldToUpdate = \"$newValue\"";
        }
        $query= $query." WHERE idPerformances = $performanceID";
        return updateRelationship( $query );
        
    }
    
    /** Karl
      *@param performanceID - target performance
      *@return null for success, error message otherwise
      *@spec deleting performance does not cascade
      *@calling updateRelationship
      */
    function deletePerformance( $performanceID ) {
        $query= "DELETE FROM Performances WHERE idPerformances = $performanceID";
        return updateRelationship( $query );    
    }
    
    /*   END PERFORMANCE UPDATERS ******************************/
    
    /******************** START GENRE UPDATERS ***/
    
    /** Karl
      *@param genreID - target genre
      *@param newInfo - associative array fieldToUpdate => newValue
                          fieldToUpdate is in Genres
      *@return null for success, error message otherwise
      *@calling updateRelationship
      */ 
    function updateGenreInfo($genreID, $newInfo) {
        $name= $newInfo["genreName"];
        $query= "UPDATE Genres SET genreName = \"$name\"
                 WHERE idGenres = $genreID";
        return updateRelationship( $query );
        
    }
    
    /** Karl
      *@param genreID - target genre
      *@return null for success, error message otherwise
      *@spec deleting genre does ot cascade
      *@calling updateRelationship
      */
    function deleteGenre( $genreID ) {
        $query= "DELETE FROM Genres WHERE idGenres = $genreID";
        return updateRelationship( $query );    
    }
    
    /*   END GENRE UPDATERS  ***********************************/
    
    /******************* START PICTURE UPDATERS ***/
    
    /** Karl
      *@param pictureID - target picture
      *@param newInfo - associative array fieldToUpdate => newValue
                          fieldToUpdate is actual field in Pictures
      *@return null for success, error message otherwise
      *@calling updateRelationship
      */ 
    function updatePicInfo($pictureID, $newInfo) {
        $query= "UPDATE Pictures SET idPictures = $pictureID";
        foreach( $newInfo as $fieldToUpdate => $newValue ) {
            if ( $fieldToUpdate == "performanceID" ) {
                $query= $query.", $fieldToUpdate = $newValue";
            } else {
                $query= $query.", $fieldToUpdate = \"$newValue\"";
            }
        }
        $query= $query."WHERE idPictures = $pictureID";
        return updateRelationship( $query );
    }
    
    /** Karl
      *@param pictureID
      *@return null for success, error message otherwise
      *@spec deleting picture record does not cascade 
             (should it permanently delete picture form diretory? right now, no)
      *@note To save space on host, make pictures just link to something like photobucket?
      *@calling updateRelationship
      */
    function deletePicture( $pictureID, $pathToFile ) {
        if ( $pictureID == 0 ) {
            return "Cannot delete this picture<br>";
        }
        /*require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>";
        }

        get all members that have this picture as profile picture.
        $query= "SELECT idMembers WHERE pictureID = $pictureID";
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            $err = "$mysqli->error<br>";
            $mysqli->close();
            return $err;
        }
        */
        $query= "UPDATE Members SET pictureID= 0 WHERE pictureID=$pictureID";
        $error= updateRelationship( $query );
        if ($error) {
            return $error;
        }
        $query= "DELETE FROM Pictures WHERE idPictures = $pictureID";
        $error= updateRelationship( $query );
        if ( !$error and unlink($pathToFile) ) {
            return null;
        }
        if ( $error ) {
            return $error;  
        }
        return "Error: There was a problem deleting the picture from storage<br>"; 
    }
    
    /*   END PICTURE UPDATERS **********************************/
    
    /**************************** START POSITION UPDATERS ****/
    
    /** Karl
      *@param positionID - target position in Positions table
      *@param newInfo - associative array fieldToUpdate => newValue
                          only fieldToUpdate is 'position'
      *@return null for success, error message otherwise
      *@calling updateRelationship
      */ 
    function updatePosition($positionID, $newInfo) {
        $query= "UPDATE Positions SET ";
        //should only be one iteration
        foreach ($newInfo as $fieldToUpdate => $newValue ) {
            $query= $query."$fieldToUpdate = \"$newValue\"";    
        }
        $query= $query." WHERE idPositions = $positionID";
        return updateRelationship( $query );
    }
    
    /** Karl
      *@param positonID - target position
      *@spec delete Positions entry matching positionID
      *@return null for success, error message otherwise
      *@calling updateRelationship
      */
    function deletePosition($positionID) {
        $query= "DELETE FROM Positions
                       WHERE idPositions = $positionID";
                       
        return updateRelationship( $query );
    }
    
    /*** END POSITION UPDATERS ******************************/
    
?>          
