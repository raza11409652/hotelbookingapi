    <?php
    function validMobile($mobile){
    $mobileRegex="/^[6789]{1}\d{9}$/";
    if(preg_match($mobileRegex,$mobile)){
    return true;
    }
    return false;
    }
    function validEmail($email){
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return true;
    }
    return false;
    }
    function pureText($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
    function validName($name){
    $name = pureText($name);
    if (preg_match("/^[a-zA-Z ]*$/",$name)) {
    return true;
    }
    return false;
    }
    function validNumber($str){
    $str = pureText($str);
    if(is_numeric($str)){
    return true;
    }
    return false ;
    }
    function validOTP($str){
    $str = pureText($str) ; 
    if(is_numeric($str) && strlen($str)==5){
    return true  ; 
    }
    return false ;
    }
    function validPassword($str){
    //Password should be at least 8 characters in length 
    //and should include at least one upper case letter, one number, and one special character.
    // Given password
    $password = $str;

    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
    return false ; 
    }
    return true ; 
    }  
    function validAccountNumber($str){
    $str = pureText($str) ; 
    if(is_numeric($str) && strlen($str)>0){
    return true  ; 
    }
    return false ; 
    } 

    function totalnumberdays($startDate , $endDate){
        $strStart =strtotime($startDate)  ; 
        $strEnd = strtotime($endDate) ; 
        $diff  =($strEnd - $strStart) ; 
        return abs(round($diff / 86400)); ; 
    }

    function isvalidstartdate($date){
    $today = date('Y/m/d') ;
    $strToday = strtotime($today) ; 
    $strDate = strtotime($date) ; 
    $diff  = $strDate - $strToday ;  
    if($diff<0) return false     ; 
    return true;
    }        
    function isvalidEndDate($startDate , $endDate){
    $strStart = strtotime($startDate) ; 
    $strEnd = strtotime($endDate) ; 
    $diff =$strEnd - $strStart ;
    if($diff<1) return false ;  
    return TRUE ; 

    }

    function formatDate($date){
        // var_dump($date);
        $time=strtotime($date);
        $month=date("F",$time);
        $year=date("Y",$time);
        $day=date("d" , $time);
       $newDate = "{$day} {$month} {$year}" ; 
       return $newDate;
    }
    function getMonth($date){
        $time=strtotime($date);
        $month = date("m" , $time);
        return $month;
    }
    function getDay($date){
        $time=strtotime($date);
        $day=date("d" , $time);
        return $day;
    }
    function getYear($date){
        $time=strtotime($date);
        $year=date("Y",$time);
        return $year;
    }
    function getNextMonthDate($date){
        $endDate = date('Y-m-d', strtotime('+1 month', strtotime($date)));
        return $endDate;
    }
    ?>
