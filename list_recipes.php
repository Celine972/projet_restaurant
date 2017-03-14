<?php
session_start();

if(!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
    header('Location: login.php');
    die;
}
var_dump($_SESSION['me']['role']);
require_once 'inc/connect.php';

// view_menu.php?id=6

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
	include('nav_user.php');
	?>

            <br>

            <div class="container">
                <h2>Les Recettes existantes</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>ID_AUTHOR</th>
                            <th>NOM</th>
                            <th>PRENOM</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- foreach permettant d'avoir une ligne <tr> par ligne SQL -->
                        <?php foreach($products as $product): ?>
                            <tr>
                                <td>
                                    <?=$product['id_recipe']; ?>
                                </td>
                                <td>
                                    <?=$product['title']; ?>
                                </td>
                            
                                <td>
                                    <?=$product['firstname']; ?>
                                </td>
                                <td>
                                    <?=$product['lastname']; ?>
                                </td>
                                <td>
                                    <!-- view_products.php?id=6 -->
                                    <a href="view_recipe.php?id=<?=$product['id_recipe']; ?>">
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