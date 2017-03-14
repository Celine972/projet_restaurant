<?php

require 'inc/connect.php';

$errors = [];
$post = []; // Contiendra les données épurées <3 <3
$displayForm = true; // Cette variables permet d'afficher mon Formulaire

if(!empty($_POST)){

foreach($_POST as $key => $value){
        $post[$key] = trim(strip_tags($value));
    }
     //Vérification sur le nom
    if(empty($post['firstname'])){
        $errors[] = 'Le champ nom doit être complété';
    }
    
    //Vérification sur le prénom
    if(empty($post['lastname'])){
        $errors[] = 'Le champ prénom doit être complété';
    }

    //Vérification du password
    if(strlen($post['password']) < 8 || strlen($post['password']) > 20) {
		$errors[] = "Le champ Password doit avoir au minimum 8 caractères";
	}

    //Vérification sur le pseudo
    if(empty($post['nickname'])){
        $errors[] = 'Le champ pseudo doit être complété';
    }
    
    //Vérification que l'email soit bien rempli
    if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
     $errors[] = "Cette adresse email est considérée comme invalide.";
    } 
    
    //Vérification du role
	if(empty($post['role'])){
	 	$errors[] = 'Veuillez choisir le role';
     }   

    	if(count($errors) === 0){

		$insert = $bdd->prepare('INSERT INTO users (lastname, firstname, password, email, nickname, role) VALUES (:lastname, :firstname, :password, :email, :nickname, :role)');
		$insert->bindValue(':lastname', $post['lastname']);
		$insert->bindValue(':firstname', $post['firstname']);
		$insert->bindValue(':password', password_hash($post['password'], PASSWORD_DEFAULT));
		$insert->bindValue(':email', $post['email']);
		$insert->bindValue(':nickname', $post['nickname']);
		$insert->bindValue(':role', $post['role']);
		
		if($insert->execute())
		{
			$success = 'Félicitations vous êtes inscrit';
            
		}
		else
		{
			var_dump($insert->errorInfo());
		}
	}
	else
	{
		$textErrors = implode('<br>', $errors);
	}
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <!-- Titre de la Page -->
    <title>Ajout utilisateur</title>

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

     <div class="col-xs-12">
    <?php
        // Affichage du message d'erreur
        if(isset($textErrors)){
            echo '<p style="color:red">'.$textErrors.'</p>';
        }
        // Affichage du success
        if(isset($success)){
            echo '<p style="color:green">'.$success.'</p>';
        }
    ?>
    </div>
        <header class="row">
            <?php include('nav_admin.php'); ?>

            <div class="contact col-xs-12 text-center">
                <h1>Ajout contact</h1>
            </div>
        </header>

        <section class="row">
            <!-- Début du Formulaire -->
            <div class="col-md-6 col-md-offset-3">
                <!-- fin du Formulaire -->

                <?php if($displayForm === true): ?>
                <form method="post" id="contact" class="form-horizontal" role="form" data-toggle="validator">


                    <!-- Nom -->
                    
                    <div class="col-md-12 form-group">
                        <input id="lastname" type="text" name="lastname" placeholder="Nom" class="form-control">
                    </div>

                    <!-- Prénom -->
                    <div class="col-md-12 form-group">                      
                        <input id="firstname" type="text" name="firstname" placeholder="Prénom" class="form-control">         
                    </div>

                    <!-- Password -->
                    
                    <div class="col-md-12 form-group">
                        <input id="password" type="password" name="password" placeholder="password" class="form-control">      
                    </div>

                    <!-- Pseudo -->
                    
                    <div class="col-md-12 form-group">         
                        <input id="nickname" type="nickname" name="nickname" placeholder="Pseudo" class="form-control">                
                    </div>

                    <!-- Email -->
                    
                    <div class="col-md-12 form-group">                      
                        <input id="email"type="email" name="email" placeholder="Email" class="form-control">                  
                    </div>

                    <!-- Role -->
    
                    <div class="col-md-12 form-group">
                        
                        <select class="form-control" id="role" name="role">
                                    <option>-- Sélectionnez --</option>
                                    <option>Administrateur</option>
                                    <option>Auteur</option>
                        </select>
                
                    </div>

                    <!-- Submit -->
                    <div class="col-lg-12 form-group">
                        <button type="submit" class="btn btn-primary" name="contact" value="Ajouter Contact">Ajouter contact</button>
                    </div>

                </form>
                <!-- Fin de mon formulaire -->
                <?php endif; ?>
            </div>


        </section>

    </main>

    <section_2>
    
    </section_2>    
        <footer>
                <div class="row">
                        <div class="col-xs-12">
                        <p style="text-align:center">Une Réalisation CJCC - Martinique</p>
                        </div>
                </div>
        </footer>

</body>

</html>