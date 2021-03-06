<?php
include_once "../Database/adders.php";
include_once "../Database/getters.php";
include_once "../Database/helpers.php";
include_once "displayfunctions.php";


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
          Short Bio <textarea name="bio"></textarea>
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
        <?php
            displayPositionSelect(0);
        ?>
          <br>
          Start Date <input type="text" name="startDate"> (yyyy-mm-dd)
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
      *@calling displayGenreSelect, displayPerformanceSelect
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
         <?php
         //default genre should be "mixed"
         displayGenreSelect(0);
         ?>
         <br>
         Link this video to a Sabor performance:
         <br>
         <?php
            displayPerformanceSelect(0);
         ?>
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
         Date of Event <input type="text" name="performanceDate">(yyyy-mm-dd)
         <br>
         Start time <select id = "startHour" name = "startHour">
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
      *@calling displayPerformanceSelect, displayMemberSelect
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
         <?php
            displayPerformanceSelect(0);
         ?>
         <br>
         Set this image as a member's profile picture:
         <br>
         <?php
           displayMemberSelect();
         ?>
         <br>
         <input type="submit" id="addPicture" name="addPicture" value="Add Picture">
         
         <br><br><br>
        </form>
        <?php
    }
?>
