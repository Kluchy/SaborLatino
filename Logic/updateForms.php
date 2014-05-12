<?php
include_once "../Database/getters.php";
include_once "displayfunctions.php";

/*********** NOT USING THIS FILE ANYMORE ******************/
function updateMemberForm() {
        ?>
        <form action="updateDB.php" method="post">
        <?php
           displayMemberSelect(); 
        ?>
          <input type="submit" name="updateMember" value="Update Member">
        </form>
        
        <form action="update.php" method="post">
          <input type="submit" name="deleteMember" value="Delete Member">
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


?>