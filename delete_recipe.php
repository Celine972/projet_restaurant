<?php

require_once 'inc/connect.php';
// Permet de vérifier que mon id est présent et de type numérique
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
	$recipe_id = (int) $_GET['id'];

	// On sélectionne l'utilisateur pour être sur qu'il existe et faire un rappel
	$select = $bdd->prepare('SELECT * FROM recipe WHERE id = :id_recipe');
	$select->bindValue(':id_reciped_', $recipe_id, PDO::PARAM_INT);

	if($select->execute()){
		$my_recipe = $select->fetch(PDO::FETCH_ASSOC);
	}
	if(!empty($_POST)){
		// Si la valeur du champ caché ayant pour name="action" est égale a delete, alors je supprime
		if(isset($_POST['action']) && $_POST['action'] === 'delete'){
			$delete = $bdd->prepare('DELETE FROM recipe WHERE id = :id_recipe');
			$delete->bindValue(':id_recipe', $recipe_id, PDO::PARAM_INT);

			if($delete->execute()){
				$success = 'La recette à bien été supprimer';
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
	<title>Supprimer une recette</title>
</head>
<body>

	<?php if(!isset($my_recipe) || empty($my_recipe)): ?>
		<p style="color:red">Désolé, aucune recette correspondante</p>
	
	<?php elseif(isset($success)): ?>
		<?php echo $success; ?>

	<?php else: ?>
		<p>Voulez-vous supprimer la recette : <?=$my_recipe['title'];?>

	<form method="post">
		
		<input type="hidden" name="action" value="delete">

		<!-- history.back() permet de revenir à la page précédente -->
		<button type="button" onclick="javascript:history.back();">Annuler</button>
		<input type="submit" value="Supprimer cette recette">
	</form>
	<?php endif; ?>

</body>
</html>