<?php
session_start();
require_once 'inc/connect.php';

$recette = [];
// view_menu.php?id=6
if(isset($_GET['id']) && !empty($_GET['id'])){
    
    // int permet de renvoyer un entier
    $idRecette = (int) $_GET['id'];
    
    
    $selectOne = $bdd->prepare('SELECT *, firstname, lastname FROM recipe INNER JOIN users ON id_user = id_recipe WHERE id_recipe = :idRecette');
    $selectOne->bindValue(':idRecette', $idRecette, PDO::PARAM_INT);
    
    if($selectOne->execute()){
        $recette = $selectOne->fetch(PDO::FETCH_ASSOC);
    }
    else {
        // Erreur de développement
        var_dump($selectOne->errorInfo());
        die; // alias de exit(); => die('Hello world');
    }
    
    
    
    // $selectOne = $bdd->prepare('SELECT * FROM recipe WHERE id_recipe = :idRecette');
    // $selectOne->bindValue(':idRecette', $idRecette, PDO::PARAM_INT);
    
    // if($selectOne->execute()){ // Exécution requête SQL
    // 	$recette = $selectOne->fetch(PDO::FETCH_ASSOC); // utiliser FETCH_ASSOC pour un meilleur afichage
    // }
    // else {
    // 	// Erreur de développement
    // 	var_dump($query->errorInfo());
    // 	die; // alias de exit(); => die('Hello world');
    // }
}

?>




  <!DOCTYPE html>
  <html lang="fr" <meta charset="utf-8">

  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed" rel="stylesheet">

    <title>Recette détaillée</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style_view_recipe.css">

  </head>



  <body class="view_recipe">
    <?php
if($_SESSION['me']['role'] == 'Administrateur'){
include 'nav_admin.php';}

if($_SESSION['me']['role'] == 'Auteur'){
include 'nav_chef.php';}







?>

      <?php if(!empty($recette)): ?>

        <div class="container">

          <?php
if($_SESSION['me']['role']=='Administrateur'){
    include 'nav_admin.php';
}else {
    include 'nav_chef.php';
}
?>
            <div class="card">
              <div class="container-fliud">
                <div class="wrapper row">
                  <div class="preview col-md-6">

                    <div class="preview-pic tab-content">
                      <div class="tab-pane active" id="pic-1"><img src="<?php echo $recette['picture'];?>" /></div>
                      <!--Mettre l'image uploader
<div class="tab-pane active" id="pic-1"><img src="<?php echo $recette['picture'];?>" /></div>-->

                    </div>


                  </div>
                  <div class="details col-md-6">
                    <h3 class="product-title"><?php echo $recette['title'];?></h3>

                    <div class="details col-md-12">

                      <p>Publié par :
                        <?php echo ' '.nl2br($recette['firstname']).' '.($recette['lastname']);?>
                      </p>


                    </div>

                    <div class="details col-md-12">

                      <h2>Ingrédients</h2>
                    </div>

                    <div class="details col-md-6">

                      <p class="product-description">
                        <?php echo nl2br($recette['ingredients']);?>
                      </p>
                    </div>

                  </div>
                </div>
              </div>
              <div class="container-fliud">
                <div class="details col-md-12">
                  <h2>Préparation</h2>
                </div>
                <p class="product-description">
                  <?php echo $recette['preparation'];?>
                </p>
              </div>
            </div>
        </div>
        <?php else:?>
          Aucune recette trouvée !
          <?php endif; ?>


  </body>

  </html>