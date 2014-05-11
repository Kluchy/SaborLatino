<?php
include_once "../Database/adders.php";
include_once "../Database/getters.php";

/** Karl
  *@calling getPerformances
  *@caller addPictureform, addVideoForm
  *@return html for content of a select input box
  */
  function getPerformancesOptions() {
    $res= getPerformances();
    $performances= $res[0];
    $error= $res[1];
    $options="";
    if ( $error ) {
        echo "$error";
        exit();
    }
    foreach( $performances as $performance ) {
        $id= $performance["idPerformances"];
        $title= $performance["performanceTitle"];
        $location= $performance["performanceLocation"];
        $date= $performance["performanceDate"];
        $options= $options."<option value=$id> $title - $location - $date </option>";
     }
     return $options;    
  }


/** Karl
	  *@calling getPositions
	  *@spec displays the "Add Member" section of the Add Page
	  *@spec stops rendering page + displays error if occurrs
	  */
	function addMemberForm() {
        ?>
        <form action="add.php" method="post">
          <h1>Add a new member to the group</h1>
          <br>
        
          First Name <input type="text" name="firstName">
          <br>
          Last Name <input type="text" name="lastName">
          <br>
          Class Year <input type="text" name="year"> (yyyy)
          <br>
          Bio <textarea name="bio"> Enter a short biography here </textarea>
          <br>
        
          E-Mail <input type="text" name="email">
          <br>
          Phone <input type="text" name="phone"> (9 digits e.g:1234567890)
          <br>
          Country of Residence <input type="text" name="country">
          <br>
          State <input type="text" name="state"> (if U.S. e.g: NY, NJ)
          <br>
          City <input type="text" name="city">
          <br>
        
        If you wish, add one position this member has held or is currently holding.
        If this person can be associated with more than one role, you may add the
        others by using the Update Form.
          
          <br>
          Position <select name="positionID">
        <?php
            $res= getPositions();
            $positions= $res[0];
            $error= $res[1];
            $options= "";
            if ( $error ) {
                echo "$error";
                exit();
            }
            foreach( $positions as $record ) {
                $id= $record["idPositions"];
                $name= $record["position"];
                $options= $options."<option value=$id> $name </option>";
            }
            print($options);
        ?>
        </select>
          <br>
          Start Date <input type="text" name="startDate"> (yyy-mm-dd)
          <br>
          If this is not a role currently undertaken by this person, enter
          an end date below:
          <br>
          End Date <input type="text" name="endDate"> (yyyy-mm-dd)
          <br>
          <input type="submit" name="addMember" value="Add Member">
        
        <br><br><br>
        </form>
        <?php
    }
    
    /** Karl
      *@calling getGenres, getPerformances
      *@spec displays the "addVideo" section of the Add Page
      *@spec stops rendering page + displays error if occurrs
      */
    function addVideoForm() {
        ?>
        <form action="add.php" method="post">
         <h1> Add a new Video </h1>
         <br>
         Paste a link to the video here:
         <input type="text" name="urlV">
         <br>
         Add a short description for this video:
         <input type="text" name="captionV">
         <br>
         Dance genre depicted in video:
         <br>
         <select name="genreID">
         <?php
         $res= getGenres();
         $genres= $res[0];
         $error= $res[1];
         $options= "";
         if ( $error ) {
             echo "$error";
             exit();
         }
         foreach ( $genres as $genre ) {
             $id= $genre["idGenres"];
             $name= $genre["genreName"];    
             $options= $options."<option value=$id> $name </option>"; 
         }
         print($options);
         ?>
         </select>
         <br>
         Link this video to a Sabor performance:
         <br>
         <select name="performanceID">
         <?php
         $options= getPerformancesOptions();
         print($options);
         ?>
         </select>
         <br>
         <input type="submit" name="addVideo" value="Add Video">
         
         <br><br><br>
        </form>
        <?php
    }
    
    /** Karl
      *@spec displays the 'addPerformance' section of the Admin Page
      */
    function addPerformanceForm() {
        ?>
        <form action="add.php" method="post">
         <h1>Add a new Performance</h1>
         <br>
         Name of Event <input type="text" name="performanceTitle">
         <br>
         Location of Event <input type="text" name="performanceLocation">
         <br>
         Date of Event <input type="text" name="performanceDate">
         <br>
         <input type="submit" name="addPerformance" value="Add Performance">
         
         <br><br><br>
        </form>
        <?php
    }
    
    /** Karl
      *@spec displays the "add Genre" section of the add page 
      */
    function addGenreForm() {
        ?>
        <form action="add.php" method="post">
         <h1>Add a new Dance Genre</h1>
         <br>
         New Genre <input type="text" name="genreName">
         <br>
         <input type="submit" name="addGenre" value="Add Genre">
         
         <br><br><br>
        </form>
        <?php
    }
    
    /** Karl
      *@spec displays the "add Position" section of the add page
      */
    function addPositionForm() {
        ?>
        <form action="add.php" method="post">
         <h1>Add a new Position</h1>
         <br>
         New Position <input type="text" name="position">
         <br>
         <input type="submit" name="addPosition" value="Add Position">
         
         <br><br><br>
        </form>
        <?php
    }
    
    /** Karl
      *@spec displays the "add Picture" section of the add page
      *@spec stops rendering page + displays error if occurrs
      *@calling getPerformancesOptions, getMemberRecords
      */
    function addPictureForm() {
        ?>
        <form action="add.php" method="post" enctype="multipart/form-data">
         <h1> Add a new Picture</h1>
         <br>
         <input type="file" name="file" id="file">
         <br>
         Add Caption <input type="text" name="captionP">
         <br>
         Link this picture to a performance:
         <br>
         <select name="performanceID">
         <?php
          $options= getPerformancesOptions();
          print($options);
         ?>
         </select>
         <br>
         Set this image as a member's profile picture:
         <br>
         <select name="memberID">
         <?php
           $res= getMemberRecords();
           $members= $res[0];
           $error= $res[1];
           $options= "";
           if ( $error ) {
               echo "$error";
               exit();
           }
           foreach( $members as $mem ) {
            $id= $mem["idMembers"];
            $firstName= $mem["firstName"];
            $lastName= $mem["lastName"]; 
            $options= $options."<option value=$id> $firstName $lastName </option>";   
           }
           print($options); 
         ?>
         </select>
         <br>
         <input type="submit" id="addPicture" name="addPicture" value="Add Picture">
         
         <br><br><br>
        </form>
        <?php
    }
?>