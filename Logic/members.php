<?php
    require_once('config.php');
    include "getters.php";
?>
<?php

/**Derek
 * @param None
 * @return An array of associative arrays where each element is an associative array
 * associated with an eboard member
 * @caller displayMembers function - Uses this to diplay the eboard members first
 *  */
function eboardMem() {
    $query = 'SELECT DISTINCT memberID FROM MembersHistory WHERE positionID = '/*positionID associated with eboard members */'';
    return retrieve($query);
}

/**Derek
 * @param None
 * @return An array of associative arrays where each element is an associative array
 * associated with an head choreographer member
 * @caller displayMembers function - Uses this to diplay the eboard members first
 *  */
function choreoMem() {
    $query = 'SELECT DISTINCT memberID FROM MembersHistory WHERE positionID = '/*positionID associated with head choreographer members */'';
    return retrieve($query);
}

/**Derek
 * @param None
 * @return An array of associative arrays where each element is an associative array
 * associated with an non-eboard or non-choreogapher member
 * @caller displayMembers function - Uses this to diplay the eboard members first
 *  */
function restMem() {
    $query = 'SELECT DISTINCT memberID FROM Members WHERE NOT EXISTS
        (SELECT DISTINCT memberID FROM MembersHistory WHERE positionID = '/*positionID associated with head choreographer eboard members */')';
    return retrieve($query);
    
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

?>
