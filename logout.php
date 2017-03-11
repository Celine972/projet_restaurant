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

	 	header('Location: login.php');
 		die; 
	}
}

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Déconnexion</title>
</head>
<body>

	<form method="post">
		<input type="hidden" name="action" value="disconnect">

		<!-- history.back() permet de revenir à la page précédente -->
		<button type="button" onclick="javascript:history.back();">Annuler</button>
		<input type="submit" value="Se déconnecter">
	</form>

</body>
</html>