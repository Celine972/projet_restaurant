<?php
session_start();

if(!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
    header('Location: login.php');
    die;
}
require_once 'inc/connect.php';
// Jointure SQL permettant de récupérer la recette & le prénom & nom de l'utilisateur l'ayant publié
	$selectOne = $bdd->prepare('SELECT * FROM users INNER JOIN recipe ON users.id_user = recipe.id_author WHERE users.id_user = recipe.id_author');

	if($selectOne->execute()){
		$products = $selectOne->fetchAll(PDO::FETCH_ASSOC);
	}
	else {
		// Erreur de développement
		var_dump($selectOne->errorInfo());
		die; // alias de exit(); => die('Hello world');
	}

//// On selectionne les colonnes id & title de la table products
//$select = $bdd->prepare('SELECT * FROM recipe ORDER BY title DESC');
//if($select->execute()){
//	$products = $select->fetchAll(PDO::FETCH_ASSOC);
//}
//else {
//	// Erreur de développement
//	var_dump($select->errorInfo());
//	die; // alias de exit(); => die('Hello world');
//}

?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Liste des Recettes</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">


        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body>
        <?php 
	
	?>

            <br>

            <div class="container">
                <h2>Les Recettes existantes</h2>
          
                        <!-- foreach permettant d'avoir une ligne <tr> par ligne SQL -->
                        <?php foreach($products as $product): ?>
                             <div class="row">
  <div class="col-sm-6 col-xs-3">
    <div class="thumbnail">
      <img src="<?=$product['picture']; ?>" alt="" width="150px" height="auto">
      <div class="caption">
        <h3><?=$product['title']; ?></h3>
        <p><?=$product['firstname'].' '.$product['lastname']; ?></p>
        <p><a href="view_recipe.php?id=<?=$product['id_recipe']; ?>" class="btn btn-default">Visualiser</a> <?php
                                if($_SESSION['me']['role']==='Administrateur')
                                    {?><a href="delete_recipe.php?id=<?=$product['id_recipe']; ?>" class="btn btn-default">Supprimer</a></p><?php }
                                ?>
      </div>
    </div>
  </div>
</div>
                            <?php endforeach; ?>
            </div>
    </body>

    </html>
 