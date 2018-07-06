<?php

    session_start();

    $log_user = $reg_logout = "";
    $log_user_link = $log_user_link2 = $reg_logout_link = $reg_logout_link2 =  "";
    
    if(isset($_SESSION['name'])!="") {
        $log_user=$_SESSION['name'];
        $reg_logout="Logout";
        $log_user_link="php/personal.php"; //se sono nella home
        $log_user_link2="personal.php"; //se sono in altre pagine
        $reg_logout_link="php/logout.php"; //se sono nella home
        $reg_logout_link2="logout.php"; //se sono in altre pagine
    } else {
        $log_user="Login";
        $reg_logout="Registrati";
        $log_user_link="php/login.php"; //se sono nella home
        $log_user_link2="login.php"; //se sono in altre pagine
        $reg_logout_link="php/registration.php"; //se sono nella home
        $reg_logout_link2="registration.php"; //se sono in altre pagine
    }


    //Expire the session if user is inactive for 2 minutes or more.
    $expireAfter = 2;
 
    //Check to see if our "last action" session variable has been set.
    if(isset($_SESSION['last_action'])){
    
        //Figure out how many seconds have passed since the user was last active.
        $secondsInactive = time() - $_SESSION['last_action'];
    
        //Convert our minutes into seconds.
        $expireAfterSeconds = $expireAfter * 60;
    
        //Check to see if they have been inactive for too long.
        if($secondsInactive >= $expireAfterSeconds){
            //User has been inactive for too long. Kill their session.
            session_unset();
            session_destroy();
        }
    
    }
 
    //Assign the current timestamp as the user's latest activity
    $_SESSION['last_action'] = time();

?>