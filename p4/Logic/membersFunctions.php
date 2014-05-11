<?php
    //require_once('config.php');
    include "../Database/getters.php";
?>
<?php

/**Derek
 * @param None
 * @return An array of associative arrays where each element is an associative array
 * associated with an eboard member
 * @caller displayMembers function - Uses this to dsiplay the eboard members first
 *  */
function eboardMem() {
   // $query = 'SELECT DISTINCT memberID FROM MembersHistory WHERE positionID = '/*positionID associated with eboard members */'';
    //return retrieve($query);
}

/**Derek
 * @param None
 * @return An array of associative arrays where each element is an associative array
 * associated with an head choreographer member
 * @caller displayMembers function - Uses this to display the eboard members first
 *  */
function choreoMem() {
    //$query = 'SELECT DISTINCT memberID FROM MembersHistory WHERE positionID = '/*positionID associated with head choreographer members */'';
    //return retrieve($query);
}

/**Derek
 * @param None
 * @return An array of associative arrays where each element is an associative array
 * associated with an non-eboard or non-choreogapher member
 * @caller displayMembers function - Uses this to display the eboard members first
 *  */
function restMem() {
    //$query = 'SELECT DISTINCT memberID FROM Members WHERE NOT EXISTS
      //  (SELECT DISTINCT memberID FROM MembersHistory WHERE positionID = '/*positionID associated with head choreographer eboard members */')';
    //return retrieve($query);
    
}

/**Derek
 * @param None
 * @return An html string displays all members on page and their proper formats.
 * @caller PHP page that requires members to be displayed
 * NOTE to GRADERS: Contains display logic, so may be moved to seperate file later.
 * * */
function displayMembers() {
    /** Calls the 3 member category retrieval functions (eboardMem, choreoMem, restMem) and set them equal to 3 different variables.
     */

    /*Loop through eboard array first and start writing html string to deal with displaying the eboard members and their information.
        Can do this with a SQL call with each memberID in the array to get photo information/other information. */

    //Then, do the same with the choreographers array, and then finally with the normal members array.
    
    //Return entire concatenated html string with all display logic in it.

}

/** Karl
  *@param members - array whose entries are associative arrays containing member info from Members, MemberContactInfo and MembersHistory
  *@spec displays full name and profile picture of each member onto the memebrs page
  *@caller groupMembers
  */
function display($members) {
    foreach( $members as $mem ) {
        $firstName= $mem["firstName"];
        $lastName= $mem["lastName"];
        $name= $firstName." ".$lastName;
        $profilePic= $mem["urlP"];
        $bio= $mem["bio"];
        $email= $mem["email"];
        $phone= $mem["phone"];
        $position= $mem["position"];
        $year= $mem["year"];
        $memID= $mem["idMembers"];
        echo "<li id=\"member\"> ";
        echo "<div id=\"member\">";
        echo "$name<br>";
        echo "<a href=\"memberInfo.php?memberID=$memID&name=$name&year=$year&bio=$bio&profilePic=$profilePic&email=$email&position=$position&phone=$phone\">";
        echo "<img id=\"member\" src=\"$profilePic\" alt=\"Profile Picture\">";
        echo "</a>";
        echo "</div>";
        echo "</li>";
    }
}
   
/** Karl
   *@spec display each active member in a div
                    or an error message
    *@note example on how to use the database functions and access values
   */
function groupMembers() {
    $result= getActiveMembers();
    $members= $result[0];
    $error= $result[1];
    if ( $error ) {
        //display error message
        echo "Error displaying members: $error";
        return;    
    }
    //success
    $eboard= array();
    $choreographers= array();
    $gbody= array();
    //separate eboard form general body, from choreographers
    foreach( $members as $mem ) {
        $positionID=  $mem["positionID"] ;
        if ( $positionID == 0 ) {
            $gbody[]= $mem;
        } elseif ( $positionID ==  1 ) {
            $choreographers[]= $mem;
        } else {
            $eboard[]= $mem;
        }
    }
    //display E-board
    echo "<div>";
    echo "<h1> The Executive Board </h1>";
    echo "<ul id=\"member\">";
    display( $eboard );
    echo "</ul>";
    echo "</div>";
    //display choreos
    echo "<div>";
    echo "<h1> The Head Choreographers </h1>";
    echo "<ul id=\"member\">";
    display( $choreographers );
    echo "</ul>";
    echo "</div>";
    //display G-Body
    echo "<div>";
    echo "<h1> General Body Members </h1>";
    echo "<ul id=\"member\">";
    display( $gbody );
    echo "</ul>";
    echo "</div>";
}

?>
