<?php
include_once "../Database/getters.php";
include_once "../Database/helpers.php";
include_once "displayfunctions.php";


function updateMemberForm() {
        ?>
        <form action="memberInfo.php" method="get">
        <?php
           displayMemberSelect(); 
        ?>
          <input type="submit" name="updateMember" value="Update Member">
        </form>
        
        <form action="members.php" method="get">
		  <?php
			displayMemberSelect(); 
          ?>
          <input type="submit" name="remove" value="Delete Member">
        </form>
        <?php          
}

function updateVideoForm() {
    ?>
    <form action="updateDB.php" method="post">
        <select name="videoID">
        <?php
        $res= getVideos();
        $videos= $res[0];
        $error= $res[1];
        $options= "";
        if ( $error ) {
            echo "$error";
            exit();
        }
        foreach( $videos as $video ) {
            $id= $video["idVideos"];
            $caption= $video["captionV"];
            $options= $options."<option value=$id> $caption </option>";
        }
        print($options);
        ?>
        </select>
        <input type="submit" name="updateVideo" value="Update Video">
    </form>    
    
    <form action="update.php" method="post">
      <input type="submit" name="removeVideo" value="Delete Video">
    </form>
    <?php
}

//Displays update/delete performances form.
function updatePerformanceForm() {
    ?> 
    <form action = "update.php" method = "post">
        <select id = "performanceSelect" name = "performanceSelect">
    <?php
    $performances = getPerformances();
    $error = $performances[1];
    $performances = $performances[0];
    if ( $error ) {
        echo "$error";
        exit();
    }
    foreach($performances as $perf) {
        $id = $perf["idPerformances"];
        $title = $perf["performanceTitle"];
        $date = $perf["performanceDate"];
        echo '<option value = "'.$id.'">'.$title.' - '.$date. '</option>';
    }
    
?>
        </select>
        <input type="submit" name="updatePerf" value="Update Performance">
      <input type="submit" name="removePerf" value="Delete Performance">
    </form>    
    

<?php
}
    //Displays update/delete form that actually performs the necessary calendar and database functions.
    function updatePerformancesActionForm($id) {
        echo '
        <form action="update.php" method="post">
         <h1>Update a Performance</h1>
         <input type = "hidden" name = "hidden" value = "'.$id.'" />
         <br>
         Name of Event <input type="text" name="performanceTitle">
         <br>
         Location of Event <input type="text" name="performanceLocation">
         <br>
         Date of Event <input type="text" name="performanceDate">(yyyy-mm-dd)
         <br>
         Start time <select id = "startHour" name = "startHour">';
?>
<?php
        $time = timeHelper();
        echo $time[0].'</select>';
        echo '<select id = "startMinutes" name = "startMinutes">';
        echo $time[1].'</select><select id = "startampm" name = "startampm">'.$time[2].'</select><br>';
        echo 'End time <select id = "endHour" name = "endHour">';
        echo $time[0].'</select>';
        echo '<select id = "endMinutes" name = "endMinutes">';
        echo $time[1].'</select><select id = "endampm" name = "endampm">'.$time[2].'</select><br>';
?>
         <input type="submit" name="updatePerformance" value="Add Performance">
         
         <br><br><br>
        </form>
<?php     
    }

    //update/delete genre form
    function updateGenreForm() {
        $genres = getGenres();
        $error = $genres[1];
        $genres = $genres[0];
        if ( $error ) {
            echo "$error";
            exit();
        }
        echo '<form action = "update.php" method = "post"><select id = "genreSelect" name = "genreSelect">';
        foreach($genres as $genre) {
            echo '<option value = "'.$genre["idGenres"].'">'.$genre["genreName"].'</option>';
        }
        echo '</select>';

        echo '<input type="submit" name="updateGen" value="Update Genre">
      <input type="submit" name="removeGen" value="Delete Genre">
    </form>';    

    }

    //Displays update/delete positions form.
    function updatePositionForm() {
        $pos = getPositions();
        $error = $pos[1];
        $pos = $pos[0];
        if ( $error ) {
            echo "$error";
            exit();
        }
        echo '<form action = "update.php" method = "post"><select id = "positionSelect" name = "positionSelect">';
        foreach($pos as $position) {
            echo '<option value = "'.$position["idPositions"].'">'.$position["position"].'</option>';
        }
        echo '</select>';
    
        echo '<input type="submit" name="updatePos" value="Update Position">
      <input type="submit" name="removePos" value="Delete Position">
    </form>';    

}

    //Displays update/delete picture form.
    function updatePictureForm() {
        $pic = getPictures();
        $error = $pic[1];
        $pic = $pic[0];
        if ( $error ) {
            echo "$error";
            exit();
        }
        echo '<form action = "update.php" method = "post"><select id = "pictureSelect" name = "pictureSelect">';
        foreach($pic as $picture) {
            echo '<option value = "'.$picture["idPictures"].'">'.$picture["urlP"].' - '.$picture["captionP"].'</option>';
        }
        echo '</select>';
    
        echo '<input type="submit" name="updatePic" value="Update Picture">
      <input type="submit" name="removePic" value="Delete Picture">
    </form>';    
   }


    //Displays action form for updating genre.
    function updateGenreActionForm($id) {
        echo '<form action="update.php" method="post">
         <h1>Update a Dance Genre</h1>
         <input type = "hidden" name = "hidden" value = "'.$id.'" />
         <br>
         New Genre <input type="text" name="genreName">
         <br>
         <input type="submit" name="updateGenre" value="Update Genre">
         
         <br><br><br>
        </form>';

    }
    
    //Displays action form for actually modifying positions.
    function updatePositionActionForm($id) {
        echo '<form action="update.php" method="post">
         <h1>Update a Position</h1>
         <input type = "hidden" name = "hidden" value = "'.$id.'" />
         <br>
         New Position <input type="text" name="position">
         <br>
         <input type="submit" name="updatePosition" value="Update Position">
         
         <br><br><br>
         </form>';
    }
    
    //Displays action form for actually modifying pictures.
    function updatePictureActionForm($id) {
        echo '<form action="update.php" method="post" enctype="multipart/form-data" >
         <h1> Update new Picture</h1>
         <input type = "hidden" name = "hidden" value = "'.$id.'" />
         <br>
         <input type="file" name="file" id="file">
         <br>
         Add Caption <input type="text" name="captionP">
         <br>
         Link this picture to a performance:
         <br>';
            displayPerformanceSelect();
         echo '<br>
         Set this image as a member\'s profile picture:
         <br>';
           displayMemberSelect();
         echo '<br>
         <input type="submit" id="updatePicture" name="updatePicture" value="Update Picture">
         
         <br><br><br>

         </form>';
    }




?>


