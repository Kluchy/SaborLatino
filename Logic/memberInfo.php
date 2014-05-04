<?php

// load necessary function files
include_once "displayfunctions.php";
include_once "../Database/getters.php";

 $name= $_GET["name"];
 $year= $_GET["year"];
 $position= $_GET["position"];
 $profilePic= $_GET["profilePic"];
 $bio= $_GET["bio"];
 $email= $_GET["email"];
 $phone= $_GET["phone"];
 $status= getStatus($year);
 
$title= $name; 
createHeader($title, "memberInfo.css");
 
 echo "<ul id=\"member\">";
 echo "<li  id=\"member\">";
 echo "<img id=\"member\" src=\"$profilePic\" alt=\"Profile Picture\">";
 echo "</li>";
 echo "<li  id=\"member\">";
 echo "<div id=\"member\">";
 echo "Name: $name<br>";
 echo "Status: $status<br>";
 echo "position: $position<br>";
 echo "E-Mail: $email<br>";
 echo "#tel: $phone<br>";
 echo "<br><br><br>";
 echo "$bio<br>";
 echo "</div>";
 echo "</li>";
 echo "</ul>";



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

?>