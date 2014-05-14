
   <?php
    /******************* START GLOBAL HELPER FUNCTIONS */
    /*All functions that are being used in more than one file */
    /*GENERAL POLICY: in your method header (aka specs), add a comment
       starting with "@callers" followed by a list of functions that call
       this function 
       
       Below is a guideline for writing functions specs. We should ALL follow
       this policy to make code sharing as painless as possible. BELIEVE me,
       while it may seem annoying to write so much,it will pay off in the end
       because we are going to have THOUSANDS of lines of code, and I don't think
       anyone would want to have to search through that. This policy will
       allow us to find what we need as quickly as possible
       
       EXAMPLE:
       /** Karl [person who wrote this function]
         *@param s - description of s here
         *@param t - description of t here
         *@caller example22
         *@calling (this function does not call another so empty)
         *@return describe what it returns, and under what condition it returns what
         *@spec anything particular about the function (e.g. undefined behavior,
                special behavior, anything noteworthy not mentioned above
         *
       function example1(s, t) {
           //some code here    
       } 
       
       @param (assume no parameters so empty)
       @caller (assume no one calls this function so empty)
       @calling example1
       function example22() {
         //some code
         
           x= example1()  
        }
        */
    
    /**Karl
      *convert common special latin characters in $input to their entity code
      */
    function fixEntities($input){
        $specialLetters= array("&" => "&amp;","à" => "a&#768;", "â" => "a&#770;",
        "ã" => "a&#771;", "á" => "a&#769;", "ì" => "i&#768;", "î" => "i&#770;",
        "í" => "i&#769;", "ù" => "u&#768;", "û" => "u&#770;", "ũ" => "u&#771;",
        "ú" => "u&#769;", "è" => "e&#768;", "ê" => "e&#770;", "é" => "e&#769;",
        "ò" => "o&#768;", "ô" => "o&#770;", "õ" => "o&#771;", "ó" => "o&#769;");
        
        foreach ( $specialLetters as $special => $entity ){
            if (strpos($input,$special) !== false)
                $input= preg_replace('/$special/', $entity, $input);
        }
        return $input;
  
    }
    
    /** Karl
      *true if user '$input' string meets our requirements
      */
    function validateText($input){
        if (preg_match("/^[A-Za-z0-9@!\-\s\.\(\)\& àèìòùáéíóúâêîôûñãõ]{1,255}$/",$input)){
            return true;
        }
        
    }
    
    /** Karl
      * true if input is of a valid email format
      */
    function validateEmail($input) {
       return preg_match("^/[a-zA-Z0-9!\&]{1,40}@[a-zA-Z]{1,40}\.[a-z]{1,10}$/",$input);
    }
    
    /** Karl
      *true if id is a number
      */
    function validateID($id) {
        return ( is_numeric ( $id ) );
    }
    
    /** Karl
      *true if strtotime returns some valid date format
      */
    function validateDate($date) {
        return strtotime($date);
    }
    
    function currentDate(){
        $date= getdate();
        $year= $date['year'];
        $month= $date['mon'];
        $day= $date['mday'];
        $newDate= "$year-$month-$day";
        return $newDate;
    }
    
    /** Karl
      *@param name - input username
      *@param password - input password
      *@spec sets the SESSION variable if name and password are in the Admin table
      *      echoes a message if login attempt unsuccessful
      *      Caller should validate arguments
      * 
      */
    function attemptLogin($name,$password) {
        require_once "config.php";
        $mysqli= new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
        if (!$mysqli) {
            echo "Error: cannot connect to database. Try again later<br>.";
            return false;
        }
        $inputPassword= hash( 'sha256', $password );
        $query= "SELECT *
                 FROM Admin
                 WHERE username = \"$name\" AND password = \"$inputPassword\";";
        $result= $mysqli->query ( $query );
        if ( $result && $result->num_rows == 1) {
            //inputs match entry in Admin.
            $_SESSION['saborAdmin']= $name;                       
        }
        else {
                echo "Username or Password entered was invalid.<br>";
        }
        $mysqli->close();
    }
    
    /** Karl
      *display appropriate message/link if user is logged in
      */
    function displayMessage(){
        if ( isset ( $_SESSION['saborAdmin'] ) ) {
            $saborAdmin= $_SESSION['saborAdmin'];
            echo "Nice to see you again, $saborAdmin :)<br>";
        }
    }

    //Time helper function that returns an array. Array[0] returns a HTML
    //string that populates the hour select box and Array[1] returns a HTML     
    //string that populates the minute select box.
    //Array[2] returns HTML string for AM/PM select box.
    function timeHelper() {
        $time[0] = "";
        $time[1] = "";
        for($i = 1; $i <= 12; $i++) {
            if($i <= 9) {
                $time[0] = $time[0]. '<option value = "0'.$i.'">0'.$i.'</option>';
            }
            else {
                $time[0] = $time[0]. '<option value = "'.$i.'">'.$i.'</option>';
            }
        }
        for($i = 0; $i <= 59; $i++) {
            if($i <= 9) {
                $time[1] = $time[1]. '<option value = "0'.$i.'">0'.$i.'</option>';
            }
            else {
                $time[1] = $time[1]. '<option value = "'.$i.'">'.$i.'</option>';
            }
        }
        $time[2] = '<option value = "AM">AM</option><option value = "PM">PM</option>';

        return $time;
    }

    

    

    
?>
