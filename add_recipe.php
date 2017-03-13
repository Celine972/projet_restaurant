<?php
session_start();

require_once 'inc/connect.php';

if(!isset($_SESSION['is_logged']) || !$_SESSION['is_logged']) {
    header('Location: login.php');
    die;
}
$maxSize = (1024 * 1000) * 2; // Taille maximum du fichier
$uploadDir = 'assets/img/'; // Répertoire d'upload
$mimeTypeAvailable = ['image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/gif'];

$errors = [];
$post = [];
$displayForm = true;
var_dump($_SESSION['me']['id']);


if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

	 		if(empty($post['title'])){
            $errors[]='Ce titre n\'est pas valide';
            } 

            if(!empty($post['title'])){
            $post['title'] = strtoupper($post['title']) ;  
            }

            if(empty($post['ingredients'])){
            $errors[]='La liste d\'ingredients n\'est pas remplie';
            } 
    
            if(empty($post['preparation'])){
            $errors[]='La preparattion est manquante';
            }

	if(strlen($post['ingredients']) < 20){
		$errors[] = 'La liste d\'ingredients doit comporter au moins 20 caractères';
	}
    
    if(strlen($post['preparation']) < 20){
		$errors[] = 'La preparation doit comporter au moins 20 caractères';
	}


	if(isset($_FILES['picture']) && $_FILES['picture']['error'] === 0){

		$finfo = new finfo();
		$mimeType = $finfo->file($_FILES['picture']['tmp_name'], FILEINFO_MIME_TYPE);

		$extension = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

		if(in_array($mimeType, $mimeTypeAvailable)){

			if($_FILES['picture']['size'] <= $maxSize){

				if(!is_dir($uploadDir)){
					mkdir($uploadDir, 0755);
				}

				$newPictureName = uniqid('picture_').'.'.$extension;

				if(!move_uploaded_file($_FILES['picture']['tmp_name'], $uploadDir.$newPictureName)){
					$errors[] = 'Erreur lors de l\'upload de la photo';
				}
			}
			else {
				$errors[] = 'La taille du fichier excède 2 Mo';
			}

		}
		else {
			$errors[] = 'Le fichier n\'est pas une image valide';
		}
	}
	else {
		$errors[] = 'Aucune photo sélectionnée';
	}



	if(count($errors) === 0){

		if(isset($post['selected'])){
			$isSelected = 1;
		}
		else {
			$isSelected = 0;	
		}



		$query = $bdd->prepare('INSERT INTO recipe (title, ingredients, preparation, selected, picture, id_author) VALUES (:title, :ingredients, :preparation, :selected, :picture, :id_author)');
		$query->bindValue(':title', $post['title']);
		$query->bindValue(':ingredients', $post['ingredients']);
		$query->bindValue(':preparation', $post['preparation']);
		$query->bindValue(':selected',  $isSelected);
		$query->bindValue(':picture', $uploadDir.$newPictureName);
		$query->bindValue(':id_author', $_SESSION['me']['id'], PDO::PARAM_INT);

       	

		if($query->execute()){
			$success = 'Youpi, la recette a été ajoutée avec succès';
			$displayForm = false;
		}
		else {
			// Erreur de développement
			var_dump($query->errorInfo());
			die; // alias de exit(); => die('Hello world');
		}

	}
	else {
		$errorsText = implode('<br>', $errors); 
	}
}

	

?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Ajout Recette</title>

    <!-- Pour Internet Explorer : S'assurer qu'il utilise la dernière version du moteur de rendu -->
    <meta http-equiv="X-UA-Compatible" content="IE-edge">

    <!-- Affichage sans zoom pour les mobiles -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Styles CSS -->
    <link rel="stylesheet" href="#">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- HTML5 Shiv -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js" integrity="sha256-sqQlcOZwgKkBRRn5WvShSsuopOdq9c3U+StqgPiFhHQ=" crossorigin="anonymous"></script>
</head>
<body>
<main class="container">
 <?php 
	include('nav_user.php');
    
    if(isset($_SESSION['is_logged']) && $_SESSION['is_logged']){
    echo 'Bonjour '.$_SESSION['me']['firstname'].' '.$_SESSION['me']['lastname'].'.';   
    }
?>
    <header class="row">
            <div class="recette col-xs-12">
                <h1>Ajouter recette</h1>
            </div>
        </header>
	<section class="row">
            <!-- Début du Formulaire -->
            <div class="col-xs-12">
                <!-- fin du Formulaire -->

	<?php if(isset($errorsText)): ?>
		<p style="color:red;"><?php echo $errorsText; ?></p>
	<?php endif; ?>

	<?php if(isset($success)): ?>
		<p style="color:green;"><?php echo $success; ?></p>
	<?php endif; ?>


	<?php if($displayForm === true): ?>
		<form method="post" id="recette" class="form-horizontal" role="form" data-toggle="validator" enctype="multipart/form-data">
                    <fieldset>

                        <!-- Nom du formulaire-->
                        <!--<legend>Ajouter une recette</legend>-->

                        
                    </fieldset>


        <div class="col-md-4 form-group">
		<label for="title">Titre</label>
        </div>
        <div class="col-md-8 form-group">
		<input type="text" name="title" id="title" class="form-control">
        </div>

		<br>
		
		<div class="col-md-4 form-group">
		<label for="ingredients">Ingredients</label>
        </div>
        <div class="col-md-8 form-group">
		<textarea name="ingredients" id="ingredients" cols="30" rows="10" class="form-control"></textarea>
        </div>

        <br>
        
        <div class="col-md-4 form-group">
		<label for="preparation">Preparation</label>
        </div>
        <div class="col-md-8 form-group">
		<textarea name="preparation" id="preparation" cols="30" rows="10" class="form-control"></textarea>
        </div>

		<br>
        
        <div class="col-md-4 form-group">
		<label for="picture">Photo</label>
        </div>
        <div class="col-md-8 form-group">
		<input type="file" name="picture" class="form-control" id="picture" accept="image/*">
        </div>

		<br><br>

		<br><br>
		<div class="col-md-8 form-group">
		<label for="selected">Recette enregistrée</label>
        </div>
        <div class="col-md-8 form-group">
		<input type="checkbox" name="selected" id="selected" class="form-control">
        </div>


		<br><br>
		<div class="col-lg-12 form-group">
		<input type="submit" class="btn btn-primary" value="Enregistrer la recette">
        </div>
	</form>
	 <?php endif; ?>
	</div>


        </section>
    </main>
    </body>
</html>
   



 
 
 