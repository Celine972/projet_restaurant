<?php
//var_dump($_GET).

require_once 'inc/connect.php';
// Permet de vérifier que mon id est présent et de type numérique
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
	$id_mess_to_delete = (int) $_GET['id'];
    
    //echo '<br>';
    //var_dump($id_mess_to_delete);
	// On sélectionne le message pour être sur qu'il existe et faire un rappel
	$select = $bdd->prepare('SELECT * FROM message WHERE id_message = :id_mess_to_delete');
	$select->bindValue(':id_mess_to_delete', $id_mess_to_delete, PDO::PARAM_INT);

   
    
	if($select->execute()){
		$mess_to_delete = $select->fetch(PDO::FETCH_ASSOC);
        
        //echo '<br>';
        //var_dump($mess_to_delete);
	}
	if(!empty($_POST)){
		// Si la valeur du champ caché ayant pour name="action" est égale a delete, alors je supprime
		if(isset($_POST['action']) && $_POST['action'] === 'delete'){
			$delete = $bdd->prepare('DELETE FROM message WHERE id_message = :id_mess_to_delete');
			$delete->bindValue(':id_mess_to_delete', $id_mess_to_delete, PDO::PARAM_INT);

			if($delete->execute()){
				$success = 'Le message à bien été supprimé !';
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
	<title>Suppression du message</title>
</head>
<body>

	<?php if(!isset($id_mess_to_delete) || empty($id_mess_to_delete)): ?>
		<p style="color:red">Désolé, aucun message correspondant</p>
	
	<?php elseif(isset($success)): ?>
		<?php echo $success; 
            include 'message.php';
                    ?>
        

	<?php else: ?>
		<p>Voulez-vous supprimer le message de  <?= $mess_to_delete['firstname'].' '.$mess_to_delete['lastname'];?>

	<form method="post">
		
		<input type="hidden" name="action" value="delete">

		<!-- history.back() permet de revenir à la page précédente -->
		<button type="button" onclick="javascript:history.back();">Annuler</button>
		<input type="submit" value="Supprimer ce message">
	</form>
	<?php endif; ?>
