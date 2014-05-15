<?php
/* Functions for formatting pages are stored here
 */


/* Allan
 * displays the menu bar for each page
 * $ACTIVEPAGE is the current page that the user is on
 */
function createMenubar($ACTIVEPAGE){
	?>
	<div id='menubar'>
	
		<!--This header will be hidden everywhere but on the homepage -->
		<h1>Sabor Latino Dance Ensemble</h1>
		
		<!--The menubar-->
		<ul>
			<li><a href='index.php' <?php if ($ACTIVEPAGE == 'home'){echo "id='activepage'";} ?>>Home</a></li>
			<li><a href='about.php' <?php if ($ACTIVEPAGE == 'about'){echo " id='activepage'";} ?>>About</a></li>
			<li><a href='events.php' <?php if ($ACTIVEPAGE == 'events'){echo "id='activepage'";} ?>>Events</a></li>
			<li><a href='members.php' <?php if ($ACTIVEPAGE == 'members'){echo "id='activepage'";} ?>>Members</a></li>
			<li><a href='videos.php' <?php if ($ACTIVEPAGE == 'videos'){echo "id='activepage'";} ?>>Videos</a></li>
			<li><a href='contact.php' <?php if ($ACTIVEPAGE == 'contact'){echo "id='activepage'";} ?>>Contact</a></li>
			<?php
				//display link to admin page if admin is logged in
				if ( isset( $_SESSION["saborAdmin"] ) ){
					?>
					<li><a href='admin.php' <?php if ($ACTIVEPAGE == 'admin'){echo "id='activepage'";} ?>>Admin</a></li>
					<?php
				}
			?>			
		</ul>
	</div>
	<?php
}

/* Allan
 * generates the header for a page
 * $title is the title of the page
 * $style is the filename for a specific stylesheet for the page ending in .css
 */
function createHeader($title, $style = null){
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<title><?php echo $title; ?></title>
			<link href="http://fonts.googleapis.com/css?family=Gilda+Display|Oxygen:300|Kaushan+Script" rel='stylesheet' type='text/css'>
			<link rel="stylesheet" type="text/css" href="../style/style.css">
			<?php
				//use additional stylesheet if $style is set
				if (isset($style)){
					?>
					<link rel="stylesheet" type="text/css" <?php echo "href=\"../style/$style\""; ?>>
					<?php
				}
				if ($style == "add.css") {
				    ?>
				    <script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="3ehc33g5hx8oo6w">
				    </script>
				    <?php
				}
			?>
		</head>
		<body>
	<?php
}

/** Karl
  *@spec displays a select input for Members to the screen
  *@spec displays error message and stops rendering on error
  *@caller updateMemberForm
  *@calling getMemberRecords
  */
function displayMemberSelect() {
        //same thing as in addPictureForm. Extract as helper in another file? adminhelpers.php
           $res= getMemberRecords();
           $members= $res[0];
           $error= $res[1];
           $options= "Member <select name=\"memberID\">
                               <option value=\"none\"> \"None\" </option>";
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
           $options= $options."</select>";
           print($options); 
}

/** Karl
  *@calling getPerformances
  *@caller addPictureform, addVideoForm
  *@spec displays select input for Performances to the screen
  *@spec on error, displays message and stops rendering
  */
function displayPerformanceSelect($def) {
    $res= getPerformances();
    $performances= $res[0];
    $error= $res[1];
    $options="Performance <select name=\"performanceID\">";
    if ( $error ) {
        echo "$error";
        exit();
    }
    foreach( $performances as $performance ) {
        $id= $performance["idPerformances"];
        $title= $performance["performanceTitle"];
        $location= $performance["performanceLocation"];
        $date= $performance["performanceDate"];
         if (  $id == $def ) {  
            $options= $options."<option selected=\"selected\" value=$id> $title - $location - $date </option>"; 
         } else {
            $options= $options."<option value=$id> $title - $location - $date </option>";
        }
     }
     $options= $options."</select>";
    print($options);    
}

/** Karl
  *@param default- ID to be selected by default
  *@spec displays select input for Genres to screen
  *@spec displays error and stops rendering otherwise
  *@calling getGenres
  *@caller addVideoForm
  */
function displayGenreSelect($default) {   
        $res= getGenres();
         $genres= $res[0];
         $error= $res[1];
         $options= "Genre <select name=\"genreID\">";
         if ( $error ) {
             echo "$error";
             exit();
         }
         foreach ( $genres as $genre ) {
             $id= $genre["idGenres"];
             $name= $genre["genreName"];
             if (  $id == $default ) {  
                $options= $options."<option selected=\"selected\" value=$id> $name </option>"; 
             } else {
                 $options= $options."<option value=$id> $name </option>"; 
            }
         }
         $options= $options."</select>";
         print($options);
}

/** Karl
  *@param default- ID to be selected by default
  *@spec displays a select input for Positions to the screen
  *@spec displays error and stoprs rendering otherwise
  *@calling getPositions
  *@caller addMemberForm
  */
function displayPositionSelect($default) {
            $res= getPositions();
            $positions= $res[0];
            $error= $res[1];
            $options= "Position <select name=\"positionID\">";
            if ( $error ) {
                echo "$error";
                exit();
            }
            foreach( $positions as $record ) {
                $id= $record["idPositions"];
                $name= $record["position"];
                if ( $id == $default ) {
                    $options= $options."<option selected=\"selected\" value=$id> $name </option>";
                } else {
                    $options= $options."<option value=$id> $name </option>";
                }
            }
            $options= $options."</select>";
            print($options);    
}

/* Allan
 * generates the footer for a page
 */
function createFooter(){
	?>
	<div id="footer">
		<div id="copyright">
			&copy; Sabor Latino Dance Ensemble
		</div>
		<div id="adminlink">
			<a href="admin.php">Admin Controls</a>
		</div>
	</div>
	</body>
	</html>
	<?php
}
?>
