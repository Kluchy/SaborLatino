<?php
session_start();
// load necessary function files
include_once "displayfunctions.php";
include_once "../Database/getters.php";
include_once "../Database/helpers.php";
include_once "../Database/modifiers.php";
include_once "videoSearch.php";
include_once "checkinput.php";



createHeader("Sabor Member", "memberInfo.css");

if ( isset( $_GET["memberID"] ) ) {
    $memberInfo= retrieveMemberInfo();
    displayMember( $memberInfo );
    $memberID= $memberInfo["idMembers"];
}
 
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
            $memberID= $_POST["memberID"];
            $_GET["memberID"]=  $memberID;
            $memberInfo= retrieveMemberInfo();
            displayMember( $memberInfo );
    }
 }
 
          
 displayVideos( $memberID );
 
 //link back to members page
 ?>
	<br><br><br><p><a href="members.php">Return to Members List</a></p>
 <?php
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

function retrieveMemberInfo() {
    if ( validateID(  $_GET["memberID"] ) ) {
        $memberID= $_GET["memberID"];   
        $res= getMemberInfo( $memberID );
        $memberInfo= $res[0];
        $error= $res[1];
        if ( $error ) {
            echo "$error";
            exit();
        }
        return $memberInfo;
    }
    exit();    
}

function displayMember($memberInfo) {
    $memberID= $memberInfo["idMembers"];
    $firstName= $memberInfo["firstName"];
    $lastName= $memberInfo["lastName"];
    $title= $firstName." ".$lastName;
    $profilePic= $memberInfo["urlP"];
    $year= $memberInfo["year"];
    $status= getStatus( $year );
    $historyID= $memberInfo["positions"][0]["idHistory"];
    $positionID= $memberInfo["positions"][0]["idPositions"];
    $position= $memberInfo["positions"][0]["position"];
    $startDate= $memberInfo["positions"][0]["startDate"];
    $endDate= $memberInfo["positions"][0]["endDate"];
    $email= $memberInfo["email"];
    $phone=  $memberInfo["phone"];
    $bio= $memberInfo["bio"];
    $state=  $memberInfo["state"];
    $city=  $memberInfo["city"];
    $country= $memberInfo["country"];
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
                                Bio: <textarea name=\"bio\"> \"$bio\"</textarea> <br>
                                City: <input type=\"text\" name=\"city\" value=\"$city\"> <br>
                                Year: <input type=\"text\" name=\"state\" value=\"$state\"> <br>
                                Country: <input type=\"text\" name=\"country\" value=\"$country\"> <br>
                                <input type=\"submit\" name=\"updateMember\" value=\"Update Member\">
                            </form>";
                } else {      
                    echo" First Name: $firstName<br>
                               Last Name: $lastName<br>
                               Status: $status<br>
                               Position: $position<br>
                              $bio<br>";
                }
                echo "</div>";    
    
}

/** Karl
  *@param id - target member
  *@spec prints videos in whih target appears
  */
function displayVideos( $id ) {
    echo "<br><h1 class=\"feat\"> Featured Videos </h1>";
    $result= getVideosFor( $id );
    $myvids= $result[0];
    $error= $result[1];
    if ( $error ) {
        echo "$error";
        return;
    }
    echo displayThumbnails($myvids);
}


?>