<?php
    include "helpers.php";
    require_once('config.php');
    include "getters.php";
?>
<?php/**Derek
 * @param None
 * @return Associative array that contains the matches searched vidoes. videoID and url only. 
 * videoID => Associative array of video's info.
 * @spec If no qualifying fields are identified, basically returns all videos.
 * @caller Search results page
 * @USE: Use the returned associative array in another PHP page to display matched video results.
 */
function searchVideos() {

   $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
   if (!$mysqli) {
       echo "Error: cannot connect to database. Try again later<br>.";
       return null;
   }

   $anySearch = false; //Set to true only if some search field is used, otherwise all videos are returned.

    if(isset($_POST[/*Search field 1 -> Associated html search element */)) {
        $query[1] = /*Search field 1 */ ' REGEXP '. trim($_POST[/*Search field 1 -> Associated html search elemnt */]); 
        $anySearch = true;
    }
    if(isset($_POST[/*Search field 2 -> Associated html search element */)) {
        $query[1] = /*Search field 2 */ ' REGEXP '. trim($_POST[/*Search field 2 -> Associated html search elemnt */]); 
        $anySearch = true;
    }
    /**Repeat above chunk of code(the if-statement) for all qualifying search fields */

    if($anySearch) {
        $query[0] = 'SELECT idVideos FROM VIDEOS WHERE ';
    }
    else {
        $query[0] = 'SELECT idVideos FROM VIDEOS';
    }

    /**Above cases and code may be modified if we decide to search based on fields in other tables, in which case we will need to change some
     * of the query code. */


    $finalQuery = implode(' AND ', $query);


    /**Then, query database to get videoID's and url's for each matched video from the search. */
    /**Return results of query using fetch_assoc to generate the associative array.*/

    /**This function will be called upon by the html/php page that deals with displaying the search results. */
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
}

/**Derek
 * @param assocArray - Associated array of record information that will be used here to help create the HTML display logic for the thumbnails.
 * @return An html string that displays the videos properly in thumbnail form.
 * @spec None
 * @caller function loadVideos -> This is only a display helper function
 * NOTE to GRADERS: This function is a part of display logic and will be moved to a seperate file when more code has been written.
 * */
function displayThumbnails($assocArray) {

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

?>
