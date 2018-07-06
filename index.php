<!DOCTYPE html>
<html lang="it">
<head>
	<title>Italy Minibus</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Ennio Riccobene">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" sizes="192x192" href="img/minibus-logo.png">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/styles.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/checkCookies.js" type="text/javascript"></script>
    
</head>
    
<?php include 'template/sessionStart.php';?>
<?php include 'template/httpsecure.php';?>
    
<body>    
    <?php include 'template/capienzabus.php';?>
    
    <header class="container-fluid">
		<div class="row">
			<div class="col-sm-9">
				<img id="logo" src="img/Ita-bus.png" alt="Italy Minibus Logo" width=30% height=30%>
			</div>
			<div class="col-sm-3" style="text-align: right">
				<a href="<?php echo $log_user_link;?>" class="a1" style="margin-right:10px"><span class="glyphicon glyphicon-log-in" style="color:white; margin-right: 5px"></span><?php echo $log_user;?></a>
				<a href="<?php echo $reg_logout_link;?>" class="a1" style="margin-right:10px"><span class="glyphicon glyphicon-user" style="color:white; margin-right: 5px"></span><?php echo $reg_logout;?></a>
			</div>
		</div>	
		
	</header>
	
	<div class="container-fluid">
		<div class="row content">
			<div class="col-sm-3 sidenav">
				<h3 id="h3nav">Italy Minibus</h3>
				<h2 id="h2nav">Italy Minibus</h2>
				<ul class="mynav">
					<li class="line"><a class="a2" href="index.php"><span id="g2" class="glyphicon glyphicon glyphicon-home" style="color:#006699; margin-right: 5px"></span> Home</a></li>
                    <hr style="border-color: white">
					<li class="line"><a class="a2" href="php/personal.php"><span class="glyphicon glyphicon-user" style="color:#006699; margin-right: 5px"></span> Pagina Personale</a></li>
					<li class="line"><a class="a2" href="php/prenotazione.php"><span class="glyphicon glyphicon-calendar" style="color:#006699; margin-right: 5px"></span> Nuova Prenotazione</a></li>
                    <li class="line"><a class="a2" href="php/disdici.php"><span class="glyphicon glyphicon-remove" style="color:#006699; margin-right: 5px"></span> Disdici Prenotazione</a></li>
				</ul>
			</div>
			
			<div class="col-sm-9">
				<br>
				<h4><small>ITINERARIO CORRENTE</small></h4>
                <noscript id="noscript"><h4 >Javascript deve essere abilitato per il corretto funzionamento del sito</h4></noscript>
				<hr>
				<p id="pcap">Capienza del minibus: <?php echo $capienzabus?></p>
                
                <?php include 'template/homeBox.php';?>

			</div>
		</div>
	</div>

</body>
</html>