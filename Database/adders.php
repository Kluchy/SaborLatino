<?php
    include_once "helpers.php";
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
        /**if (!$results ) {
            return array( null,  "$mysqli->error<br>" );
        }*/
        //process results and return them as an associative array.
        $ids= array();
        $firstResult= $mysqli->store_result();//get result of first query
        //print_r ($firstResult);
        // initialize 'ids' with the results of the first query
        $ids= $firstResult->fetch_assoc();
        $firstResult->free();
        $numExpectedResults= count( $typeList );//number of results expected based on input
        
        //$nextResult= ;//get result of second query (or null if there is not one)
        $numResultsSeen= 1;// 1 for the first result
        while ( $mysqli->more_results() && $mysqli->next_result() ) {
            if ( $nextResult= $mysqli->store_result() ) {
                //for each successful query, append its results to 'ids' array
                $ids= array_merge( $ids, $nextResult->fetch_assoc() );
                //echo "ids are: ";
                //print_r($ids);
                $numResultsSeen= $numResultsSeen + 1;
                $nextResult->free();
            }  
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
        $maxIDs= $result[0];
        $error= $result[1];
        if ( $error ) {
            $mysqli->close();
            return $error;
        }
         
        $id= $maxIDs["maxVideoID"] + 1;
        $videosSchema= array ( "urlV", "captionV", "performanceID" );
        $genresSchema= array ( "genreID" );
        
        $videoQueryP1= "INSERT INTO Videos(idVideos";
        $videoQueryP2= "VALUES( $id";
        $genreQuery= ""; 
        //extend videoQuery and genreQueries with corresponding field => value pairs
        foreach ( $videoInfo as $field => $value ) {
            //for Videos, extend the one record we are inserting with the pair
            if ( in_array ( $field, $videosSchema ) ) {
                $videoQueryP1= $videoQueryP1.", $field";
                // value is a number if field is 'performanceID so no escape quotes needed.
                if ( $field == "performanceID" ) {
                    $videoQueryP2= $videoQueryP2.", $value";
                } else {
                    $videoQueryP2= $videoQueryP2.", \"$value\"";
                }
                
            } elseif ( in_array ( $field, $genresSchema ) ) {
                    $genreQuery= "INSERT INTO GenresInVid( genreID, videoID ) VALUES ($value, $id)";           
            }
        }
        if ( $genreQuery == "" ) {
            //default genre to "mix" genre
            $genreQuery= "INSERT INTO GenresInVid( genreID, videoID ) VALUES (0, $videoID)";
        }
        //append queries for genres to the query for the video
        //because we need to insert the video before linking genres to it
        $videoQuery= $videoQueryP1.") ".$videoQueryP2." )";
        $multiQuery= $videoQuery.";".$genreQuery.";";
        $results= $mysqli->multi_query ( $multiQuery );
        
        $videoInserted= $mysqli->store_result();//get the result for the video query
        $genreInserted= $mysqli->store_result();//get the result for the genre query 
        if ( $videoInserted && $genreInserted ) {
            //success
            $mysqli->close();
            return null;    
        } else {
            $msg= "Error adding video: $mysqli->error<br>";
            $mysqli->close();
            return $msg;
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
        $memberSchema= array ( "firstName", "lastName", "year", "bio" );
        $contactSchema= array ( "email", "phone", "country", "state", "city" );
        $historySchema= array ( "positionID", "startDate", "endDate" );
        
        $memberQueryP1= "INSERT INTO Members( idMembers";
        $contactQueryP1= "INSERT INTO MemberContactInfo( memberID";
        $historyQueryP1= "INSERT INTO MembersHistory( idHistory, memberID";
        
        $memberQueryP2= "VALUES( $id";
        $contactQueryP2= "VALUES( $id";
        $historyQueryP2= "VALUES( $hID,  $id"; 
        
        //build queries by adding field and value to appropriate table
        foreach ( $memberInfo as $field => $value ) {
            if ( in_array ( $field, $memberSchema ) ) {
                // 'year': in database it is an int, so we can't have escaped quotes
                $memberQueryP1= $memberQueryP1.", $field";
                if ( $field == "year" ) {            
                    $memberQueryP2= $memberQueryP2.", $value";
                } else {    
                    $memberQueryP2= $memberQueryP2.", \"$value\"";
                }
                
            } elseif ( in_array ( $field, $contactSchema ) ) {
                $contactQueryP1= $contactQueryP1.", $field";
                if ( $field == "phone" ) {
                    $contactQueryP2= $contactQueryP2.", $value";
                } else {
                    $contactQueryP2= $contactQueryP2.", \"$value\"";
                }
                
            } elseif ( in_array ( $field, $historySchema ) ) {
                $historyQueryP1= $historyQueryP1.", $field";
                if ( $field == "positionID" ) {
                    $historyQueryP2= $historyQueryP2.", $value";
                } else {
                    $historyQueryP2= $historyQueryP2.", \"$value\"";
                }
            }   
        }
        //concatenate all queries. Should we make this a transaction 
        // in order to roll back if one of them fails???
        $memberQuery= $memberQueryP1.") ".$memberQueryP2.")";
        $contactQuery= $contactQueryP1.") ".$contactQueryP2.")";
        $historyQuery= $historyQueryP1.") ".$historyQueryP2.")";
        $multiQuery= $memberQuery.";".$contactQuery.";".$historyQuery.";";
        echo "Query is: $multiQuery<br>";
        $results= $mysqli->multi_query ( $multiQuery );
        
        //TODO analyze the errors that could occur in this triple query.
        //TODO fix the calls to store_result below. Code thins there is an error when there is not
        
        //get result of insert into Members table.
        $memberInserted= $mysqli->store_result();
        //get result of insert into MemberContactInfo table.
        $contactInserted= $mysqli->store_result();
        //get result of insert into MembersHistory table.
        $historyInserted= $mysqli->store_result();
        //print_r($memberInserted);
        //print_r($contactInserted);
        //print_r($historyInserted);
        if ( !$memberInserted || !$contactInserted || !$historyInserted ) {
            $msg= "Error adding to Members: $mysqli->error<br>";
            $mysqli->close();
            return "$msg";
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
        $query1 = "INSERT INTO Performances (idPerformances";
        $query2 = "VALUES($id";
        $query= "INSERT INTO Performances VALUES idPerformances = $id";
        foreach ( $performanceInfo as $field => $value ) {
            $query1 = $query1.", $field";    
            $query2 = $query2.", \"$value\"";
        }
        $query = $query1. ") ". $query2.")";
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            $err = $mysqli->error;
            $mysqli->close();
            return array("$err<br>",null);
        }
        $eventID = $mysqli->insert_id;
        $mysqli->close();
        return array(null, $eventID);
        
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
        $genreName= $genreInfo["genreName"];
        
        //if genreName is already in Genres table, do nothing, return null
        $query= "SELECT * FROM Genres WHERE genreName = \"$genreName\" ";
        $res= $mysqli->query ( $query );
        if ( !$res ) {
            $msg= "$mysqli->error<br>"; 
            $mysqli->close();
            return $msg;
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
        
        $query= "INSERT INTO Genres(idGenres, genreName) VALUES ($id, \"$genreName\") ";
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            $msg= "$mysqli->error<br>";
            $mysqli->close();
            return $msg;
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
      *@note helper: Call storePicture with haslink=0 instead
      */
    function addPicture($pictureInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>";
        }
        //check if picture already in DB
        $urlP= $pictureInfo["urlP"];
        $result= $mysqli->query("SELECT * FROM Pictures WHERE urlP = \"$urlP\"");
        if ( !$result ) {
            $msg= "$mysqli->error<br>";
            $mysqli->close();
            return $msg;
        }
        if ($result->num_rows == 1) {
            return null;
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
        
        $queryP1= "INSERT INTO Pictures( idPictures";
        $queryP2= "VALUES ($id";
        foreach ( $pictureInfo as $field => $value ) {
            $queryP1= $queryP1.", $field";
            if ( $field == "performanceID" ) {
                $queryP2= $queryP2.", $value";
            } else {
                $queryP2= $queryP2.", \"$value\"";
            }    
        }
        $query= $queryP1.") ".$queryP2.")";
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            $msg= "$mysqli->error<br>";
            $mysqli->close();
            return $msg;
        }
        $mysqli->close();
        return null;
    }
    
    /** Karl
      *@param pictureInfo - single entry mapping: "urlP" -> [url]
      *@return null for success, error message otherwise
      *@spec adds one picture to the database + links picture to memberId in pictureInfo
      *@calling getMaxIDs
      *@caller storePicture
      *@note helper: Call storePicture with last arg= 1 instead
      */
    function addPictureWithLink($pictureInfo) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            return "Error: cannot connect to database. Try again later<br>";
        }
        //check if picture already in DB
        $urlP= $pictureInfo["urlP"];
        $result= $mysqli->query("SELECT * FROM Pictures WHERE urlP = \"$urlP\"");
        if ( !$result ) {
            $msg= "$mysqli->error<br>";
            $mysqli->close();
            return $msg;
        }
        if ($result->num_rows == 1) {
            return null;
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
        $memberID= -1;
        
        $queryP1= "INSERT INTO Pictures( idPictures";
        $queryP2= "VALUES ($id";
        foreach ( $pictureInfo as $field => $value ) {
            if ( $field == "memberID" ) {
                $memberID= $value;
            } else {
                $queryP1= $queryP1.", $field";
                if ( $field == "performanceID" ) {
                    $queryP2= $queryP2.", $value";
                } else {
                    $queryP2= $queryP2.", \"$value\"";
                }
            }    
        }
        $query= $queryP1.") ".$queryP2.")";
        $query= $query."; UPDATE Members SET pictureID = $id 
                                        WHERE idMembers = $memberID;";
        $result= $mysqli->multi_query ( $query );
        if ( !$result ) {
            $msg= "$mysqli->error<br>";
            $mysqli->close();
            return $msg;
        }
        $mysqli->close();
        return null;
    }
    
    /** Karl
      *@param tempLocation - the temporary path to the uploaded picture
      *@param photoName - the title of the picture file uploaded
      *@param pictureInfo - associative array with metadata for picture
      *@param 
      *@return null for success, error message  on failure
      *@spec move picture from temp storage to 'pictures' directory.
             if it does not exist, create it first
      *@calling addPicture, addPictureWithLink
      *@note TODO: verify path logic
      */
    function storePicture($tempLocation, $photoName, $pictureInfo, $hasLink) {
        if ( !file_exists ( "../img" ) ) {
            //create folder
            if ( !mkdir ( "../img" ) ) {
                return "Error creating 'img' directory<br>";
            }
        }
          move_uploaded_file( $tempLocation, "../img/".$photoName );
          if ( $hasLink ) {
            return addPictureWithLink( $pictureInfo );
          } else {
            return addPicture( $pictureInfo );
          }
    }
    
    //Same as above, but for updating photo.
    function storePictureUpdate($tempLocation, $photoName, $pictureInfo, $hasLink) {
        if ( !file_exists ( "../img" ) ) {
            //create folder
            if ( !mkdir ( "../img" ) ) {
                return "Error creating 'img' directory<br>";
            }
        }
          move_uploaded_file( $tempLocation, "../img/".$photoName );
            return updatePicInfo($pictureInfo);
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
        $positionTitle= $positionInfo["position"];
        
        //if positionTitle is already in Positions table, do nothing, return 1
        $query= "SELECT * FROM Positions WHERE position = \"$positionTitle\" ";
        $res= $mysqli->query ( $query );
        if ( !$res ) {
            $msg= "$mysqli->error<br>"; 
            $mysqli->close();
            return $msg;
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
        
        $query= "INSERT INTO Positions( idPositions, position ) VALUES( $id, \"$positionTitle\" )";
        $result= $mysqli->query ( $query );
        if ( !$result ) {
            $msg= "$mysqli->error<br>";
            $mysqli->close();
            return $msg;
        }
        $mysqli->close();
        return null;   
    }
    
    /*   END POSITION ADDERS ***************************/
?>          
