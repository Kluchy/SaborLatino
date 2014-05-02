<?php
    include "helpers.php";
?>
<?php
    /******************** START FUNCTIONS DISPLAYING FORMS **************/

    /** Karl
      *@spec displays login form as a div object
      */
    function displayLogin(){
        ?>    
        <div class="login">
            Administrator Login
            <form action="index.php" method="post">
            Username <input type="text" name="username"> <br>
            Password <input type="password" name="password"> <br>
            <input type="submit" name="Login" value="Login">
            </form>
        </div>
        <?php    
    }
    
    /** Karl
      *displays a basic admin form allowing an admin to add elements to the
      *site/database (new members, pictures, videos, performances, dance
      * styles, etc
      *@spec Caller should only vcall this when admin is logged in
      *INCOMPLETE
      *@note Below this function, I also have individual forms for each entity,
      *       as opposed to having all of them displayed at once
      */
    function addForm() {
        ?>
        <div>
        <form action="add.php" method="post">
        Add a new member to the group
        <br>
        
        First Name <input type="text" name="firstName">
        <br>
        Last Name <input type="text" name="lastName">
        <br>
        Class Year <input type="text" name="year">
        <br>
        Bio <textarea name="bio"> Enter a short biography here </textarea>
        <br>
        
        E-Mail <input type="text" name="email">
        <br>
        Phone <input type="text" name="phone">
        <br>
        Country of Residence <input type="text" name"country">
        <br>
        State <input type="text" name="state">
        <br>
        City <input type="text" name="city">
        <br>
        
        If you wish, add one position this member has held or is currently holding.
        If this person can be associated with more than one role, you may add the
        others by using the Update Form.
        <br>
        Position <input type="text" name="position">
        <br>
        Start Date <input type="text" name="startDate">
        <br>
        If this is not a role currently undertaken by this person, enter
        an end date below:
        <br>
        End Date <input type="text" name="endDate">
        <br>
        <input type="submit" name="addMember" value="Add Member">
        
        <br><br><br>
         
        Use this following section to add a new video.
        <br>
        Paste a link to the video here:
        <input type="text" name="urlV">
        <br>
        Or upload a video to the database:
        <br>
        Add a short description for this video:
        <input type="text" name="captionV">
        <br>
        Dance genre depicted in video:
        <br>
        <select name="genres[]">
        <?php
         $genres= getGenres();
         foreach ( $genres as $genre ) {
             $id= $genre["idGenres"];
             $name= $genre["genreName"];    
             echo"<option value=$id> $name </option>"; 
         }
        ?>
        </select>
        <br>
        Link this video to a Sabor performance:
        <br>
        <select name="performanceID">
          <option value="idPerformances"> PerfTitle - PerfLoc - PerfDate </option>
        </select>
         <input type="submit" name="addVideo" value="Add Video">
         
         <br><br><br>
         
         Use the following section to add a new Performance Event.
         <br>
         Name of Event <input type="text" name="performanceTitle">
         <br>
         Location of Event <input type="text" name="performanceLocation">
         <br>
         Date of Event <input type="text" name="performanceDate">
         <br>
         <input type="submit" name="addPerformance" value="Add Performance">
         
         <br><br><br>
         
         Use the following section to add a new Dance Genre.
         <br>
         New Genre <input type="text" name="genreName">
         <br>
         <input type="submit" name="addGenre" value="Add Genre">
         
         <br><br><br>
        </form>
        </div>
        <?php    
    }
    
    function addGenreForm() {
        ?>
        <form action="add.php" method="post">
         Use the following section to add a new Dance Genre.
         <br>
         New Genre <input type="text" name="genreName">
         <br>
         <input type="submit" name="addGenre" value="Add Genre">
         
         <br><br><br>
        </form>
        <?php
    }
    
    function addPictureForm() {
        ?>
        <form action="add.php" method="post" enctype="multipart/form-data">
         Use the following section to add a new Picture.
         <br>
         <input type="file" name="file" id="file">
         <br>
         Add Caption <input type="text" name="captionP">
         <br>
         Link this picture to a performance:
         <br>
         <select name="performanceID">
         <?php
           
          <option
         <input type="submit" name="addPicture" value="Add Picture">
         
         <br><br><br>
        </form>
        <?php
    }
    
    function addPerformanceForm() {
        ?>
        <form action="add.php" method="post">
         Use the following section to add a new Performance Event.
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
      *@calling getGenres, getPerformances
      */
    function addVideoForm() {
        ?>
        <form action="add.php" method="post">
         Use this following section to add a new video.
         <br>
         Paste a link to the video here:
         <input type="text" name="urlV">
         <br>
         Or upload a video to the database:
         <br>
         Add a short description for this video:
         <input type="text" name="captionV">
         <br>
         Dance genre depicted in video:
         <br>
         <select name="genres[]">
         <?php
         $genres= getGenres();
         foreach ( $genres as $genre ) {
             $id= $genre["idGenres"];
             $name= $genre["genreName"];    
             echo"<option value=$id> $name </option>"; 
         }
         ?>
         </select>
         <br>
         Link this video to a Sabor performance:
         <br>
         <select name="performanceID">
         <?php
         $performances= getPerformances();
         foreach( $performances as $performance ) {
            $id= $performance["idPerformances"];
            $title= $performance["performanceTitle"];
            $location= $performance["performanceLocation"];
            $date= $performance["performanceDate"];
            echo"<option value=$id> $title - $location - $date </option>";
         }
         ?>
         </select>
         <input type="submit" name="addVideo" value="Add Video">
         
         <br><br><br>
        </form>
        <?php
    }
    
    function addMemberForm() {
        ?>
        <form action="add.php" method="post">
          Add a new member to the group
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
          Country of Residence <input type="text" name"country">
          <br>
          State <input type="text" name="state"> (if U.S. e.g: NY, NJ)
          <br>
          City <input type="text" name="city">
          <br>
        
        If you wish, add one position this member has held or is currently holding.
        If this person can be associated with more than one role, you may add the
        others by using the Update Form.
        
          <br>
          Position <input type="text" name="position">
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
      * displays a basic contact form requesting email, object of message,
      * subject, and body
      */
    function contactForm() {
        ?>
        <div>
        <form action="contact.php" method="post">
        Please fill out all the fields below and click submit.<br>
        We will answer your request as soon as possible.<br>
        If you wish, you may email us directly at (sabor email here) <br>
        Your E-Mail Address<input type="text" name="requestorEmail"> 
        <br>
        What is the nature of your inquisition? 
        <input type="radio" name="requestType" value="General Information">
        <input type="radio" name="requestType" value="Performance Booking">
        <br>
        Subject <input type="text" name="subject">
        <br>
        Body <textarea name="body"> Detail your request here... </textarea>
        <br>
        <input type="submit" name="contactSubmit">
        </form>
        </div>
        <?php    
    }
?>