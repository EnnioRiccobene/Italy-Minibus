<?php

if($log_user != "Login" and $log_user != ""){
    
    $Partenza = $Destinazione = $Passeggeri = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $partenzaSel = $partenzaTArea = $destinazioneSel = $destinazioneTArea = $nPasseggeri = "";
        
        $conn=connect();        
        
        if(isset($_POST['selPartenza'])){
            $partenzaSel = $_POST['selPartenza'];
        }
        
        if(isset($_POST['textP'])){
            $partenzaTArea = test_input($conn, $_POST['textP']);
        }
        
        if(isset($_POST['selDestinazione'])){
            $destinazioneSel = $_POST['selDestinazione'];
        }
        
        if(isset($_POST['textD'])){
            $destinazioneTArea = test_input($conn, $_POST['textD']);
        }
        
        if(isset($_POST['selPasseggeri'])){
            $Passeggeri = $_POST['selPasseggeri'];
        }

        if($partenzaSel != "0" and $partenzaSel != null) {
            $Partenza = $partenzaSel;
        }else{
            $Partenza = $partenzaTArea;
        } 
                        
        if($destinazioneSel != "0" and $destinazioneSel != null) {
            $Destinazione = $destinazioneSel;
        }else{
            $Destinazione = $destinazioneTArea;
        }
        
        mysqli_close($conn);
        
        if($Partenza >= $Destinazione or $Partenza == null or $Destinazione == null){
            $msgP = true;
        } else {
            $conn=connect();
            
            try{
                mysqli_autocommit($conn,false);
                
                $sql = "SELECT SUM(Passeggeri) AS sumPasseggeri 
                        FROM Prenotazioni 
                        WHERE IdP NOT IN (SELECT IdP
                                          FROM Prenotazioni
                                          WHERE Destinazione <= '".$Partenza."'
                                          OR Partenza >= '".$Destinazione."')
                        FOR UPDATE;";
                $result = mysqli_query($conn, $sql);
                if($result == false) throw new Exception("Select max passeggeri fallita");
                $sumPass = $result->fetch_assoc();                
                $sumP = $sumPass["sumPasseggeri"];
                $xp = $sumP + $Passeggeri;
                
                if($xp > $capienzabus){
                    $msgP = true;
                }
                
                if($msgP == false){
                    $sql1 = "SELECT COUNT(*) AS NumP
                            FROM Luoghi
                            WHERE Luogo = '".$Partenza."' 
                            FOR UPDATE;";
                    $result1 = mysqli_query($conn, $sql1);
                    if($result1 == false) throw new Exception("Select numero partenze fallita");
                    $row1 = $result1->fetch_assoc();                
                    $numP = $row1["NumP"];
                    
                    $sql2 = "SELECT COUNT(*) AS NumD
                            FROM Luoghi
                            WHERE Luogo = '".$Destinazione."' 
                            FOR UPDATE;";
                    $result2 = mysqli_query($conn, $sql2);
                    if($result2 == false) throw new Exception("Select numero destinazioni fallita");
                    $row2 = $result2->fetch_assoc();                
                    $numD = $row2["NumD"];
                    
                    if($numP == 0){
                        $sql3 = "INSERT INTO Luoghi(Luogo)
                                VALUES('".$Partenza."');";
                        $result3 = mysqli_query($conn, $sql3);
                        if($result3 == false) throw new Exception("Insert luogo fallita");
                    }
                    
                    if($numD == 0){
                        $sql4 = "INSERT INTO Luoghi(Luogo)
                                VALUES('".$Destinazione."');";
                        $result4 = mysqli_query($conn, $sql4);
                        if($result4 == false) throw new Exception("Insert luogo fallita");
                    }
                    
                    $sql5 = "INSERT INTO Prenotazioni(Partenza, Destinazione,   Utente, Passeggeri)
                            VALUES('".$Partenza."', '".$Destinazione."', '".$log_user."', $Passeggeri);";
                    $result5 = mysqli_query($conn, $sql5);
                    if($result5 == false) throw new Exception("Insert prenotazione fallita");
                }
                
                if (!mysqli_commit($conn)) {
                    throw Exception("Commit fallita");
                }
                
                if($xp > $capienzabus){
                    $msgP = true;
                    $userPrenotato = false;
                    
                    echo '<p style="color: red">Prenotazione non riuscita. Selezionare un numero di passeggeri che consenta di non superare la capienza del minibus. Selezionare una destinazione che, in ordine alfabetico, venga dopo del luogo di partenza.</p>';
                    
                } else {
                    $msgP = $userPrenotato = true;
                   
                }

            } catch (Exception $e) {
                mysqli_rollback($conn);
                echo 'Rollback: ' .$e->getMessage();
                mysqli_autocommit($conn, true);
            }
            mysqli_autocommit($conn, true);
            mysqli_close($conn);
            
        }
    } 
} else {
    
    echo 'Session expired - Effettuare il login per tentare la prenotazione.';

}
    

    
    function test_input($con, $data) {
        $data = trim($data); //The trim() function removes whitespace and other predefined characters from both sides of a string.
        $data = stripslashes($data); //The stripslashes() function removes backslashes added by the addslashes() function.
        $data = htmlspecialchars($data); //The htmlspecialchars() function converts some predefined characters to HTML entities.
        $data = mysqli_real_escape_string($con, $data); //Escapes special characters in a string for use in a SQL statement, taking into account the current charset of the connection
        return $data;
    }

?>