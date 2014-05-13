<?php
session_start();
// load necessary function files
include_once "displayfunctions.php";
include_once "../Database/getters.php";
include_once "../Database/helpers.php";
include_once "../Database/modifiers.php";
include_once "videoSearch.php";
include_once "checkinput.php";

/**validate and retrieve GET variables*/
if ( isset( $_GET["memberID"] ) && validateID(  $_GET["memberID"] ) ) {
    $memberID= $_GET["memberID"];
} else {
    $memberID= "";
}
 if ( isset( $_GET["firstName"] ) && validateText( $_GET["firstName"] ) ) {
    $firstName= $_GET["firstName"];
} else {
    $firstName= "";
}
if ( isset( $_GET["lastName"] ) && validateText( $_GET["lastName"] ) ) {
    $lastName= $_GET["lastName"];
} else {
    $lastName= "";
}
if ( isset( $_GET["year"] ) && validateDate( $_GET["year"] ) ) {
    $year= $_GET["year"];
} else {
    $year= "";
}
if (  isset( $_GET["historyID"] ) && validateID( $_GET["historyID"] ) ) {
    $historyID= $_GET["historyID"];
} else {
    $historyID= "";
}
if (  isset( $_GET["positionID"] ) && validateID( $_GET["positionID"] ) ) {
    $positionID= $_GET["positionID"];
} else {
    $positionID= "";
}
if (  isset( $_GET["position"] ) && validateText( $_GET["position"] ) ) {
    $position= $_GET["position"];
} else {
    $position= "";
}
if (  isset( $_GET["startDate"] ) && validateDate( $_GET["startDate"] ) ) {
    $startDate= $_GET["startDate"];
} else {
    $startDate= "";
}
if (  isset( $_GET["endDate"] ) && validateDate( $_GET["endDate"] ) ) {
    $endDate= $_GET["endDate"];
} else {
    $endDate= "";
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
 
$title= $firstName." ".$lastName; 
createHeader($title, "memberInfo.css");
 
 //process user input
 if ( isset( $_POST["updateMember"] ) ) {
    $memberInfo= formatMemberInput();
    $memberInfo["idHistory"]= $_POST["historyID"];
    if ($memberInfo["positionID"] == $_POST["oldPositionID"]) {
            $error= updateMemInfo( $_POST["memberID"], $memberInfo );
            if ( $error ) {
                echo "Error updating member: $error";
            } else {
                echo "Successfully updated member<br>";
            }
    }
 }
 
 echo "<h1> <a href=\"members.php\"> Members > </a> $title </h1>
              <div id=\"memberPic\">
                <img id=\"member\" src=\"$profilePic\" alt=\"Profile Picture\">
              </div>
              <div id=\"memberInfo\">";
              if ( isset( $_SESSION["saborAdmin"] ) ) {
                  echo "<form action=\"memberInfo.php\" method=\"post\">
                                First Name: <input type=\"text\" name=\"firstName\" value=\"$firstName\"> <br>
                                Last Name: <input type=\"text\" name=\"lastName\" value=\"$lastName\"> <br>
                                Status: <input type=\"text\" name=\"year\" value=\"$year\"> <br>";
                  displayPositionSelect($positionID);     
                  echo "  <br>
                                Start Date: <input type=\"text\"name=\"startDate\" value=\"$startDate\"> <br>
                                End Date: <input type=\"text\"name=\"endDate\" value=\"$endDate\"> <br>
                                <input type=\"hidden\" name=\"oldPositionID\" value=\"$positionID\">
                                <input type=\"hidden\" name=\"memberID\" value=$memberID>
                                <input type=\"hidden\" name=\"historyID\" value=$historyID>
                                E-mail: <input type=\"text\" name=\"email\" value=\"$email\"> <br>
                                #tel: <input type=\"text\" name=\"phone\" value=\"$phone\"> <br>
                                bio: <input type=\"textarea\" name=\"bio\" value=\"$bio\"> <br>
                                <input type=\"submit\" name=\"updateMember\" value=\"Update Member\">
                            </form>";
                } else {      
                    echo" First Name: $firstName<br>
                               Last Name: $lastName<br>
                               Status: $status<br>
                               Position: $position<br>
                               E-Mail: $email<br>
                               #tel: $phone<br>
                              $bio<br>";
                }
                echo "</div>";
          
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