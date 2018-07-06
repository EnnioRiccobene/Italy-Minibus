<!DOCTYPE html>
<html lang="it">
<head>
	<title>Italy Minibus</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Ennio Riccobene">
	<link rel="icon" sizes="192x192" href="../img/minibus-logo.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/styles.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../js/checkCookies2.js" type="text/javascript"></script>
    <script>
        $( document ).ready(function () {
            setTimeout(function() {
                window.location.replace("../index.php");
            }, 120000);//2 minutes
        });
    </script>
    
</head>
    
<?php include '../template/sessionStart.php';?>
<?php include '../template/httpsecure.php';?>
    
<body>
    <?php include '../template/header.php';?>
    <?php include '../template/capienzabus.php';?> 
    <?php include '../template/dbConnection.php';?>
    
	<div class="container-fluid">
		<div class="row content">
			<div class="col-sm-3 sidenav">
				<h3 id="h3nav">Italy Minibus</h3>
				<h2 id="h2nav">Italy Minibus</h2>
				<ul class="mynav">
					<li class="line"><a class="a2" href="../index.php"><span class="glyphicon glyphicon glyphicon-home" style="color:#006699; margin-right: 5px"></span> Home</a></li>
                    <hr style="border-color: white">
					<li class="line"><a class="a2" href="personal.php"><span class="glyphicon glyphicon-user" style="color:#006699; margin-right: 5px"></span> Pagina Personale</a></li>
					<li class="line"><a class="a2" href="prenotazione.php"><span class="glyphicon glyphicon-calendar" style="color:#006699; margin-right: 5px"></span> Nuova Prenotazione</a></li>
                    <li class="line"><a class="a2" href="disdici.php"><span class="glyphicon glyphicon-remove" style="color:#006699; margin-right: 5px"></span> Disdici Prenotazione</a></li>
				</ul>
			</div>
			
			<div class="col-sm-9">
                 
				<br>
				<h4><small>NUOVA PRENOTAZIONE</small></h4>
                <noscript><h4 style="color: red">Javascript deve essere abilitato per il corretto funzionamento del sito</h4></noscript>
				<hr>
                
                                            
                <?php 
                    $userPrenotato = false; //falso se user non prenotato
                    $msgP = false; //falso se user non ha tentato la prenotazione
                
                    if($log_user != "Login"){//utente loggato
                ?>
                  
                        <p>L'utente può fare una sola prenotazione per una o più persone, fino a raggiungere la capienza dell'autobus. </p>
                        <p>La prenotazione non può essere modificata. Disdire la prenotazione precedente se non si vuole più fare il viaggio o se si vuole effettuare una nuova prenotazione.</p>
                        
                <?php        
                        $conn=connect();
                        $sql = "SELECT COUNT(*) AS NumPren
                                FROM Prenotazioni
                                WHERE Utente = '".$log_user."';";
                        $result = mysqli_query($conn, $sql);
                        $numPren = $result->fetch_assoc();
                        mysqli_close($conn);
                        
                        if($numPren["NumPren"] > 0){
                            $userPrenotato = true;
                        }
                
                        if ($userPrenotato == true) {
                            echo '<p style="color: red">Prenotazione già effettuata</p>';
                        } else {//utente non prenotato  
                ?>
                
                <br>
                <!--<form method="post" action="prenAction.php">-->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <p>Partenza: 
                    <select id="selPartenza" name="selPartenza">
                        <option disabled selected value>Seleziona un'opzione</option>
                        <option value="0">Altro</option>
                        <?php 
                            $conn=connect();
                            $sql = "SELECT Luogo 
                                    FROM Luoghi 
                                    ORDER BY Luogo;";
                            $result = mysqli_query($conn, $sql);
                            $arrayPartenze = array();
                            while ($row = $result->fetch_assoc()) {
                                array_push($arrayPartenze, $row["Luogo"]);
                            }
                            $i = 0;
                            while ($i < count($arrayPartenze)) {                      
                                echo '<option value="'.$arrayPartenze[$i].'">'.$arrayPartenze[$i].'</option> '; 
                                $i++;
                            }
                            mysqli_close($conn);
                        ?>                                       
                    </select>
                    </p>     
                                
                    <textarea id="textP" name="textP" placeholder="Aggiungi qui l'indirizzo di partenza se non lo trovi mell'elenco precedente."></textarea>
                    <br><br>
                    
                    <script>
                    $('#selPartenza').on('change', function(){
                        if(this.value != 0)
                            $('#textP').prop('disabled', true)
                        else
                            $('#textP').prop('disabled', false)
                        });
                    </script>
                
                    <p>Destinazione: 
                    <select id="selDestinazione" name="selDestinazione">
                        <option disabled selected value>Seleziona un'opzione</option>
                        <option value="0">Altro</option>
                        <?php 
                            $i = 0;
                            while ($i < count($arrayPartenze)) {                      
                                echo '<option value="'.$arrayPartenze[$i].'">'.$arrayPartenze[$i].'</option> '; 
                                $i++;
                            }                        
                        ?>
                    </select>
                    </p>
                    <textarea id="textD" name="textD" placeholder="Aggiungi qui l'indirizzo di destinazione se non lo trovi mell'elenco precedente."></textarea>
                    <br><br>
                
                    <script>
                    $('#selDestinazione').on('change', function(){
                        if(this.value != 0)
                            $('#textD').prop('disabled', true)
                        else
                            $('#textD').prop('disabled', false)
                        });
                    </script>
				
                    <p>Numero di passeggeri:
                    <select id="selPasseggeri" name="selPasseggeri">
                        <?php
                            $i = 1;
                            while($i <= $capienzabus){
                                echo '<option value="'.$i.'">'.$i.'</option>\n';
                                $i = $i + 1;
                            }
                        ?>
                    </select>
                    </p>
                    <br><br>
                    <div style="text-align: center">
                        <button id="prenotaButton" name='prenotaButton' type="submit" class="button">Prenota</button>
                    </div>
                                        
                </form>
                <br><br>
                
                <?php                  
                    include 'prenAction.php';
                            
                    if($msgP == true and $userPrenotato == true){
                    //se la prenotazione ha avuto successo
                        echo '<p style="color: red">Prenotazione effettuata con successo.</p>';                        
                    } else if($msgP == true and $userPrenotato == false) {
                    //se la prenotazione non ha avuto successo
                        echo '<p style="color: red">Prenotazione non riuscita. Selezionare un numero di passeggeri che consenta di non superare la capienza del minibus. Selezionare una destinazione che, in ordine alfabetico, venga dopo del luogo di partenza.</p>';
                    } 
                ?>
                
                <?php 
                        }

                    } else {
                        echo '<p style="color: red">Effettuare il login per accedere alla pagina</p>';
                    }
                ?>

                <br><br>
                
			</div>
		</div>
	</div>

</body>
</html>