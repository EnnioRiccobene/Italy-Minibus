<?php 

include("../template/dbConnection.php");

$conn=connect();

try {
    mysqli_autocommit($conn,false);
    
    $sql = "SELECT * FROM Prenotazioni FOR UPDATE;";
    $result = mysqli_query($conn, $sql);    
    if($result == false) throw new Exception("Select di servizio su Prenotazioni fallita");
    
    $sql = "SELECT Luogo FROM Luoghi ORDER BY Luogo FOR UPDATE;";
    $result = mysqli_query($conn, $sql);
    
    if($result == false) throw new Exception("Select su Luoghi fallita"); 
    $arrayLuoghi = array();
    while ($row = $result->fetch_assoc()) {
        array_push($arrayLuoghi, $row["Luogo"]);            
    }
    
    if(count($arrayLuoghi) == 0){
        echo 'Attualmente nessuna tratta è attiva. I persorsi attivi compariranno in seguito a delle prenotazioni.';
    } else {
        while(count($arrayLuoghi) > 1){
            $boxPartenza = array_shift($arrayLuoghi);
            $boxDestinazione = $arrayLuoghi[0];
            
            $sql = "SELECT SUM(Passeggeri) AS TotPass
                    FROM Prenotazioni
                    WHERE Partenza <= '".$boxPartenza."' AND Destinazione >= '".$boxDestinazione."' ";
            $result = mysqli_query($conn, $sql);
            if($result == false) throw new Exception("Select di Totale Passeggeri fallita");
            
            $sql3 = "SELECT COUNT(Utente) as NumUtenti 
                    FROM Prenotazioni
                    WHERE Utente = '".$log_user."'
                        AND Partenza <= '".$boxPartenza."'
                        AND Destinazione >= '".$boxDestinazione."' ";
            $result3 = mysqli_query($conn, $sql3);
            if($result3 == false) throw new Exception("Select di Utente rosso fallita");  
            $row3 = $result3->fetch_assoc();
            if($row3["NumUtenti"] > 0){
                while ($row = $result->fetch_assoc()){
                    if($row["TotPass"] == null){
                        $row["TotPass"] = 0;
                    }
                        
                    //stampa della scheda
                    echo '<div class="routeBox">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="pBox" style="color:red">Partenza: '.$boxPartenza.'</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="pBox" style="color:red">Num. Passeggeri: '.$row["TotPass"].'</p>
                                    </div>
                                </div>    
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="pBox" style="color:red">Destinazione: '.$boxDestinazione.'</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <img id="blueBus" src="../img/bluebust.png" alt="Blue Bus" align="right" style="padding-right:10px">
                            </div>
                        </div>
                    </div>
                    <br>';

                    $sql2 = "SELECT Utente, Passeggeri
                            FROM Prenotazioni
                            WHERE Partenza <= '".$boxPartenza."' AND Destinazione >= '".$boxDestinazione."' ";
                    $result2 = mysqli_query($conn, $sql2);               
                    if($result2 == false) throw new Exception("Select di utenti per tratta fallita");  
                    while ($row2 = $result2->fetch_assoc()){
                        if($row2["Utente"] == $log_user){
                            echo '<p style="text-align:center; color:red">Utente '.$row2["Utente"].' - Numero posti prenotati: '.$row2["Passeggeri"].'</p>';
                        } else {
                            echo '<p style="text-align:center">Utente '.$row2["Utente"].' - Numero posti prenotati: '.$row2["Passeggeri"].'</p>';
                        }
                    }                    
                    echo '<br><br>';
                }
            } else {
                while ($row = $result->fetch_assoc()){
                    if($row["TotPass"] == null){
                        $row["TotPass"] = 0;
                    }
                    
                    //stampa della scheda
                    echo '<div class="routeBox">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="pBox">Partenza: '.$boxPartenza.'</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="pBox">Num. Passeggeri: '.$row["TotPass"].'</p>
                                    </div>
                                </div>    
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p class="pBox">Destinazione: '.$boxDestinazione.'</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <img id="blueBus" src="../img/bluebust.png" alt="Blue Bus" align="right" style="padding-right:10px">
                            </div>
                        </div>
                    </div>
                    <br>';
                
                    $sql2 = "SELECT Utente, Passeggeri
                            FROM Prenotazioni
                            WHERE Partenza <= '".$boxPartenza."' AND Destinazione >= '".$boxDestinazione."' ";
                    $result2 = mysqli_query($conn, $sql2);               
                    if($result2 == false) throw new Exception("Select di utenti per tratta fallita");  
                    while ($row2 = $result2->fetch_assoc()){
                        echo '<p style="text-align:center">Utente '.$row2["Utente"].' - Numero posti prenotati: '.$row2["Passeggeri"].'</p>';
                    }                    
                    echo '<br><br>';
                }
            }                                              
        }
    }
    
    if (!mysqli_commit($conn)) {
        throw Exception("Commit fallita");
    }
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo 'Rollback: ' .$e->getMessage();
    mysqli_autocommit($conn, true);
}
mysqli_autocommit($conn, true);
mysqli_close($conn);

?>