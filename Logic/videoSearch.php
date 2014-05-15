<?php
    include_once "../Database/helpers.php";
    require_once('../Database/config.php');
    include_once "../Database/getters.php";
    include_once "../Database/modifiers.php";
    include_once "checkinput.php";
    include_once "updateForms.php";

/**Derek
 * @param None
 * @return Associative array that contains the matches searched vidoes. videoID and url only. 
 * videoID => Associative array of video's info.
 * @spec If no qualifying fields are identified, basically returns all videos.
 * @caller Search results page
 * @USE: Use the returned associative array in another PHP page to display matched video results.
 */
function searchVideosReturn() {

   $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
   if (!$mysqli) {
       echo "Error: cannot connect to database. Try again later<br>.";
       return null;
   }
    $searchArray = array();

    if($_POST['yearPerformed'] && trim(htmlentities($_POST['yearPerformed'])) != "") {
        $searchArray["year"] =  trim(htmlentities($_POST['yearPerformed']));
    }    
    if($_POST['genre'] && trim(htmlentities($_POST['genre'])) != "") {
        $searchArray["genreName"] = trim(htmlentities($_POST['genre']));
    }    
    if($_POST['performers'] && trim(htmlentities($_POST['performers'])) != "") {
        $searchArray["firstName"] = trim(htmlentities($_POST['performers']));
        $searchArray["lastName"] = trim(htmlentities($_POST['performers']));
    }    
    if($_POST['choreographers'] && trim(htmlentities($_POST['choreographers'])) != "") {
        $searchArray["cFirstName"] = trim(htmlentities($_POST['choreographers']));
        $searchArray["cLastName"] = trim(htmlentities($_POST['choreographers']));
    }    
    if($_POST['performanceTitle'] && trim(htmlentities($_POST['performanceTitle'])) != "") {
        $searchArray["performanceTitle"] = trim(htmlentities($_POST['performanceTitle']));
    }    

    $results = searchVideos($searchArray); 
    return $results;


} 
//Checks the video update form and makes necessary DB calls.
function checkVideoUpdateForm() {
    if(isset($_POST['updateVideo'])) {
        $id = $_POST['hidden'];
         //format input
         $videoInfo= formatVideoInput();

        $genreID = $_POST['genreID'];
        $oldGenID = $_POST['hiddenGenre'];
            unset($videoInfo['genreID']);
        $genError = remGenreFromVideo($oldGenID, $id);
        if($genError) {
        }
        else {
            $adderror = addGenreToVideo($genreID, $id);
        }
         //make DB call
            $error= updateVidInfo($id,$videoInfo);
        
        if(isset($_POST['removeMembers'])) {
            $remMems = $_POST['removeMembers'];
            foreach($remMems as $mem) {
                $check = remMemFromVideo($mem, $id);
            }

        }
        if(isset($_POST['addMembers'])) {
            $addMems = $_POST['addMembers'];
            foreach($addMems as $mem) {
                echo "Hello";
                $check = addMemToVideo($mem, $id);
                if($check) {
                    echo $check;
                }
            }

        }
        if(isset($_POST['removeChoreo'])) {

            $remMems = $_POST['removeChoreo'];
            foreach($remMems as $mem) {
                $check = remChoreographerOfVid($mem, $id);
            }

        }
        if(isset($_POST['addChoreo'])) {
            $addMems = $_POST['addChoreo'];
            foreach($addMems as $mem) {
                $check = addChoreographerOfVid($mem, $id);
            }

        }

         //check for error
         if ( $error ) {
             echo "$error";
        } else {
            echo "Succesfully updated video<br>";
        }

    }
    
    if(isset($_POST['deleteVideo'])) {
        $error = deleteVideo($_POST['hidden']);
        if($error) {
            echo $error;
        }
        else {
            echo "Video successfully deleted";
        }
        

    } 

}

/**
 *Derek & Allan
 * @param None
 * @return HTML string that displays the current active video.
 * @Caller Video PHP page
 * */
function loadMainVid() {
    checkVideoUpdateForm();
    if(isset($_POST['vidID']) ) {
        $videoID = $_POST['vidID'];
	}else {
		$videoID = 1;
	}
        $infoDisplay = '';
        $video = getVideoInfo($videoID);
        $video = $video[0];

        $vidID = getVideoID($video['urlV']);
        $embedLink = "<iframe width = \"560\" height= \"315\" 
            src = //www.youtube.com/embed/".$vidID."
             frameborder = \"0\" allowfullscreen class = \"mainVid\">
             </iframe><br>";
		
		// display video info or form to edit videos
		
		if ( isset( $_SESSION["saborAdmin"] ) ) {
			//create the form to edit
            updateVideoActionForm($videoID);
		}else{
			//just display video info
			$vidCaption=$video['captionV'];
			$perfDate=$video['performanceDate'];
			$perfTitle=$video['performanceTitle'];
			$infoDisplay = "<span class=\"vidCaption\">$vidCaption</span><br>
							<span class=\"vidPerf\">$perfDate - $perfTitle
							</span></br>";
			//if there are associated performers, list them
			$res = getMembersForVideo($videoID);
			$error= $res[1];
			if ( !$error ) {
				$vidPerformers = $res[0];
				$performerList = "Performers: <ul id=\"vidPerformers\">";
				foreach ($vidPerformers as $vidPerformer){
					$perfID = $vidPerformer['idMembers'];
					$perfName = $vidPerformer['firstName']." ".$vidPerformer['lastName'];
					$perfLink = "<li><a href=\"memberInfo.php?memberID=$perfID\">$perfName</a></li>";
					$performerList = $performerList.$perfLink;
				}
				$performerList = $performerList."</ul>";
				$infoDisplay = $infoDisplay.$performerList;
			}
		}
		
		$output = $embedLink . $infoDisplay;
        return $output;
} 

