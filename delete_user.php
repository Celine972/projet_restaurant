<?php

require_once 'inc/connect.php';


if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
	$user_id = (int) $_GET['id'];

	// On sélectionne l'utilisateur pour être sur qu'il existe et faire un rappel
	$select = $bdd->prepare('SELECT * FROM users WHERE id_user = :idUser');
	$select->bindValue(':idUser', $user_id, PDO::PARAM_INT);

	if($select->execute()){
		$my_user = $select->fetch(PDO::FETCH_ASSOC);
	}
	if(!empty($_POST)){

		// Si la valeur du champ caché ayant pour name="action" est égale a delete, alors je supprime
		if(isset($_POST['action']) && $_POST['action'] === 'delete'){
			$delete = $bdd->prepare('DELETE FROM users WHERE id_user = :idUser');
			$delete->bindValue(':idUser', $user_id, PDO::PARAM_INT);

			if($delete->execute()){
				$success = 'L\'utilisateur a bien été supprimé';
			}
			else {
				var_dump($delete->errorInfo()); 
				die;
			}
		}
	}
}


?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Supprimer un utilisateur</title>

 <!-- ################	Affichage sans zoom pour les mobiles 	###################-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- ################	Bootstrap CSS 	###################-->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">    
   <!-- ################	HTML5 Shiv -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js" integrity="sha256-sqQlcOZwgKkBRRn5WvShSsuopOdq9c3U+StqgPiFhHQ=" crossorigin="anonymous"></script>


</head>
<body>

	<?php if(!isset($my_user) || empty($my_user)): ?>
		<p style="color:red">Désolé, aucun utilisateur correspondant</p>
	
	<?php elseif(isset($success)): ?>
		<?php echo $success; ?>

	<?php else: ?>
		<p>Voulez-vous supprimer : <?=$my_user['firstname'].' '.$my_user['lastname']. ' - '.$my_user['email'];?>

	<form method="post">
		
		<input type="hidden" name="action" value="delete">

		<!-- history.back() permet de revenir à la page précédente -->
		<button type="button" class="btn btn-primary" onclick="javascript:history.back();">Annuler</button>
		<input type="submit" class="btn btn-primary" value="Supprimer cet utilisateur">

       	</form>
	<?php endif; ?>



	

</body>
</html>