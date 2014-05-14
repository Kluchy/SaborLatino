<?php
include_once "../Database/getters.php";
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
    </form>    
    
    <form action="update.php" method="post">
      <input type="submit" name="removePerf" value="Delete Performance">
    </form>

<?php


}


?>