/**Derek
 * @param None
 * @return An html string that displays the videos properly in thumbnail form.
 * @spec returns null on error. 
 * @caller Video gallery page */
function loadVideos() {
    /**Subject to change if we decide to store information from other tables (such as the 
        performance table) for when the thumbnail is clicked */
    $assocVideoArray = array(); 

    if(isset($_POST['submit'])) {
        $results = searchVideosReturn();
        $error = $results[1];
        if ( $error ) {
            return;
        }
        $results = $results[0];
        $assocVideoArray = $results;
    }
    else {
        $results = getVideos(); //Associative array with video information to be stored in thumbnails.
        $assocVideoArray= $results[0];
        $error= $results[1];
        if ( $error ) {
            return;
        }
    }
    $displayHTML = displayThumbnails($assocVideoArray); //displayThumbnails will be a function that handles the HTML logic of displaying the thumbnails.
    return $displayHTML;
}

/**Derek
 * @param assocArray - Associated array of record information that will be used here to help create the HTML display logic for the thumbnails.
 * @return An html string that displays the videos properly in thumbnail form.
 * @spec None
 * @caller displayVideos, function loadVideos -> This is only a display helper function
 * NOTE to GRADERS: This function is a part of display logic and will be moved to a seperate file when more code has been written.
 * */
function displayThumbnails($assocArray) {

    $htmlFull = "<div id=\"vidInfo\"><ul>";
    foreach($assocArray as $val) {
            $videoID = getVideoID($val['urlV']);
            $idVideo = $val['idVideos'];
            $title = getVidTitle($videoID);
            $thumbnail = 'http://img.youtube.com/vi/'.$videoID.'/1.jpg';
            $html = 
                '<li>
                <div> 
                <form action = "videos.php" method = "post">
                <input  id="vidThumbnail" type = "image" src = "'.$thumbnail.'" name = "thumbnails" alt = "No image" />
                <input type = "hidden" value = "'.$idVideo.'" name = "vidID" />
                </form>
                </div>
                <h4>'.$title.'</h4></li>';
            $htmlFull = $htmlFull. $html;
    }

        $htmlFull = $htmlFull. '</ul></div>';
        return $htmlFull;

    /* We will use youtube thumbnail image links as the thumbnails. Youtube has an API/urls for us to use here */

    /* Each thumbnail will be a part of a form that upon click of the thumbnail will generate the full-sized video.
     * General format of each thumbnail's HTML:
     * <form action = ... method = "post">
     * ...thumbnail
     * ...Some hiddenvalue inputs for keeping track of which video is associated with which thumbnail
     * </form> */
}
/**Derek
 * @param videoID - videoID of target video to display
 * @return HTML string with video display and associated information
 * @caller Video PHP that displays the video */
function displayVideoInfo($videoID) {
    $info = getVideosInfo($videoID);    

    //Loop through $info and write an html string with all display logic for displaying video and its information.
    
    //return the html string.
}
/**
 *Derek
 * video ID from youtube link
 * @param string $url
 * @return string Youtube video id or FALSE if none found. 
 * @caller The displayThumbnails and loadMainVid functions
 * Note: Help for coding this function received from http://stackoverflow.com/questions/6556559/youtube-api-extract-video-id 
 */
function getVideoID($url) {
    $pattern = 
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x';

    $result = preg_match($pattern, $url, $matches);
    if ($result != false) {
        return $matches[1];
    }
    return false;
    }

/**
 *Derek
 * @param videoID -> Youtube videoID of a video
 * @return -> Returns the youtube video title of the specified video
 * @caller The displayThumbnails function
 * Note: Used http://stackoverflow.com/questions/4690914/youtube-api-title-only for coding help.
 * */
function getVidTitle($videoID) {
   $xmlData = simplexml_load_string(file_get_contents("http://gdata.youtube.com/feeds/api/videos/{$videoID}?fields=title"));

    $title = (string)$xmlData->title; 
    return $title;
}

/**
 *Derek
 *Display search forms in videos
 *@param None
 *@return None
 *@caller Videos page
 * */
function displayVideoSearch() {

    $genres = getGenres();
    $genreString = "";
    $error = $genres[1];
    if($error) {
        return;
    }
    $genres = $genres[0];
    foreach($genres as $genre) {
        $genreString = $genreString. '<option value = "'.$genre["genreName"].'">'.$genre["genreName"].'</option>';
    }

    $dates = retrieve("SELECT Year(performanceDate) as year FROM Performances ORDER BY performanceDate");
    $pString = "";
    $error = $dates[1];
    if($error) {
        return;
    }
    $dates = $dates[0];
    foreach($dates as $date) {
        $pString = $pString. '<option value = "'.$date["year"].'">'.$date["year"].'</option>';
    }

    echo '
        <form action = "videos.php" method = "post" id = "vidSearch">
            <label for = "yearPerformed">Year performed</label>
            <select id = "yearPerformed" name = "yearPerformed">';
    echo $pString; 
    echo '
            </select>
            <label for = "genre">Genre</label>
            <select id = "genre" name = "genre">';
    echo $genreString;
    echo '
            </select>
            <label for = "performers">Performer names</label>
            <input type = "text" id = "performers" name = "performers" />
            <label for = "choreographers">Choreographer names</label>
            <input type = "text" id = "choreographers" name = "choreographers" />
            <label for = "performanceTitle">Performance title</label>
            <input type = "text" id = "performanceTitle" name = "performanceTitle" />
            <input type = "submit" id = "submit" name = "submit" value = "Submit search" />
        </form>
        ';

}
?>
