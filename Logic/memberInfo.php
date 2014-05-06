<?php

// load necessary function files
include_once "displayfunctions.php";
include_once "../Database/getters.php";
include_once "../Database/helpers.php";
include_once "videoSearch.php";

/**validate and retrieve GET variables*/
if ( isset( $_GET["memberID"] ) && validateID(  $_GET["memberID"] ) ) {
    $memberID= $_GET["memberID"];
} else {
    $memberID= "";
}
 if ( isset( $_GET["name"] ) && validateText( $_GET["name"] ) ) {
    $name= $_GET["name"];
} else {
    $name= "";
}
if ( isset( $_GET["year"] ) && validateDate( $_GET["year"] ) ) {
    $year= $_GET["year"];
} else {
    $year= "";
}
if (  isset( $_GET["position"] ) && validateText( $_GET["position"] ) ) {
    $position= $_GET["position"];
} else {
    $position= "";
}
if (  isset( $_GET["profilePic"] ) && validateText( $_GET["profilePic"] ) ) {   
    $profilePic= $_GET["profilePic"];
} else {
    $profilePic= "http://info230.cs.cornell.edu/users/skemab/www/Sabor/SaborLatino/img/defaultProfilePic.jpg";
}
if (  isset( $_GET["bio"] ) && validateText( $_GET["bio"] ) ) {
    $bio= $_GET["bio"];
} else {
    $bio="";
}
if (  isset( $_GET["email"] ) && validateText( $_GET["email"] ) ) {
    $email= $_GET["email"];
} else {
    $email="";
}
if (  isset( $_GET["phone"] ) && validatePhone( $_GET["phone"] ) ) {
    $phone= $_GET["phone"];
} else {
    $phone= "";
}
/** End validate GET varibales */
 $status= getStatus($year);
 
$title= $name; 
createHeader($title, "memberInfo.css");
 
 echo "<h1> <a href=\"members.php\"> Members > </a> $name </h1>
            <ul id=\"member\">
              <li  id=\"member\">
                <img id=\"member\" src=\"$profilePic\" alt=\"Profile Picture\">
              </li>
              <li  id=\"member\">
                <div id=\"member\">
                    Name: $name<br>
                    Status: $status<br>
                    Position: $position<br>
                    E-Mail: $email<br>
                    #tel: $phone<br>
                    $bio<br>
                </div>
            </li>
          </ul>";
          
 displayVideos( $memberID );
 createFooter();
?>


<?php  /*HELPERS*/

/** Karl
  *@param year - e.g: 2014
  *@return corresponding school status as a string
  */
function getStatus( $year ) {
        $date= getdate();
        $currentYear= $date['year'];
    if ( $year < $currentYear ) {
        return "Graduate Student";
    } elseif ( $year == $currentYear ) {
        return "Senior";    
    } elseif ( $year == $currentYear + 1 ) {
        return "Junior";
    } elseif ( $year == $currentYear + 2 ) {
        return "Sophomore";
    } else {
        return "Freshman";
    }
}

/** Karl
  *@param id - target member
  *@spec prints videos in whih target appears
  */
function displayVideos( $id ) {
    echo "<h1> Featured Videos </h1>";
    $result= getVideosFor( $id );
    $myvids= $result[0];
    $error= $result[1];
    if ( $error ) {
        echo "$error<br>";
        return;
    }
    echo displayThumbnails($myvids);
}


?>