<?php
    include_once "Database/helpers.php";
    require_once('config.php');
    include_once "Database/getters.php";

/**Derek
 * @param None
 * @return Associative array that contains the matches searched vidoes. videoID and url only. 
 * videoID => Associative array of video's info.
 * @spec If no qualifying fields are identified, basically returns all videos.
 * @caller Search results page
 * @USE: Use the returned associative array in another PHP page to display matched video results.
 */
/*function searchVideos() {

   $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
   if (!$mysqli) {
       echo "Error: cannot connect to database. Try again later<br>.";
       return null;
   }

   $anySearch = false; //Set to true only if some search field is used, otherwise all videos are returned.

    if(isset($_POST[/*Search field 1 -> Associated html search element )) {
        $query[1] = /*Search field 1  ' REGEXP '. trim($_POST[/*Search field 1 -> Associated html search elemnt ]); 
        $anySearch = true;
    }
    if(isset($_POST[/*Search field 2 -> Associated html search element )) {
        $query[1] = /*Search field 2  ' REGEXP '. trim($_POST[/*Search field 2 -> Associated html search elemnt ]); 
        $anySearch = true;
    }
    /**Repeat above chunk of code(the if-statement) for all qualifying search fields 

    if($anySearch) {
        $query[0] = 'SELECT idVideos FROM VIDEOS WHERE ';
    }
    else {
        $query[0] = 'SELECT idVideos FROM VIDEOS';
    }

    /**Above cases and code may be modified if we decide to search based on fields in other tables, in which case we will need to change some
     * of the query code. 



    $finalQuery = implode(' AND ', $query);


    /**Then, query database to get videoID's and url's for each matched video from the search. 
    /**Return results of query using fetch_assoc to generate the associative array.

    /**This function will be called upon by the html/php page that deals with displaying the search results. 
} 

/**
 *Derek
 * @param None
 * @return HTML string that displays the current active video.
 * @Caller Video PHP page
 * */
function loadMainVid() {
    if(isset($_POST['thumbnails_x']) && isset($_POST['thumbnails_y'])) {

        $videoID = $_POST['vidID'];
        $video = getVideoInfo($videoID);
        $video = $video[0];

        $vidID = getVideoID($video['urlV']);
        $embedLink = '<iframe width = "560" height= "315" 
            src = "//www.youtube.com/embed/'.$vidID.'"
             frameborder = "0" allowfullscreen class = "mainVid">
             </iframe>';
        return $embedLink;

    }
    else {
			return '<img src="img/vid_filler.png" alt="This will be a real video!">';
    }
} 

/**Derek
 * @param None
 * @return An html string that displays the videos properly in thumbnail form.
 * @spec returns null on error. 
 * @caller Video gallery page */
function loadVideos() {

    $query = 'SELECT * FROM Videos'; /**Subject to change if we decide to store information from other tables (such as the 
        performance table) for when the thumbnail is clicked */ 
    
    $assocVideoArray = retrieve($query); //Associative array with video information to be stored in thumbnails.
    $displayHTML = displayThumbnails($assocVideoArray); //displayThumbnails will be a function that handles the HTML logic of displaying the thumbnails.
    return $displayHTML;
}

/**Derek
 * @param assocArray - Associated array of record information that will be used here to help create the HTML display logic for the thumbnails.
 * @return An html string that displays the videos properly in thumbnail form.
 * @spec None
 * @caller function loadVideos -> This is only a display helper function
 * NOTE to GRADERS: This function is a part of display logic and will be moved to a seperate file when more code has been written.
 * */
function displayThumbnails($assocArray) {

    $htmlFull = '<ul>';
    foreach($assocArray as $valOuter) {
        if(is_array($valOuter)) {
            foreach($valOuter as $val) {
            $videoID = getVideoID($val['urlV']);
            $idVideo = $val['idVideos'];
            $title = getVidTitle($videoID);
            $thumbnail = 'http://img.youtube.com/vi/'.$videoID.'/1.jpg';
            $html = 
                '<li>
                <form action = "videos.php" method = "post">
                <input type = "image" src = "'.$thumbnail.'" name = "thumbnails" />
                <input type = "hidden" value = "'.$idVideo.'" name = "vidID" />
                </form>
                <h4>'.$title.'</h4></li>';
            $htmlFull = $htmlFull. $html;
            }
        }
    }

        $htmlFull = $htmlFull. '</ul>';
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
        
?>
