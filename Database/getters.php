<?php
    include_once "helpers.php";
?>
<?php
 
    /************************ GET FUNCTIONS **************************
    /*All functions that retrieve information from the database */
    
    /** Karl, Derek
      *@param query - single SELECT query to database
      *@return results of query as an array of asociative arrays
                     where eah associative array is a record from the DB + null on success
                     On Failure, returns null + error message. Also returns the most recent
                     id created from the query.
      *@note helper
      *@spec returns null on error
      *@caller EVERY OTHER FUNCTION IN HERE
      */
    function addRetrieve( $query ) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return array( null, "Error: cannot connect to database. Try again later<br>", null );
        }
        
        $result= $mysqli->query( $query );
        if ( !$result ) {
            $msg= $mysqli->error;
            $mysqli->close();
            return array( null,"$msg<br>, null" ) ;
        }
        $records= array();//array of associative arrays
        $entry= $result->fetch_assoc();
        while ( $entry ) {
            $records[]= $entry;
            $entry= $result->fetch_assoc();               
        }
        $mysqli->close();
        return array( $records, null, $mysqli->insert_id );
    }   
    
    /** Karl
      *@param query - single SELECT query to database
      *@return results of query as an array of asociative arrays
                     where eah associative array is a record from the DB + null on success
                On Failure, returns null + error message
      *@note helper
      *@spec returns null on error
      *@caller EVERY OTHER FUNCTION IN HERE
      */
    function retrieve( $query ) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return array( null, "Error: cannot connect to database. Try again later<br>" );
        }
        
        $result= $mysqli->query( $query );
        if ( !$result ) {
            $msg= $mysqli->error;
            $mysqli->close();
            return array( null,"$msg<br>" ) ;
        }
        $records= array();//array of associative arrays
        $entry= $result->fetch_assoc();
        while ( $entry ) {
            $records[]= $entry;
            $entry= $result->fetch_assoc();               
        }
        $mysqli->close();
        return array( $records, null );
    }
 
 
 
    /************ START VIDEO GETTERS */
    
    /** Old video search, can use again if needed 
    /** Karl
      *@param searchCriteria - associative array of field=>value mappings.
      *@spec field can be any column in Videos, and Performances. To search for a genre, pass in "genreName"=>inputted genre name
      *@spec searchCriteria should not contain IDs because the user should have no notion of IDs
      *@return all Videos records joined with their matching entry in Performances and GenresInVid
      *@return on success: (records, null) -- On failure: (null, error message)
      *@caller retrieve
      */ /*
    function searchVideos( $searchCriteria ) {
        $videosSchema= array ( "urlV", "captionV", "performanceID" );
        $genresSchema= array ( "genres" );
        $performancesSchema= array( "performanceTitle","performanceLocation","performanceDate" );
        //build query to DB
        $query= "";
        $genreCheck= "";
        foreach( $searchCriteria as $field => $value ) {
            if ( in_array( $field, $genresSchema ) ) {
                $genreCheck= "SELECT * 
                                          FROM Genres INNER JOIN GenresInVid ON genreID = idGenres
                                          WHERE $field = \"$value\"";
            } else {
                if ( $query == "" ) {
                    $query= "SELECT * FROM Videos INNER JOIN Performances ON performanceID = idPerformances WHERE  $field = \"$value\"";
                } else {
                    $query= $query." AND $field = \"$value\"";    
                }
            }    
        }
        //aggregate query
        $query= $query." AND EXISTS( ".$genreCheck." AND Videos.idVideos = videoID );";
        //submit query and return results
        return retrieve( $query );
    }*/

    /** Karl, Derek: Added some changes
      *@param searchCriteria - associative array of field=>value mappings.
      *@spec field can be any column in Videos, and Performances. To search for a genre, pass in "genreName"=>inputted genre name
      *@spec searchCriteria should not contain IDs because the user should have no notion of IDs
      *@return all Videos records joined with their matching entry in Performances and GenresInVid and Members -> Use VS before the field to extract value.
      *@return on success: (records, null) -- On failure: (null, error message)
      *@caller retrieve
      */
    function searchVideos( $searchCriteria ) {
        $videosSchema= array ( "urlV", "captionV", "performanceID" );
        $genresSchema= array ( "genreName" );
        $performancesSchema= array( "performanceTitle","performanceLocation","performanceDate", "year" );
        $memberSchema = array("firstName", "lastName");
        $choreoSchema = array("cFirstName", "cLastName");

        //build query to DB
        $query= "";
        $genreCheck= "";
        $memberCheck = "";
        $choreoCheck = "";

        //Checks to see if fields for genre or members were selected.
        $memberBool = false;
        $genreBool = false;
        $perfBool = false;
        $choreoBool = false;
        foreach( $searchCriteria as $field => $value ) {
            if ( in_array( $field, $genresSchema ) ) {
                $genreBool = true;
                $genreCheck= "SELECT * 
                                          FROM Genres INNER JOIN GenresInVid ON genreID = idGenres
                                          WHERE $field = \"$value\"";
            } 
            elseif(in_array($field, $choreoSchema) ) {
                $choreoBool = true;
                if($field == "cFirstName") {
                    $field = "firstName";
                }
                else {
                    $field = "lastName";
                }
                if ( $choreoCheck == "" ) {
                    $choreoCheck = "SELECT * FROM Videos V, Members M, ChoreographersOfVid CV WHERE M.idMembers
                        = CV.memberID AND CV.videoID = V.idVideos AND (M.$field REGEXP \"$value\"";
                }
                else {
                    $choreoCheck = $choreoCheck. " OR M.$field REGEXP \"$value\")";
                } 
            }
            elseif(in_array($field, $memberSchema) ) {
                $memberBool = true;
                if ( $memberCheck == "" ) {
                    $memberCheck = "SELECT * FROM Videos V, Members M, MembersInVid MV WHERE M.idMembers
                        = MV.memberID AND MV.videoID = V.idVideos AND (M.$field REGEXP \"$value\"";
                }
                else {
                    $memberCheck = $memberCheck. " OR M.$field REGEXP \"$value\")";
                } 
            }
            else {
                $perfBool = true;
                if( $query == "" && $field == "year") {
                    $query = "SELECT * FROM Videos VS INNER JOIN Performances ON performanceID = idPerformances WHERE Year(performanceDate) = \"$value\"";
                }
                elseif ( $query == "" ) {
                    $query= "SELECT * FROM Videos VS INNER JOIN Performances ON performanceID = idPerformances WHERE  $field REGEXP \"$value\"";
                }
                elseif($field == "year") {
                    $query = $query." AND Year(performanceDate) = \"$value\"";
                }
                else {
                    $query= $query." AND $field REGEXP \"$value\"";    
                }
            }    
        }
        //aggregate query

        if (!$perfBool) {
            $query = "SELECT * FROM Videos VS WHERE VS.idVideos = VS.idVideos";
        }
        if ($genreBool) {
            $query= $query." AND EXISTS( ".$genreCheck." AND VS.idVideos = videoID )";
        }
        if ($memberBool) {
            $query = $query. " AND EXISTS( ".$memberCheck." AND VS.idVideos = V.idVideos )";
        }
        if ($choreoBool) {
            $query = $query. " AND EXISTS( ".$choreoCheck." AND VS.idVideos = V.idVideos )";
        }
        $query = $query. ";";
        //submit query and return results
        return retrieve( $query );
    }
    
    /** KARL
      *@param memberID - (valid?) member id
      *@return the videos records associated with 'memberID' + null on success, null + error message on failure
      *@spec if memberID is not in table, returns empty array
      *@calling retrieve
      */
    function getVideosFor($memberID) {
        $query= "SELECT * FROM Videos WHERE idVideos IN (SELECT videoID
                 FROM MembersInVid
                 WHERE memberID = \"$memberID\");";
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
      *@return all information associated with videoID, (+ null)
               except members that performed in it,
               in the following format:
               
               vidInfo["idVideos"] => same as 'videoID'
               vidInfo["urlV"] => url for that video
               vidInfo["captionV"] => the caption
               vidInfo["idPerformances"] => corresponding performanceID
               vidInfo["performanceTitle"] =>
               vidInfo["performanceLocation"] =>
               vidInfo["performanceDate"] =>

               on mysqli error, return (null, error message)
               
      */
    function getVideoInfo($videoID) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return array( null, "Error: cannot connect to database. Try again later<br>");
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
        $genres= $mysqli->next_result();//get result fo second query
        $genreStore = $mysqli->store_result();


        
        if ( $vidNPerformance ) {
            //retrieve values from first query and store in 'vidsInfo'
            $vidInfo= $vidNPerformance->fetch_assoc();
            //schema guarantees at most one result row.
                
        } else {
            $mysqli->close();
            return array( null, "$mysqli->error<br>" );
        }
        if ( $genres ) {
            $row= $genreStore->fetch_row();
            //only one element per row: genreName.
            $vidInfo["genres"]= array();
            //store genres in vidInfo["genres"]
            while ( $row ) {
                $vidInfo["genres"][]= $row[0];
                $row= $genreStore->fetch_row();    
            }
                
        } else {
            $mysqli->close();
            return array( null, "$mysqli->error<br>" );
        }
        $mysqli->close();
        return array( $vidInfo, null );
    }
    
    /** Karl
      *@param videoID - target video
      *@return Videos records of all videos 
      *               that have at least one genre in common with target + null
      *@spec returns (null , error message) on error, (empty array,null) on no matches
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
            return array( null, "Error: cannot connect to database. Try again later<br>" );
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
      *@return videos (videoIDs)  choreographed by target member + null
      *@spec returns (null, error message) on error
      *@calling retrieve
      */
    function getVidsChoreographedByMember($memberID) {
        $query= "SELECT videoID FROM ChoreographersOfVid WHERE memberID = $memberID";      
        return retrieve( $query );
    }
    
    /** Karl
      *@return video records + null
      *@spec returns (null, error message) on error
      *@calling retrieve
      */ 
    function getVideos() {
        $query= "SELECT * FROM Videos";
        return retrieve( $query );    
    }
    
    /*  END VIDEO GETTERS **************************************/
    
    /******************** START MEMBER GETTERS ***/
    
    /** Karl
      *@param videoID - target video
      *@return members that appear in/are linked to the target video + null
               Specifically, returns member info from Members in MemberContactInfo
               in an array where [index] => [memberinfoField] => [value]
      *@spec returns (null, error message) on error, (empty array, null) on no matches
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
    
    //Return all members not in the video.
    function notMembersForVideo($videoID) {
        $query= "SELECT * FROM Members
                WHERE idMembers NOT IN (
                 SELECT mem.idMembers 
                 FROM Members mem
                      INNER JOIN MemberContactInfo ON idMembers = memberID
                 WHERE EXISTS (SELECT *
                               FROM MembersInVid
                               WHERE mem.idMembers = memberID 
                               AND videoID = $videoID))";
        return retrieve($query);
    }
    
    
    /** KARL
      *@param memberID - target member
      *@return all info corresponding to 'memberID'
              from Members, MemberContactInfo, MemberHistory (+ null)
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
              
              On error, return (null, error message)
      */ 
    function getMemberInfo($memberID) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return array( null, "Error: cannot connect to database. Try again later<br>" );
        }
        //query for retrieving all of this member's info from Members and MemberContactInfo
        $query= "SELECT * 
                 FROM Members INNER JOIN MemberContactInfo ON idMembers = memberID
                              INNER JOIN Pictures ON pictureID = idPictures
                 WHERE idMembers = $memberID;";
        //query for retrieving all history records associated with this member         
        $query= $query."SELECT *
                        FROM MembersHistory INNER JOIN Positions ON positionID = idPositions
                        WHERE memberID = $memberID;";
        
        $memberInfo= array();
        $results= $mysqli->multi_query ( $query );
        $memberNContactInfo= $mysqli->store_result();//result of first query
        if ( $memberNContactInfo ) {
            //store member and contact info
            $memberInfo= $memberNContactInfo->fetch_assoc();
            //schema should guarante at most one result.   
        } else {
            $msg= "$mysqli->error<br>";
            $mysqli->close();
            return array( null, $msg );
        }
        $memberNContactInfo->free();
        if ($mysqli->more_results() && $mysqli->next_result() && $memberHistory= $mysqli->store_result() ) {
            $memberInfo["positions"]= array();
            $row= $memberHistory->fetch_assoc();
            //store each history record in memberInfo
            while ( $row ) {
                $memberInfo["positions"][]= $row;
                $row= $memberHistory->fetch_assoc();
            }
        } else {
            $msg= "$mysqli->error<br>";
            $mysqli->close();
            return array( null, $msg );
        }
        $mysqli->close();
        return array( $memberInfo, null );
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
      *@return members (memberIDs) who choreograohed target video + null
      *@spec returns (null, error message) on error
      *@calling retrieve
      */
    function getChoreographersOfVideo($videoID) {
        $query= "SELECT idMembers, firstName, lastName FROM ChoreographersOfVid,Members WHERE idMembers = memberID AND videoID = $videoID";
         return retrieve( $query );
    }

    //Same as above, but for members who are not choreographers.
    function notChoreographersOfVideo($videoID) {
        $query = "SELECT * FROM Members WHERE idMembers NOT IN 
            (SELECT idMembers FROM ChoreographersOfVid,Members WHERE idMembers = memberID AND videoID = $videoID)";
        return retrieve($query);
    }
    
    /** Karl
      *@return all active members and their info + null
      *@spec reutrns (null, error message) on error
      *@calling retrieve currentDate()
      */
    function getActiveMembers() {
        $currentDate= currentDate();
        $query= "SELECT * 
                       FROM Members INNER JOIN MemberContactInfo ON idMembers = MemberContactInfo.memberID
                                                   INNER JOIN ( SELECT * FROM MembersHistory
                                                                           WHERE startDate <= \"$currentDate\" AND endDate >= \"$currentDate\") History ON idMembers = History.memberID
                                                   INNER JOIN Pictures ON pictureID = idPictures
                                                   INNER JOIN Positions ON positionID = idPositions";
        return retrieve( $query );     
    }
    
    /** Karl
      *@return all inactive members and their info + null
      *@spec reutrns (null, error message) on error
      *@calling retrieve currentDate()
      */
    function getInactiveMembers() {
        $currentDate= currentDate();
        $query= "SELECT * 
                       FROM Members INNER JOIN MemberContactInfo ON idMembers = MemberContactInfo.memberID
                                                   INNER JOIN ( SELECT * FROM MembersHistory
                                                                           WHERE  endDate < \"$currentDate\") History ON idMembers = History.memberID
                                                   INNER JOIN Pictures ON pictureID = idPictures
                                                   INNER JOIN Positions ON positionID = idPositions";
        return retrieve( $query );     
    }
    
    /** Karl
      *@return all records in Members table + null
      *@spec returns (null, error message) on error
      *@calling retrieve
      */
    function getMemberRecords() {
        $query= "SELECT * FROM Members";
        return retrieve( $query );    
    }
    
    /** Karl
      *@param searchCriteria - associative array of field => value mappings
                      where field is any non ID column in Members, MemberContactInfo and MembersHistory
                      special 'field'=>'value pairs:
                          --'joinedAfter' => [date]{yyyy-mm-dd, yyyy-mm, yyyy}
                          --'joinedBefore' => [date]{yyyy-mm-dd, yyyy-mm, yyyy}
      *@return all member records joined with MembercontactInfo and MembersHistory
      *@return on success: (records, null) - on failure: (null, error message)
      *@calling retrieve
      */
    function searchMembers( $searchCriteria ) {
            /**$memberSchema= array("firstName", "lastName", "bio", "year", "bio");
            $contactSchema= array("email","phone","country","state","city");
            $historySchema= array("positionID", "startDate", "endDate");*/
            $numeric= array("positionID", "year", "phone");
            $special= array("joinedAfter","joinedBefore");
            
            $query= "";
            foreach( $searchCriteria as $field => $value ) {
                    if ( $query == "" ) {
                        if ( in_array( $field, $numeric ) ) {
                            $query= "SELECT * FROM Members INNER JOIN MemberContactInfo ON idMembers = memberID
                                                                        INNER JOIN MembersHistory ON idMembers = memberID WHERE $field = $value";
                        } elseif ( $field == "joinedAfter" ) {
                            $query= "SELECT * FROM Members INNER JOIN MemberContactInfo ON idMembers = memberID
                                                                        INNER JOIN MembersHistory ON idMembers = memberID WHERE startDate > \"$value\"";
                        } elseif ( $field == "joinedBefore" ) {
                            $query= "SELECT * FROM Members INNER JOIN MemberContactInfo ON idMembers = memberID
                                                                        INNER JOIN MembersHistory ON idMembers = memberID WHERE startDate < \"$value\"";
                        }else {
                            $query= "SELECT * FROM Members INNER JOIN MemberContactInfo ON idMembers = memberID
                                                                        INNER JOIN MembersHistory ON idMembers = memberID WHERE $field LIKE '%$value%' ";
                        }
                    } else {
                        if ( in_array( $field, $numeric ) ) {
                            $query= $query." AND $field = $value";
                        } elseif ( $field == "joinedAfter" ) {
                            $query= $query."AND startDate > \"$value\"";
                        } elseif ( $field == "joinedBefore" ) {
                            $query= $query." startDate < \"$value\"";
                        } else {
                            $query= $query." AND $field LIKE '%$value%' ";
                        }
                    }
            }
            
            return retrieve( $query );
    }
    
    /*   END MEMBER GETTERS ***********************************/
    
    /******************** START PERFORMANCE GETTERS ***/
    
    /** Karl
      *@return all performances from Performances table + null. Specifically, an array of associtaive
      *     arrays such that [0] => ["PerformanceField"] => ["its value"]
            on error, return (null, error message)
      *@caller addVideoForm, addForm
      *@calling retrieve
      */
    function getPerformances() {
        $query= "SELECT * FROM Performances";
         return retrieve( $query );
    }

    //Get a performance
    function getPerformance($pID) {
        $query = 'SELECT * FROM Performances WHERE idPerformances = "'.$pID.'"'; 
        return retrieve($query);
    }
    
    /** Karl
      *@param performanceID - target performance
      *@return all videos of a given performance  (+ null) in an array such that
               array[0] => [videoField] =>[value]
               on error, return (null, error message)
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
      *@return all genres from Genres table + null. Specifically, an array of associtaive
      *     arrays such that [0] => ["GenresField"] => ["Value"]
            on error, return (null, error message)
      *@caller addVideoForm, addForm
      *@calling retrieve
      */
    function getGenres() {
        $query= "SELECT * FROM Genres";
        return retrieve( $query );    
    }

    //Get a single genre
    function getGenre($genreID) {
        $query = 'SELECT * FROM Genres WHERE idGenres = "'.$genreID.'"';
        return retrieve($query);
            
    }
    
    /** Karl
      *@param videoID - target video
      *@return Genres records that are linked to this video as an array + null
               such that array[0] => [GenresField] => [value]
      *@spec returns (null, error message) on errors, (empty array, null) if video has no associated genre
      *@calling retrieve
      */
    function getGenresInVideo($videoID) {
        $query= "SELECT * 
                 FROM Genres g
                 WHERE EXISTS (SELECT *
                               FROM GenresInVid
                               WHERE genreID = g.idGenres 
                                     AND videoID = $videoID)";
         return retrieve( $query );
    }
    
    /*   END GENRE GETTERS  ***********************************/
    
    /******************* START PICTURE GETTERS ***/
    
    /** Karl
      *@return all pictures from Pictures table + null. Specifically, an array of associtaive
      *     arrays such that [0] => ["PicturesField"] => ["Value"]
      *@spec returns (null, error message) on error
      *@calling retrieve
      */
    function getPictures() {
        $query= "SELECT * FROM Pictures";
        return retrieve( $query ); 
    }
    
    /** Karl
      *@param pictureID - target picture
      *@return target picture record _ null
      *@spec on error, (null, error message)
      */
    function getPicture( $pictureID ) {
         $query= "SELECT * FROM Pictures WHERE idPictures = $pictureID";
         return retrieve( $query );   
    } 
    
    /** Karl
      *@param performanceID - target performance
      *@return pictures taken of that performance in an array (+ null) such that
               array[0]=> [PicturesField] => [value]
      *@spec returns (null, error message) on error, (empty array, null) if there are no pictures of
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
      *@return (all records in Positions as array where
                     array[0] => position record as associative array, null)
      *@spec returns (null, error message) on error
      *@calling retrieve
      */
    function getPositions() {
        $query= "SELECT * FROM Positions";
        return retrieve( $query );
    }

    function getPosition($pID) {
        $query = 'SELECT * FROM Positions WHERE idPositions = "'.$pID.'"'; 
        return retrieve($query);
    }
    
    /*** END POSITION GETTERS *****************************/
 
?>
