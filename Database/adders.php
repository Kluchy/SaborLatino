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
    *@return associative array such that typeFromTypeList => maxID in corresponding table
    *@caller addVideo, addMember, addPerformance, addGenre, addPicture(not written yet)
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
            echo "Error: need to find out what could happen<br>";
            return null;
        }
        return $ids; 
    }
          
    /******************** START VIDEO ADDERS ***/
    
    /** Karl
      *@param videoInfo - mapping: field2Insert => value2Insert
      *@return 1 for success, 0 for failure
      *@calling getMaxIDs
      */
    function addVideo($videoInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            echo "Error: cannot connect to database. Try again later<br>.";
            return 0;
        }
        //get max idVideos from Videos table
        $maxIDs= getMaxIDs( array("Videos"), $mysqli );
        if ( !$maxIDs ) {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return 0;
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
                echo "Error adding one of the genres: $mysqli->error<br>";
                $mysqli->close();
                return 0;
            }
            //success
            $mysqli->close();
            return 1;    
        } else {
            echo "Error adding video: $mysqli->error<br>";
            $mysqli->close();
            return 0;
    }
          
              /*  END VIDEO ADDERS **************************************/
    
    /******************** START MEMBER ADDERS ***/
    
    /** Karl TODO analyze the errors that could occur
      *@param memberInfo - mapping: field2Insert => Value2Insert
      *@return 1 for success, 0 for failure
      *@spec creates new history and contact records for this member
      *@spec position ID picked from a lst
      *calling getMaxIDs 
      */
    function addMember($memberInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            echo "Error: cannot connect to database. Try again later<br>.";
            return 0;
        }

        $maxIDs= getMaxIDs( array("Members","MembersHistory"), $mysqli );
        if ( !$maxIDs ) {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return 0;
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
            echo "Error: $mysqli->error<br>";
            $mysqli->close();
            return 0;
        }
        $mysqli->close();
        return 1;
        
    }
    
    /*   END MEMBER ADDERS ***********************************/
    
    /******************** START PERFORMANCE ADDERS ***/
    
    /** Karl
      *@param performanceInfo - mapping: [field2Insert] => [value2Insert]
      *@return 1 for success, 0 otherwise
      *@calling getMaxIDs
      */
    function addPerformance($performanceInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            echo "Error: cannot connect to database. Try again later<br>.";
            return 0;
        }
        //get max idPerformances from Performances table
        $maxID= getMaxIDs( array("Performances"), $mysqli );
        if ( !$maxID ) {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return 0;
        }
        $id= $maxID["maxPerformanceID"] + 1;
        $query= "INSERT INTO Performances VALUES idPerformances = $id";
        foreach ( $performanceInfo as $field => $value ) {
            $query= $query.", $field = \"$value\"";    
        }
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return 0;
        }
        $mysqli->close();
        return 1;
        
    }
    
    /*   END PERFORMANCE ADDERS ******************************/
    
    /******************** START GENRE ADDERS ***/
    
    /** Karl
      *@param genreInfo - single entry mapping: "genre" -> [genreName]
      *@return 1 for success, 0 otherwise
      *@adds one genre to the database, if not already there
      *@calling getMaxIDs
      */
    function addGenre($genreInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            echo "Error: cannot connect to database. Try again later<br>.";
            return 0;
        }
        $genreName= $genreInfo["genre"];
        
        //if genreName is already in Genres table, do nothing, return 1
        $query= "SELECT * FROM Genres WHERE genreName = $genreName";
        $res= $mysqli->query ( $query );
        if ( !$res ) {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return 0; 
        }
        if ( $res->num_rows == 1 ) {
            echo "$genreName is already in the database<br>";
            return 1;
        }
        //genreName must then be new. Insert it
        $maxID= getMaxIDs( array("Genres"), $mysqli );
        if ( !$maxID ) {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return 0;
        }   
        $id= $maxID["maxGenreID"] + 1;
        
        $query= "INSERT INTO Genres VALUES idGenres = $id, genreName = $genreName";
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return 0;
        }
        $mysqli->close();
        return 1;
    }
    
    /*   END GENRE ADDERS  ***********************************/
    
    /******************* START PICTURE ADDERS ***/
    
    /** Karl
      *@param pictureInfo - single entry mapping: "urlP" -> [url]
      *@return 1 for success, 0 otherwise
      *@spec adds one picture to the database
      *@calling getMaxIDs
      *@caller storePicture
      *@note helper: Call storePicture instead
      */
    function addPicture($pictureInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            echo "Error: cannot connect to database. Try again later<br>.";
            return 0;
        }
        //retrieve max idPictures from Pictures table
        $maxID= getMaxIDs( array("Pictures"), $mysqli );
        if ( !$maxID ) {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return 0;
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
            echo "$mysqli->error<br>";
            $mysqli->close();
            return 0;
        }
        $mysqli->close();
        echo "picture successfully uploaded<br>";
        return 1;
    }
    
    /** Karl
      *@param tempLocation - the temporary path to the uploaded picture
      *@photoName - the title of the picture file uploaded
      *@return 1 for success, 0  on failure
      *@spec move picture from temp storage to 'pictures' directory.
             if it does not exist, create it first
      *@calling addPicture
      *@note TODO: verify path logic
      */
    function storePicture($tempLocation, $photoName, $pictureInfo){
        if ( !file_exists ( "/pictures" ) {
            //create folder
            if ( !mkdir ( "/pictures" ) ) {
                echo "Error creathing 'pictures' directory<br>";
                return 0;
            }
        }
          move_uploaded_file( $tempLocation, "pictures/".$photoName );
          return addPicture( $pictureInfo );
    }
    
    /*   END PICTURE ADDERS **********************************/
    
    /*****************************START   POSITION ADDERS ****/
    
    /** Karl
      *@param positionInfo - single entry mapping: "title" -> [position]
      *@return 1 for success or input titlt already existed, 0 otherwise
      *@adds one position to the database, if not already there
      *@calling getMaxIDs
      */
    function addPosition($positionInfo) {
       require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            echo "Error: cannot connect to database. Try again later<br>.";
            return 0;
        }
        $positionTitle= $positionInfo["title"];
        
        //if positionTitle is already in Positions table, do nothing, return 1
        $query= "SELECT * FROM Positions WHERE position = $positionTitle";
        $res= $mysqli->query ( $query );
        if ( !$res ) {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return 0; 
        }
        if ( $res->num_rows == 1 ) {
            echo "$positionTitle is already in the database<br>";
            return 1;
        }
        //positionTitle must then be new. Insert it
        $maxID= getMaxIDs( array("Positions"), $mysqli );
        if ( !$maxID ) {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return 0;
        }   
        $id= $maxID["maxPositionID"] + 1;
        
        $query= "INSERT INTO Positions VALUES idPositions = $id, position = $positionTitle";
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            echo "$mysqli->error<br>";
            $mysqli->close();
            return 0;
        }
        $mysqli->close();
        return 1;   
    }
    
    /*   END POSITION ADDERS ***************************/
?>          
