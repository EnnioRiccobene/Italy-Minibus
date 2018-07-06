<?php 

function connect(){
    $servername = "localhost";
    $username = "name";
    $password = "password";
    $dbname = "database";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    return $conn;
}

?>