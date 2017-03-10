<?php
session_start();
require_once 'inc/connect.php';

//if(!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
//    header('Location: login.php');
//    die;
//}

// On selectionne les colonnes id & title de la table products
$select = $bdd->prepare('SELECT id_recipe,title, id_user, content FROM recipe ORDER BY title DESC');
if($select->execute()){
	$productss = $select->fetchAll(PDO::FETCH_ASSOC);
}
else {
	// Erreur de développement
	var_dump($query->errorInfo());
	die; // alias de exit(); => die('Hello world');
}

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
	include('header.php');
	?>

            <br>

            <div class="container">
                <h2>Les Produits existants</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Détails</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- foreach permettant d'avoir une ligne <tr> par ligne SQL -->
                        <?php foreach($productss as $products): ?>
                            <tr>
                                <td>
                                    <?=$products['id_recipe']; ?>
                                </td>
                                <td>
                                    <?=$products['title']; ?>
                                </td>
                                <td>
                                    <?=$products['content']; ?>
                                </td>
                                <td>
                                    <!-- view_products.php?id=6 -->
                                    <a href="view_recipe.php?id=<?=$products['id_recipe']; ?>">
							Visualiser
						</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
    </body>

    </html>