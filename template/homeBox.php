<?php 

include("template/dbConnection.php");

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
            $passTot = $result->fetch_assoc();
            if($passTot["TotPass"] == null){
                $passTot["TotPass"] = 0;
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
                                    <p class="pBox">Num. Passeggeri: '.$passTot["TotPass"].'</p>
                                </div>
                            </div>    
                            <div class="row">
                                <div class="col-sm-12">
                                    <p class="pBox">Destinazione: '.$boxDestinazione.'</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <img id="blueBus" src="img/bluebust.png" alt="Blue Bus" align="right" style="padding-right:10px">
                        </div>
                    </div>
                </div>
                <br><br>';        
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