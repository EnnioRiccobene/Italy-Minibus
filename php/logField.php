<?php 

include("../template/dbConnection.php");

if(isset($_SESSION['name'])!=""){
    header("Location: index.php");
}

$emailErr = $pswdErr = "";
$email = $pswd = "";
$error=false;

$conn=connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["email"])) {
        $emailErr = "Inserire email";
	    $error=true;
    } else {
        $email = test_input($conn, $_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Formato email non valido"; 
	        $error=true;
        }
    }
    
    if (empty($_POST["pwd"])) {
        $pswdErr = "Inserire Password";
	    $error=true;
    } else {
        $pswd = test_input($conn, $_POST["pwd"]);

    }  
  
    if(!$error){
	   $noUser=true;

	   $sql = "SELECT * FROM Utenti WHERE email='".$email."'";
	   $result = mysqli_query($conn, $sql);
	
	   while($row = $result->fetch_assoc()){
		  if($email==$row["Email"]){
			 $noUser=false;
			 break;
		  }		
	   }
	
	   $result->data_seek(0);
	
	   if(!$noUser){
		  $row = $result->fetch_assoc();

          if(password_verify($pswd, $row["Password"])){
			 $_SESSION['name'] = $row['Email'];
			 
			 header("Location: ../index.php");
			
		  }else{
			 $pswdErr = "La Password non è corretta.";			
		  }
			
	   } 
	   else{
		  $emailErr = "Utente non registrato.";
	   }		
    } 
}
mysqli_close($conn);

function test_input($con, $data) {
    $data = trim($data); //The trim() function removes whitespace and other predefined characters from both sides of a string.
    $data = stripslashes($data); //The stripslashes() function removes backslashes added by the addslashes() function.
    $data = htmlspecialchars($data); //The htmlspecialchars() function converts some predefined characters to HTML entities.
    $data = mysqli_real_escape_string($con, $data); //Escapes special characters in a string for use in a SQL statement, taking into account the current charset of the connection
    return $data;
}


?>