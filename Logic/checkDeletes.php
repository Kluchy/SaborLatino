<?php

include_once '../Database/modifiers.php';
include_once '../Database/getters.php';
include_once 'calendar.php';

/**Derek
 * @param None
 * @return None
 * @Caller update.php
 * Handles if deletes were clicked on the updates.php form.
 * */
function checkDeletes() {
}
if(isset($_POST["removePerf"])) {

    $id = $_POST['performanceSelect'];
    $error = deletePerformance($id);
    if($error) {
        echo $error; 
    }
    else {
        echo 'Performance successfully deleted';
        $user = 'saborlatinoeventscal@gmail.com';
        $pass = 'skemabsabor';
        $service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME; // predefined service name for calendar

        $client = Zend_Gdata_ClientLogin::getHttpClient($user,$pass,$service);
        //deleteCalendarEvent($client, $id);
    }

}

if(isset($_POST["removeGen"])) {
    $id = $_POST["genreSelect"];
    $error = deleteGenre($id);
    if($error) {
        echo $error; 
    }
    else {
        echo 'Genre succesfully deleted';
    }
}

if(isset($_POST["removePos"])) {
    $id = $_POST["positionSelect"];
    $error = deletePosition($id);
    if($error) {
        echo $error; 
    }
    else {
        echo 'Position succesfully deleted';
    }
}

if(isset($_POST["removePic"])) {
    $id = $_POST["pictureSelect"];
    $pic = getPicture($id);
    $pic = $pic[0];
    $pic = $pic[0];
    $url = $pic["urlP"];
    $error = deletePicture($id, $url);
    if($error) {
        echo $error; 
    }
    else {
        echo 'Picture succesfully deleted';
    }
}




?>
