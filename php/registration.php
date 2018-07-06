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
    <script src="../js/passwordStrength.js" type="text/javascript"></script>
    <script src="../js/checkCookies2.js" type="text/javascript"></script>
</head>
    
<?php include '../template/sessionStart.php';?>
<?php include '../template/httpsecure.php';?>
    
<body>
    <?php include '../template/header.php';?>
	
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
                
                <?php include 'regField.php';?>
                
				<br>
				<h4><small>REGISTRAZIONE</small></h4>
                <noscript><h4 style="color: red">Javascript deve essere abilitato per il corretto funzionamento del sito</h4></noscript>
				<hr>
                
                <?php if(!$session){ ?>
                
                <p>Come username va inserito un indirizzo email.</p>
                <p>Inserire una password contenente almeno una lettera minuscola e una maiuscola o un numero, le password troppo brevi o deboli non saranno accettate.</p>
                <p>I campi seguenti sono tutti obbligatori.</p><br>
                
                <form id="register" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
                    
                    <div class="form-group">
                        <label for="email">Username:</label>
                        <input type="email" class="form-control" id="email" placeholder="Inserisci un indirizzo email valido" name="email" value="<?php echo $email ?>">
                        <span class="error"><?php echo $emailErr ?></span>
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" class="form-control" id="pwd" placeholder="Inserire una password contenente almeno una lettera minuscola e una maiuscola o un numero" name="pwd" value="<?php echo $pswd ?>">
                        <span id="result"></span><br>
                        <span class="error"><?php echo $pswdErr ?></span>
                    </div>
                    <br>
                      
                    <div style="text-align: center">
                        <button type="submit" class="button">Registrati</button>
                    </div>
                    
                </form>
                
                <br><br>
                
                <?php 
                } else{
	                   echo ' <p>Benvenuto su Italy Minibus '.$_SESSION['name'].'!!</p>
	                   <br>
	                   <p>Effettua il <a href="../php/logout.php">Logout</a> per registrare un nuovo utente.</p>';
                }
                ?>
				  
			</div>
		</div>
	</div>

</body>
</html>