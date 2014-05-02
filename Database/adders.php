<?php
    include "helpers.php";
?>
<?php
 
    /************************ ADD FUNCTIONS **************************
    /*All functions that add a new entity to one of the entity sets of
          the database */
    
    /** Karl
      *@param multiQuery - string containing several queries separated by a comma
      *@param query - query to add to multiQuery
      *@return a multiQuery with 'query' added
      *@note helper
      *@caller getMaxIDs
      */
    function concatenate ( $multiQuery, $query ) {
        if ( $multiQuery == "" ) {
            $multiQuery= $query;
        } else {
            $multiQuery= $multiQuery.";".$query;
        }
        return $multiQuery;
    }
    
    /** Karl
    *@param typeList - array of references to entitiy sets with a unique ID field
    *                  e_g: "Members" in typeList refers to the Members table
    *@param mysqli - a mysqli object (open connection)
    *@return associative array such that typeFromTypeList => maxID in corresponding table + null on success
    *         On failure, returns null + error message
    *@caller addVideo, addMember, addPerformance, addGenre, addPicture
    *@calling concatenate
    */
    function getMaxIDs( $typeList, $mysqli ) {
        $multiQuery= "";
        //for each type in list, add query to retrieve the max ID for that type
        foreach ( $typeList as $type ) {
            if ( $type == "Members" ) {
                
                $query= "SELECT MAX(idMembers) AS maxMemberID FROM Members";
                $multiQuery= concatenate( $multiQuery, $query );
                
            } elseif ( $type == "MembersHistory" ) {
                
                $query= "SELECT MAX(idHistory) AS maxHistoryID FROM MembersHistory";
                $multiQuery= concatenate( $multiQuery, $query );
                
            } elseif ( $type == "Videos" ) {
                
                $query= "SELECT MAX(idVideos) AS maxVideoID FROM Videos";
                $multiQuery= concatenate( $multiQuery, $query );
                
            } elseif ( $type == "Performances" ) {
                
                $query= "SELECT MAX(idPerformances) AS maxPerformanceID FROM Performances";
                $multiQuery= concatenate( $multiQuery, $query );
                
            } elseif ( $type == "Genres" ) {
                
                $query= "SELECT MAX(idGenres) AS maxGenreID FROM Genres";
                $multiQuery= concatenate( $multiQuery, $query );
                
            } elseif ( $type == "Pictures" ) {
                
                $query= "SELECT MAX(idPictures) AS maxPictureID FROM Pictures";
                $multiQuery= concatenate( $multiQuery, $query );
            } elseif ( $type == "Positions" ) {
                
                $query= "SELECT MAX(idPositions) AS maxPositionID FROM Positions";
                $multiQuery= concatenate( $multiQuery, $query );    
            }
        }
        $results= $mysqli->multi_query ( $multiQuery );
        //process results and return them as an associative array.
        $ids= array();
        $firstResult= $results->store_result();//get result of first query
        
        // initialize 'ids' with the results of the first query
        $ids= $firstResult->fetch_assoc();
        $numExpectedResults= count( $typeList );//number of results expected based on input
        
        $nextResult= $results->more_results();//get result of second query (or null if there is not one)
        $numResultsSeen= 1;// 1 for the first result
        while ( $nextResult ) {
            
            //for each successful query, append its results to 'ids' array
            array_merge( $ids, $nextResult->fetch_assoc() );
            $numResultsSeen= $numResultsSeen + 1;
            $nextResult= $results->more_results();    
        }
        if ( $numResultsSeen < $numExpectedResults ) {
            //there was an error with the database
            return array( null, "Error: need to find out what could happen<br>" );
        }
        return array( $ids, null ); 
    }
          
    /******************** START VIDEO ADDERS ***/
    
    /** Karl
      *@param videoInfo - mapping: field2Insert => value2Insert
      *@return null for success, error message on failure
      *@calling getMaxIDs
      */
    function addVideo($videoInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>";
        }
        //get max idVideos from Videos table
        $result= getMaxIDs( array("Videos"), $mysqli );
        $maxIDS= $results[0];
        $error= $results[1];
        if ( $error ) {
            $mysqli->close();
            return $error;
        }
         
        $id= $maxIDs["maxVideoID"] + 1;
        $videosSchema= array ( "urlV", "captionV", "performanceID" );
        $genresSchema= array ( "genres" );
        
        $videoQuery= "INSERT INTO Videos VALUES idVideos= $id";
        $genreQueries= ""; 
        //extend videoQuery and genreQueries with corresponding field => value pairs
        foreach ( $videoInfo as $field => $value ) {
            //for Videos, extend the one record we are inserting with the pair
            if ( in_array ( $field, $videosSchema ) ) {
                // value is a number if field is 'performanceID so no escape quotes needed.
                if ( $field == "performanceID" ) {
                    $videoQuery= $videoQuery.", $field = $value";
                } else {
                    $videoQuery= $videoQuery.", $field = \"$value\"";
                }
                
            } elseif ( in_array ( $field, $genresSchema ) ) {
                //for GenresInVid, we need to add a record for each genre we
                //are linking to this video
                $numGenresInserted= count( $value );
                //here, value is an array of genreIDs
                foreach ( $value as $genreID ) {
                    $genreQueries= $genreQueries."INSERT INTO GenresInVid VALUES genreID = $genreID, videoID = $videoID;";           
                }  
            }
        }
        //append queries for genres to the query for the video
        //because we need to insert the video before linking genres to it
        $multiQuery= $videoQuery.$genreQuery;
        $results= $mysqli->multi_query ( $multiQuery );
        $videoInserted= $results->store_result();//get the result for the video query
        $genresInserted= $results->more_results();//get the result for the first genre query (if there is one)
        if ( $videoInserted && $numGenresInserted ) {
            $numGenresSeen= 0;
            while ( $genresInserted ) {
                $genresInserted= $results->more_results();
                $numGenresSeen= $numGenresSeen + 1;
            }
            if ( $numGenresSeen < $numGenresInserted ) {
                $mysqli->close();
                return "Error adding one of the genres: $mysqli->error<br>";
            }
            //success
            $mysqli->close();
            return null;    
        } else {
            $mysqli->close();
            return "Error adding video: $mysqli->error<br>";
        }
    }
          
              /*  END VIDEO ADDERS **************************************/
    
    /******************** START MEMBER ADDERS ***/
    
    /** Karl TODO analyze the errors that could occur
      *@param memberInfo - mapping: field2Insert => Value2Insert
      *@return null on success, error message on failure
      *@spec creates new history and contact records for this member
      *@spec position ID picked from a lst
      *calling getMaxIDs 
      */
    function addMember($memberInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>";
        }

        $result= getMaxIDs( array("Members","MembersHistory"), $mysqli );
        $maxIDs= $result[0];
        $error= $result[1];
        if ( $error ) {
            $mysqli->close();
            return $error;
        }
        //get idMembers and idhistory for this new member  
        $id= $maxIDs["maxMemberID"] + 1;
        $hID= $maxIDs["maxHistoryID"] + 1;
        $membersSchema= array ( "firstName", "lastName", "year", "bio" );
        $contactSchema= array ( "email", "phone", "country", "state", "city" );
        $historySchema= array ( "positionID", "startDate", "endDate" );
        
        $memberQuery= "INSERT INTO Members VALUES idMembers= $id";
        $contactQuery= "INSERT INTO MemberContactInfo VALUES memberID= $id";
        $historyQuery= "INSERT INTO MembersHistory VALUES idHistory= $hID, memberID= $id"; 
        
        //build queries by adding field and value to appropriate table
        foreach ( $memberInfo as $field => $value ) {
            if ( in_array ( $field, $memberSchema ) ) {
                // 'year': in database it is an int, so we can't have escaped quotes
                if ( $field == "year" ) {
                    $memberQuery= $memberQuery.", $field = $value";
                } else {    
                    $memberQuery= $memberQuery.", $field = \"$value\"";
                }
                
            } elseif ( in_array ( $field, $contactSchema ) ) {
                $contactQuery= $contactQuery.", $field = \"$value\"";
                
            } elseif ( in_array ( $field, $historySchema ) ) {
                if ( $field == "positionID" ) {
                    $historyQuery= $historyQuery.", $field = $value";
                } else {
                    $historyQuery= $historyQuery.", $field = \"$value\"";
                }
            }   
        }
        //concatenate all queries. Should we make this a transaction 
        // in order to roll back if one of them fails???
        $multiQuery= $memberQuery.";".$contactQuery.";".$historyQuery.";";
        $results= $mysqli->multi_query ( $multiQuery );
        
        //TODO analyze the errors that could occur in this triple query.
        
        //get result of insert into Members table.
        $memberInserted= $results->store_result();
        //get result of insert into MemberContactInfo table.
        $contactInserted= $results->more_results();
        //get result of insert into MembersHistory table.
        $historyInserted= $results->more_results();
        
        if ( !$memberInserted || !$contactInserted || !$historyInserted ) {
            $mysqli->close();
            return "Error: $mysqli->error<br>";
        }
        $mysqli->close();
        return null;
        
    }
    
    /*   END MEMBER ADDERS ***********************************/
    
    /******************** START PERFORMANCE ADDERS ***/
    
    /** Karl
      *@param performanceInfo - mapping: [field2Insert] => [value2Insert]
      *@return null on success, error message on failure
      *@calling getMaxIDs
      */
    function addPerformance($performanceInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>";
        }
        //get max idPerformances from Performances table
        $result= getMaxIDs( array("Performances"), $mysqli );
        $maxID= $result[0];
        $error= $result[1];
        if ( $error) {
            $mysqli->close();
            return $error;
        }
        $id= $maxID["maxPerformanceID"] + 1;
        $query= "INSERT INTO Performances VALUES idPerformances = $id";
        foreach ( $performanceInfo as $field => $value ) {
            $query= $query.", $field = \"$value\"";    
        }
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            $mysqli->close();
            return "$mysqli->error<br>";
        }
        $mysqli->close();
        return null;
        
    }
    
    /*   END PERFORMANCE ADDERS ******************************/
    
    /******************** START GENRE ADDERS ***/
    
    /** Karl
      *@param genreInfo - single entry mapping: "genre" -> [genreName]
      *@return null for success, error message on failure
      *@adds one genre to the database, if not already there
      *@calling getMaxIDs
      */
    function addGenre($genreInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>";
        }
        $genreName= $genreInfo["genre"];
        
        //if genreName is already in Genres table, do nothing, return null
        $query= "SELECT * FROM Genres WHERE genreName = $genreName";
        $res= $mysqli->query ( $query );
        if ( !$res ) {
            $mysqli->close();
            return "$mysqli->error<br>"; 
        }
        if ( $res->num_rows == 1 ) {
            return null;
        }
        //genreName must then be new. Insert it
        $result= getMaxIDs( array("Genres"), $mysqli );
        $maxID= $result[0];
        $error= $result[1];
        if ( $error ) {
            $mysqli->close();
            return $error;
        }   
        $id= $maxID["maxGenreID"] + 1;
        
        $query= "INSERT INTO Genres VALUES idGenres = $id, genreName = $genreName";
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            $mysqli->close();
            return "$mysqli->error<br>";
        }
        $mysqli->close();
        return null;
    }
    
    /*   END GENRE ADDERS  ***********************************/
    
    /******************* START PICTURE ADDERS ***/
    
    /** Karl
      *@param pictureInfo - single entry mapping: "urlP" -> [url]
      *@return null for success, error message otherwise
      *@spec adds one picture to the database
      *@calling getMaxIDs
      *@caller storePicture
      *@note helper: Call storePicture instead
      */
    function addPicture($pictureInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>";
        }
        //retrieve max idPictures from Pictures table
        $result= getMaxIDs( array("Pictures"), $mysqli );
        $maxID= $result[0];
        $error= $result[1];
        if ( $error ) {
            $mysqli->close();
            return $error;
        }   
        $id= $maxID["maxPictureID"] + 1;
        
        $query= "INSERT INTO Pictures VALUES idPictures = $id";
        foreach ( $pictureInfo as $field => $value ) {
            if ( $field == "performanceID" ) {
                $query= $query.", $field = $value";
            } else {
                $query= $query.", $field = \"$value\"";
            }    
        }
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            $mysqli->close();
            return "$mysqli->error<br>";
        }
        $mysqli->close();
        return null;
    }
    
    /** Karl
      *@param tempLocation - the temporary path to the uploaded picture
      *@photoName - the title of the picture file uploaded
      *@return null for success, error message  on failure
      *@spec move picture from temp storage to 'pictures' directory.
             if it does not exist, create it first
      *@calling addPicture
      *@note TODO: verify path logic
      */
    function storePicture($tempLocation, $photoName, $pictureInfo) {
        if ( !file_exists ( "/img" ) ) {
            //create folder
            if ( !mkdir ( "/img" ) ) {
                return "Error creating 'img' directory<br>";
            }
        }
          move_uploaded_file( $tempLocation, "img/".$photoName );
          return addPicture( $pictureInfo );
    }
    
    /*   END PICTURE ADDERS **********************************/
    
    /*****************************START   POSITION ADDERS ****/
    
    /** Karl
      *@param positionInfo - single entry mapping: "title" -> [position]
      *@return null for success or input title already existed, error message otherwise
      *@adds one position to the database, if not already there
      *@calling getMaxIDs
      */
    function addPosition($positionInfo) {
       require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>";
        }
        $positionTitle= $positionInfo["title"];
        
        //if positionTitle is already in Positions table, do nothing, return 1
        $query= "SELECT * FROM Positions WHERE position = $positionTitle";
        $res= $mysqli->query ( $query );
        if ( !$res ) {
            $mysqli->close();
            return "$mysqli->error<br>"; 
        }
        if ( $res->num_rows == 1 ) {
            return null;
        }
        //positionTitle must then be new. Insert it
        $result= getMaxIDs( array("Positions"), $mysqli );
        $maxID= $result[0];
        $error= $result[1];
        if ( $error ) {
            $mysqli->close();
            return $error;
        }   
        $id= $maxID["maxPositionID"] + 1;
        
        $query= "INSERT INTO Positions VALUES idPositions = $id, position = $positionTitle";
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            $mysqli->close();
            return "$mysqli->error<br>";
        }
        $mysqli->close();
        return null;   
    }
    
    /*   END POSITION ADDERS ***************************/
?>          
