<?php
session_start();

if(!isset($_SESSION['is_logged']) || $_SESSION['is_logged'] == false){
 	// Redirection vers la page de connexion si non connecté
 	header('Location: login.php');
 	die; 
}

if(!empty($_POST)){
	if(isset($_POST['action']) && $_POST['action'] === 'disconnect'){
		// L'internaute à cliquer sur "se deconnecter"
		
		unset($_SESSION['me']); // Détruit uniquement la clé "me" et sa valeur de $_SESSION
		
		// Détruit tout ce qui est relatif à la session
		$_SESSION = []; // équivalent à session_unset() (obsolète) 
		session_destroy(); // détruit le cookie

	 	header('Location: index.php');
 		die; 
	}
}

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Déconnexion</title>

    <meta http-equiv="X-UA-Compatible" content="IE-edge">

    <!-- Affichage sans zoom pour les mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

     <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- HTML5 Shiv -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js" integrity="sha256-sqQlcOZwgKkBRRn5WvShSsuopOdq9c3U+StqgPiFhHQ=" crossorigin="anonymous"></script>

</head>
<body>

	<form method="post">
		<input type="hidden" name="action" value="disconnect">

		<!-- history.back() permet de revenir à la page précédente -->
       <?php echo ($_SESSION['me']['firstname']).' '.($_SESSION['me']['lastname']).' êtes vous sûr de vouloir vous déconnectez? <br>' ;?>
	<br>
    	<button type="button" class="btn btn-primary" onclick="javascript:history.back();">Annuler</button>
		<input type="submit" class="btn btn-primary" value="Se déconnecter">
	</form>

</body>
</html>