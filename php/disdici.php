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
				<h4><small>DISDICI PRENOTAZIONE</small></h4>
                <noscript><h4 style="color: red">Javascript deve essere abilitato per il corretto funzionamento del sito</h4></noscript>
				<hr>
                
                                            
                <?php 
                    $userPrenotato = false; //falso se user non prenotato
                    $msgD = false; //falso se user non ha tentato la disdetta
                
                    if($log_user != "Login"){//utente loggato
                ?>
                  
                        <p>Effettuando la disdetta sarà possibile effettuare una nuova prenotazione.</p>
                        
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
                
                        if ($userPrenotato == false) {
                            echo '<p style="color: red">Non esiste nessuna prenotazione attiva per l&rsquo;utente.</p>';
                        } else {//utente non prenotato  
                ?>
                
                <br>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  
                    <br><br>
                    <div style="text-align: center">
                        <button id="disdiciButton" type="submit" class="button">Disdici</button>
                    </div>
                                        
                </form>
                <br><br>
                
                <?php                  
                    include 'disdiciAction.php';
                            
                    if($msgD == true and $userPrenotato == false){
                    //se la prenotazione ha avuto successo
                        echo '<p style="color: red">Disdetta effettuata con successo. Ora è possibile effettuare una nuova prenotazione.</p>';                        
                    } else if($msgD == true and $userPrenotato == true) {
                    //se la prenotazione non ha avuto successo
                        echo '<p style="color: red">Disdetta non riuscita, se la sessione è scaduta, effettuare il login e ritentare.</p>';
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