<?php

if($log_user != "Login"){

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $conn = connect();
        
        try {
            mysqli_autocommit($conn,false);
    
            $sql = "SELECT Partenza 
                    FROM Prenotazioni 
                    WHERE Utente = '".$log_user."' FOR UPDATE;";
            $result = mysqli_query($conn, $sql);    
            if($result == false) throw new Exception("Select partenza fallita"); 
            $row = $result -> fetch_assoc();
            $partU = $row["Partenza"];
            
            $sql = "SELECT Destinazione 
                    FROM Prenotazioni 
                    WHERE Utente = '".$log_user."' FOR UPDATE;";
            $result = mysqli_query($conn, $sql);    
            if($result == false) throw new Exception("Select destinazione fallita"); 
            $row = $result -> fetch_assoc();
            $destU = $row["Destinazione"];
            
            $sql = "DELETE FROM Prenotazioni 
                    WHERE Utente = '".$log_user."';";
            $result = mysqli_query($conn, $sql);    
            if($result == false) throw new Exception("Delete prenotazione fallita"); 
            
            $sql = "SELECT COUNT(*) AS NumP  
                    FROM Prenotazioni 
                    WHERE Partenza = '".$partU."'
                    OR Destinazione = '".$partU."' FOR UPDATE;";
            $result = mysqli_query($conn, $sql);    
            if($result == false) throw new Exception("Select numero partenze fallita"); 
            $row = $result -> fetch_assoc();
            $numP = $row["NumP"];
            
            $sql = "SELECT COUNT(*) AS NumD
                    FROM Prenotazioni 
                    WHERE Destinazione = '".$destU."' 
                    OR Partenza = '".$destU."' FOR UPDATE;";
            $result = mysqli_query($conn, $sql);    
            if($result == false) throw new Exception("Select numero destinazioni fallita"); 
            $row = $result -> fetch_assoc();
            $numD = $row["NumD"];
            
            if($numP == 0){
                $sql = "DELETE FROM Luoghi 
                        WHERE Luogo = '".$partU."';";
                $result = mysqli_query($conn, $sql);    
                if($result == false) throw new Exception("Delete luogo di partenza fallita");
            }
            
            if($numD == 0){
                $sql = "DELETE FROM Luoghi 
                        WHERE Luogo = '".$destU."';";
                $result = mysqli_query($conn, $sql);    
                if($result == false) throw new Exception("Delete luogo di destinazione fallita");
            }
    
            if (!mysqli_commit($conn)) {
                throw Exception("Commit fallita");
            }
            
            $userPrenotato = false;
            $msgD = true;
    
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo 'Rollback: ' .$e->getMessage();
            mysqli_autocommit($conn, true);
            $userPrenotato = true;
            $msgD = true;
        }
        mysqli_autocommit($conn, true);
        mysqli_close($conn);
    }
} else {
    echo 'Session expired - Effettuareil login per tentare la disdetta.';
    $msgP = true;
    $userPrenotato = false;
}

?>