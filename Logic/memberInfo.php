<?php

// load necessary function files
include_once "displayfunctions.php";
include_once "../Database/getters.php";
include_once "videoSearch.php";

 $memberID= $_GET["memberID"];
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
 
 echo "<h1> <a href=\"members.php\"> Members > </a> ";
 echo " $name </h1>";
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

 echo "<h1> Featured Videos </h1>";
videos( $memberID );

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

function videos( $id ) {
    $result= getVideosFor( $id );
    $myvids= $result[0];
    $error= $result[1];
    if ( $error ) {
        echo "$error<br>";
        return;
    }
    echo displayThumbnails($myvids);
    //echo "<ul>";
    /**foreach( $myvids as $vid ) {
        $url= $vid["urlV"];
        $caption= $vid["captionV"];
        //use an ifram for video? not working...
        echo "<li>";
        echo "<div id=\"vidbox\">";
        echo "<iframe id=\"vidbox\" width=\"100\" height=\"125\" ";    
        echo "src=\"$url\">";
        echo "</iframe>";
        echo "<br>$caption";
        echo "</div>";
        echo "</li>";
        //embed tag does not work either... */
        /**echo "<embed id=\"vidbox\"  width=\"420\" height=\"345\"
src=\"$url\"
type=\"application/x-shockwave-flash\">
</embed>";*/
    //}
    //echo "</ul>";
}


createFooter();
?>