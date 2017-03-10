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

if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

	 		if(empty($post['title'])){
            $errors[]='Ce nom n\'est pas valide';
            } 

            if(!empty($post['title'])){
            $post['title'] = strtoupper($post['title']) ;  
            }

            if(empty($post['id_recipe'])){
            $errors[]='Ce prénom n\'est pas valide';
            } 

            if(!empty($post['id_recipe'])){
            $post['id_recipe'] = ucfirst($post['id_recipe']) ;  
            }

	if(strlen($post['content']) < 20){
		$errors[] = 'La description doit comporter au moins 20 caractères';
	}

	if(strlen($post['id_recipe'])!==10)
        {   
        // Séléction du maximum de caractères
            $errors[]='Le numéro de reference doit faire 10 chiffres. ';
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


		$query = $bdd->prepare('INSERT INTO recipe (title, id_recipe, content, id_user, selected, picture) VALUES(:title, :id_recipe, :content, :id_user, :selected, :picture)');

		$query->bindValue(':title', $post['title']); // PDO::PARAM_STR est le paramètre par défaut et donc non obligatoire si on traite un string
		$query->bindValue(':id_recipe', $post['id_recipe']);
		$query->bindValue(':content', $post['content']);
        $query->bindValue(':id_user', $post['id_user'], PDO::PARAM_INT);
		$query->bindValue(':selected', $isSelected, PDO::PARAM_INT);
		$query->bindValue(':picture', $uploadDir.$newPictureName);
		

		if($query->execute()){
			$success = 'Youpi, l\'utilisateur a été ajouté avec succès';
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
<link rel="stylesheet" href="..assets/css/style.css">
</head>
<body>
<?php 
include('header.php'); 
    if(isset($_SESSION['is_logged']) && $_SESSION['is_logged']){
    echo 'Bonjour '.$_SESSION['me']['firstname'].' '.$_SESSION['me']['lastname'].'.';   
    }
?>
	<h1>Enregistrer une recette</h1>

	<?php if(isset($errorsText)): ?>
		<p style="color:red;"><?php echo $errorsText; ?></p>
	<?php endif; ?>

	<?php if(isset($success)): ?>
		<p style="color:green;"><?php echo $success; ?></p>
	<?php endif; ?>


	<?php if($displayForm === true): ?>

	<form method="post" enctype="multipart/form-data">

		<label for="title">Titre</label>
		<input type="text" name="title" id="title">

		<br>

		<label for="comment">Description</label>
		<textarea name="comment" id="comment" cols="30" rows="10"></textarea>

		<br>

		<label for="picture">Photo</label>
		<input type="file" name="picture" id="picture" accept="image/*">

		<br><br>

		<br><br>
		<label for="selected">Recette enregistrée</label>
		<input type="checkbox" name="selected" id="selected"> Oui


		<br><br>
		<input type="submit" value="Enregistrer la recette'">
	</form>
	<?php endif; ?>

<p>gsjfshfgsjgfsjfgjfsjg</p>
</body>
</html>

