<?php
    include "helpers.php";
?>
<?php
 
    /************************ GET FUNCTIONS **************************
    /*All functions that retrieve information from the database */
 
    /** Karl
      *@param query - single SELECT query to database
      *@return results of query as an array of asociative arrays
                     where eah associative array is a record from the DB
      *@note helper
      *@spec returns null on error
      *@caller
      */
    function retrieve( $query ) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            echo "Error: cannot connect to database. Try again later<br>.";
            return null;
        }
        
        $result= $mysqli->query( $query );
        if ( !$result ) {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return null;
        }
        $records= array();//array of associative arrays
        $entry= $result->fetch_assoc();
        while ( $entry ) {
            $records[]= $entry;
            $entry= $result->fetch_assoc();               
        }
        $mysqli->close();
        return $records;
    }
 
 
 
    /************ START VIDEO GETTERS */
    /** KARL
      *@param memberID - (valid?) member id
      *@return the videos (videoIDs) associated with 'memberID'
      *@spec if memberID is not in table, returns empty array
      *@calling retrieve
      */
    function getVideosFor($memberID) {
        $query= "SELECT videoID
                 FROM MembersInVid
                 WHERE memberID = \"$memberID\";";
        return retrieve( $query );
    }
    
    /** KARL
      *@param videos - list of videoIDs
      *@return associative array / videoID => associative array of video's info
      *         if database error for one videoID, get those that do not cause an error only
      *@calling getVideoInfo
      TODO TODO
      */
    function getVideosInfo($videos) {
        if ( !$videos ) {  
            return null;
        }
        $allVidsInfo= array(); 
        foreach ( $videos as $vidID ) {
            $vidInfo= getVideoInfo($vidID);
            if ( $vidInfo ) {
                $allVidsInfo[$vidID]= $vidInfo;
            } else {
                //there was an error for one of the videos.
                //abort altogether or get what we can??? TODO
                //right now, getting what we can.
            }
        }      
        return $allVidsInfo;  
    } 
    
    /** KARL
      *@param videoID - target video (its ID)
      *@return all information associated with videoID,
               except members that performed in it,
               in the following format:
               
               vidInfo["idVideos"] => same as 'videoID'
               vidInfo["urlV"] => url for that video
               vidInfo["captionV"] => the caption
               vidInfo["idPerformances"] => corresponding performanceID
               vidInfo["performanceTitle"] =>
               vidInfo["performanceLocation"] =>
               vidInfo["performanceDate"] =>

               on mysqli error, return null
               
      */
    function getVideoInfo($videoID) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            echo "Error: cannot connect to database. Try again later<br>.";
            return null;
        }
        $vidInfo= array();//will be mapping: [relevantVideoField] => [correspondingValueInField]
        //query for retrieving all content in Videos and Performances tables
        $query= "SELECT idVideos, urlV, captionV, idPerformances, performanceTitle, performanceLocation, performanceDate
                 FROM Videos INNER JOIN Performances ON performanceID = idPerformances
                 WHERE idVideos = $videoID;";
        //adding query for retrieving all dance genres associated with this video
        $query= $query."SELECT genreName
                        FROM Genres INNER JOIN GenresInVid ON idGenres = genreID
                        WHERE videoID = $videoID;";
        $results= $mysqli->multi_query ( $query );
        $vidNPerformance= $mysqli->store_result();//get result of first query
        $genres= $mysqli->more_results();//get result fo second query
        
        if ( $vidNPerformance ) {
            //retrieve values from first query and store in 'vidsInfo'
            $vidInfo= $vidNPerformance->fetch_assoc();
            //schema guarantees at most one result row.
                
        } else {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return null;
        }
        if ( $genres ) {
            $row= $genres->fetch_row();
            //only one element per row: genreName.
            $vidInfo["genres"]= array();
            //store genres in vidInfo["genres"]
            while ( $row ) {
                $vidInfo["genres"][]= $row[0];
                $row= $genres->fetch_row();    
            }
                
        } else {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return null;
        }
        $mysqli->close();
        return $vidInfo;
    }  
    
    /** Karl
      *@param videoID - target video
      *@return Videos records of all videos 
      *               that have at least one genre in common with target
      *@spec returns null on error, empty array on no matches
      *@calling retrieve
      */
    function getRelatedVideos($videoID) {
        //do we want to allow users to select what relationship to use
        //(as opposed to doing genre comparisons) ?
        //for instance, after viewing a video, we could allow users to
        //choose to see videos of the same dance style, videos with the same
        //people, videos that are part of the same peformance...
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            echo "Error: cannot connect to database. Try again later<br>.";
            return null;
        }
        //this query gets all the genreIDs linked to this video
        $query= "SELECT genreID 
                 FROM GenresInVid 
                 WHERE videoID = $videoID";
        //this query gets all video information from thoses videos that
        //share at least one genre with the target video
        $query="SELECT * FROM Videos vid
                WHERE idVideos <> $videoID 
                      AND  EXISTS(
                                  (SELECT genreID 
                                   FROM GenresInVid
                                   WHERE videoID = vid.idVideos)
                                 INTERSECT
                                  (
                                   ".$query.")
                                 )";
        return retrieve( $query ); 
    }
    
    /** Karl
      *@param videoID - video's id in Videos table
      *@return associative array with all info pertaining to that video:
      *        date, location, performance, featured performers, relared videos
      *        etc
      */
    function getAllForVideo($videoID) {
        
    }
    
        
     /** Karl
      *@param memberID - target video
      *@return videos (videoIDs)  choreographed by target member
      *@spec returns null on error
      *@calling retrieve
      */
    function getVidsChoreographedByMember($memberID) {
        $query= "SELECT videoID FROM ChoreographersOfVid WHERE memberID = $memberID";      
        return retrieve( $query );
    }
    
    
    
    /*  END VIDEO GETTERS **************************************/
    
    /******************** START MEMBER GETTERS ***/
    
    /** Karl
      *@param videoID - target video
      *@return members that appear in/are linked to the target video
               Specifically, returns member info from Members in MemberContactInfo
               in an array where [index] => [memberinfoField] => [value]
      *@spec returns null on error, empty array on no matches
      *@calling retrieve
      */
    function getMembersForVideo($videoID) {
        $query= "SELECT * 
                 FROM Members mem
                      INNER JOIN MemberContactInfo ON idMembers = memberID
                 WHERE EXISTS (SELECT *
                               FROM MembersInVid
                               WHERE mem.idMembers = memberID 
                                     AND videoID = $videoID)";
        return retrieve( $query );
    }
    
    
    /** KARL
      *@param memberID - target member
      *@return all info corresponding to 'memberID'
              from Members, MemberContactInfo, MemberHistory
              in the following format:
              
              memberInfo["idMembers"] => same as memberID
              memberInfo["firstName"] =>
              memberInfo["lastName"] =>
              memberInfo["year"] =>
              memberInfo["bio"] =>
              memberInfo["pictureID"] =>
              memberInfo["idPictures"] =>
              memberInfo["urlP"] => url for this picture
              memberInfo["idHistory"] =>
              memberInfo["memberID"] =>
              memberInfo["positions"] => one set for each matching history record
                                         ["memberID"] =>
                                         ["positionID"] =>
                                         ["position"] =>
                                         ["startDate"] =>
                                         ["endDate"] =>
              memberInfo["email] =>
              memberInfo["phone"] =>
              memberInfo["country"] =>
              memberInfo["state"] =>
              memberInfo["city"] =>
      */ 
    function getMemberInfo($memberID) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            echo "Error: cannot connect to database. Try again later<br>.";
            return null;
        }
        //query for retrieving all of this member's info from Members and MemberContactInfo
        $query= "SELECT * 
                 FROM Members INNER JOIN MemberContactInfo ON idMembers = memberID
                              INNER JOIN Picures ON pictureID = idPictures
                 WHERE idMembers = $memberID;";
        //query for retrieving all history records associated with this member         
        $query= $query."SELECT *
                        FROM MembersHistory INNER JOIN Positions ON positionID = idPositions
                        WHERE memberID = $memberID;";
        
        $memberInfo= array();
        $results= $mysqli->multi_query ( $query );
        $memberNContactInfo= $mysqli->store_result();//result of first query
        $memberHistory= $mysqli->more_results();//result of second query
        
        if ( $memberNContactInfo ) {
            //store member and contact info
            $memberInfo= $memberNContactInfo->fetch_assoc();
            //schema should guarante at most one result.   
        } else {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return null;
        }
        
        if ( $memberHistory ) {
            $memberInfo["positions"]= array();
            $row= $memberHistory->fetch_assoc();
            //store each history record in memberInfo
            while ( $row ) {
                $memberInfo["positions"][]= $row;
                $row= $memberHistory->fetch_assoc();
            }
        } else {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return null;
        }
        $mysqi->close();
        return $memberInfo;
    }
    
    /** Karl
      *@param memberID - member's id in Members table
      *@return associative array with all info pertaining to that member:
      *        contact info, profile info, related videos, etc
      */
    function getAllForMember($memberID) {
        
    }
    
    /** Karl
      *@param videoID - target video
      *@return members (memberIDs) who choreograohed target video
      *@spec returns null on error
      *@calling retrieve
      */
    function getChoreographersOfVideo($videoID) {
        $query= "SELECT memberID FROM ChoreographersOfVid WHERE videoID = $videoID";
         return retrieve( $query );
    }

    
    /*   END MEMBER GETTERS ***********************************/
    
    /******************** START PERFORMANCE GETTERS ***/
    
    /** Karl
      *@return all performances from Performances table. Specifically, an array of associtaive
      *     arrays such that [0] => ["PerformanceField"] => ["its value"]
      *@caller addVideoForm, addForm
      *@calling retrieve
      */
    function getPerformances() {
        $query= "SELECT * FROM Performances";
         return retrieve( $query );
    }
    
    /** Karl
      *@param performanceID - target performance
      *@return all videos of a given performance in an array such that
               array[0] => [videoField] =>[value]
      *@spec does not return dance genre information for the videos
      *@calling retrieve
      */
    function getVideosFromPerformance($performanceID) {
        $query= "SELECT * FROM Videos WHERE performanceID = $performanceID";
        return retrieve( $query );
    }
    
    /*   END PERFORMANCE GETTERS ******************************/
    
    /******************** START GENRE GETTERS ***/
    
    /** Karl
      *@return all genres from Genres table. Specifically, an array of associtaive
      *     arrays such that [0] => ["GenresField"] => ["Value"]
      *@caller addVideoForm, addForm
      *@calling retrieve
      */
    function getGenres() {
        $query= "SELECT * FROM Genres";
        return retrieve( $query );    
    }
    
    /** Karl
      *@param videoID - target video
      *@return Genres records that are linked to this video as an array
               such that array[0] => [GenresField] => [value]
      *@spec returns null on errors, empty array if video has no associated genre
      *@calling retrieve
      */
    function getGenresInVideo($videoID) {
        $query= "SELECT * 
                 FROM Genres g
                 WHERE EXISTS (SELECT *
                               FROM GenresInVid
                               WHERE genreID = g.idGenres 
                                     AND videoID = $videoID");
         return retrieve( $query );
    }
    
    /*   END GENRE GETTERS  ***********************************/
    
    /******************* START PICTURE GETTERS ***/
    
    /** Karl
      *@return all pictures from Pictures table. Specifically, an array of associtaive
      *     arrays such that [0] => ["PicturesField"] => ["Value"]
      *@spec returns null on error
      *@calling retrieve
      */
    function getPictures() {
        $query= "SELECT * FROM Pictures";
        return retrieve( $query ); 
    }
    
    /** Karl
      *@param performanceID - target performance
      *@return pictures taken of that performance in an array such that
               array[0]=> [PicturesField] => [value]
      *@spec returns null on error, empty array if there are no pictures of
             that performance (in DB, no Pictures record with matching 
             performanceID field)
      *@calling retrieve
      */
    function getPicturesOfPerformance($performanceID) {
        $query= "SELECT * FROM Pictures WHERE performanceID = $performanceID";
         return retrieve( $query );
    }
    
    /*   END PICTURE GETTERS **********************************/
    
    /********************************START POSITION GETTERS ***/
    
    /** Karl
      *@return all records in Positions as array where
                     array[0] => position record as associative array
      *@spec returns null on error
      *@calling retrieve
      */
    function getPositions() {
        $query= "SELECT * FROM Positions";
        return retrieve( $query );
    }
    
    /*** END POSITION GETTERS *****************************/
 
?>