
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
        $specialLetters= array("&" => "&amp;","√†" => "a&#768;", "√¢" => "a&#770;",
        "aÃÉ" => "a&#771;", "√°" => "a&#769;", "√¨" => "i&#768;", "√Æ" => "i&#770;",
        "√≠" => "i&#769;", "√π" => "u&#768;", "√ª" => "u&#770;", "uÃÉ" => "u&#771;",
        "√∫" => "u&#769;", "√®" => "e&#768;", "√™" => "e&#770;", "√©" => "e&#769;",
        "√≤" => "o&#768;", "√¥" => "o&#770;", "√µ" => "o&#771;", "√≥" => "o&#769;");
        
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
        if (preg_match("/^[A-Za-z0-9@!\-\s\.\(\)\& √†√®√¨√≤√π√°√©√≠√≥√∫√¢√™√Æ√¥√ª√±√£√µ]{1,255}$/",$input)){
            return true;
        }
    }

   /** Karl
*@return true for urls like: https://www.youtube.com/watch?v=sEw_b7N0PVg
*@return false for urls like: https://www.youtube.com/watch?v=thTd14ptEqU&list=TLcV6SChuBvdhv-OZM0mVZQKZiCjD8bQK2
*@caller formatVideoInput
*/
    function validateUrl($link) {
        return preg_match("/^http[s]{0,1}\:\/\/(www.){0,1}[a-zA-Z0-9]{1,255}\.com\/[A-Za-z0-9@?_!=\-\s\.\(\) ‡ËÏÚ˘·ÈÌÛ˙‚ÍÓÙ˚Ò„ı]{1,255}$/",$link);
    } 

    
    /** Karl
      * true if input is of a valid email format
      */
    function validateEmail($input) {
       return preg_match("/^[a-zA-Z0-9!\&]{1,40}@[a-zA-Z]{1,40}\.[a-z]{1,10}$/",$input);
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
    
   /** Karl
     *@param phone - phone user input
     *@return true if phone is a 10-13 digit-number
     */
   function validatePhone($phone) {
       $temp= str_replace( "(", "", $phone );
       $temp= str_replace( ")", "", $temp );
       $temp= str_replace( "-", "", $temp );
       $temp= str_replace( " ", "", $temp );
        if (preg_match("/^[0-9]{10,13}$/",$temp)){
            return true;
        }
   }
       /** Karl
    *@return true for urls like: https://www.youtube.com/watch?v=sEw_b7N0PVg
    *@return false for urls like: https://www.youtube.com/watch?v=thTd14ptEqU&list=TLcV6SChuBvdhv-OZM0mVZQKZiCjD8bQK2
    *@caller formatVideoInput
    */
        function validateUrl($link) {
            return preg_match("/^http[s]{0,1}\:\/\/(www.){0,1}[a-zA-Z0-9]{1,255}\.com\/[A-Za-z0-9@?_!=\-\s\.\(\) ‡ËÏÚ˘·ÈÌÛ˙‚ÍÓÙ˚Ò„ı]{1,255}$/",$link);
        } 
    
    function currentDate(){
        $date= getdate();
        $year= $date['year'];
        $month= $date['mon'];
        $day= $date['mday'];
        $newDate= "$year-$month-$day";
        return $newDate;
    }
    
    function defaultEndDate() {
        $date= getdate();
        $year= $date['year'];
        $year= $year + 1;
        $month= $date['mon'];
        $day= $date['mday'];
        $newDate= "$year-$month-$day";
        return $newDate;
    }
    
    /** Karl
      *@param name - input username
      *@param password - input password
      *@spec sets the SESSION variable if name and password are in the Admin table
      * echoes a message if login attempt unsuccessful
      * Caller should validate arguments
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
        echo $name;
        echo $inputPassword;
        $query= "SELECT *
                 FROM Admin
                 WHERE username = \"$name\" AND password = \"$inputPassword\";";
        $result= $mysqli->query ( $query );
        $arr = $result->fetch_row();
        print_r($arr);
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
