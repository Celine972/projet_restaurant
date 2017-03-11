<?php session_start();

require_once 'inc/connect.php';

$errors = []; // tableau des erreurs
$post = []; // tableau input apres _POST
$displayForm = true; // affichage formulaire




if(!empty($_POST)){  // si la super globale $_POST n'est pas vide 
	
    foreach($_POST as $key => $value){ // pour chaque valeur liée à une clé
		$post[$key] = trim(strip_tags($value));// on nettoie les variables de tout html ou php "insécurisés
	}

	if(strlen($post['firstname']) < 2  || strlen($post['firstname']) > 20){
		$errors[] = 'Votre prénom doit comporter entre 2 et 20 caractères';
	}

    if(strlen($post['lastname']) < 2  || strlen($post['lastname']) > 20){
		$errors[] = 'Votre nom doit comporter entre 2 et 20 caractères';
	}

    if(!filter_var($post['mail'], FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Votre email n'est pas conforme";
	}
        
    if(strlen($post['object']) < 5  || strlen($post['object']) > 15){
		$errors[] = 'L\'objet de votre mesage doit comporter entre 5 et 15 caractères';
	}
    
	if(strlen($post['content']) < 20 || strlen($post['content']) > 100){
		$errors[] = 'La description doit comporter au moins 20 au plus 100 caractères';
	}

	
	
	if(count($errors) === 0){

		//$date = date("Y-m-d H:i:s");
        
        //echo $date;
        
		$query = $bdd->prepare('INSERT INTO message (date, firstname ,lastname, mail, object, content) VALUES (now(), :firstname, :lastname, :mail, :object, :content)');

		//$query->bindValue(':date', $date); // PDO::PARAM_STR est le paramètre par défaut et donc non obligatoire si on traite un string
		$query->bindValue(':firstname', $post['firstname']);
		$query->bindValue(':lastname', $post['lastname']);
		$query->bindValue(':mail', $post['mail']);
		$query->bindValue(':object', $post['object']);
		$query->bindValue(':content', $post['content']);

		if($query->execute()){
			$success = 'Votre message a été envoyée !<br>A très bientôt dans notre établissement !';
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



?>


<!DOCTYPE html>
<html lang="fr">
<head>

    <!-- Encodage pour les accents -->
    <meta charset="UTF-8">
    
    <!-- ################	Titre de la Page -->
    <title>Contact !</title>
    
    <!-- ################	Pour Internet Explorer : S'assurer qu'il utilise
	la dernière version du moteur de rendu 	###################-->    
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    
    <!-- ################	Affichage sans zoom pour les mobiles 	###################-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
	<!-- ################	Font awesome	###################-->
    
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed" rel="stylesheet">
	
    <!-- ################	Bootstrap CSS 	###################-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <!-- ################	Normalize CSS 	Inutile si bootstrp CSS ###################
	<link rel="stylesheet" href="assets/css/normalize.css">-->
	
	<!-- ################	Styles CSS 	###################-->
    <link rel="stylesheet" href="assets/css/styles.css">
    
    <!-- ################	HTML5 Shiv -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js" integrity="sha256-sqQlcOZwgKkBRRn5WvShSsuopOdq9c3U+StqgPiFhHQ=" crossorigin="anonymous"></script>
    
    <style>

        
    </style>
    
</head>
<body>

<header>
    
    
    
    
</header>


<main id="contact">
            <div class="container">
                <div class="row">
                    
                    <?php 
                    
                    
                    
                    if($displayForm = true){?>
                        
                                        
                    
                    <h3>Message</h3>
                    <div class="col-sm-8 col-sm-push-2 col-xs-10 col-xs-push-1">
                        
                            
                        <form id="contact-form" class="form-horizontal" 
                             method="post">
                            
            <!----------------- Nom et Prénom -------------------------->
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-5 col-lg-6">
                                    <input name="firstname" required class="form-control" type="text" placeholder="Saisissez votre Prénom">
                                </div>
                                
                                <div class="col-xs-12 col-sm-5 col-lg-6">
                                    <input name="lastname" required class="form-control" type="text" placeholder="Saisissez votre Nom">
                                </div>
                            </div>
                            
                            
            <!--------------------- mail & tel -------------------------->
                            <div class="form-group">
                                
                                <div class="col-sm-5">
                                    <input name="mail" required class="form-control" type="email" placeholder="Saisissez votre Email">
                                </div>
                                
                                <!--<div class="col-sm-6">
                                    <input name="telephone" type="tel" placeholder="Saisissez votre Téléphone" class="form-control">
                                </div>-->
                                
                            </div> 
                            
            <!--------------------- /mail & tel -------------------------->                
            <!------------------------ sujet -------------------------->                
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <input name="object" required class="form-control" type="text" placeholder="Saisissez votre Sujet">
                                </div>
                            </div>
                            
            <!----------------------- Message ----------->
                            <div class="form-group">
                              <div class="col-xs-12">
                                  <textarea id="content" name="content" rows="8" placeholder="Message" class="form-control"></textarea>           
                              </div>
                            </div>
            <!----------------------- /Message ---------------------->                
            <!-------------------- Bouton d'Envoi ------------------->
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-primary" name="contact" value="Envoyer ma Demande">Envoyer ma Demande</button>
                                </div>
                            </div>
            <!-------------------- /Bouton d'Envoi ------------------->                
                        </form>    
                    </div>
                </div>
            </div>
</main>

<?php }
    
    else echo $errorsText; ?>

<footer>
        <div class="row">
                <div class="col-xs-12">
                <p>Une Réalisation CJCC - Martinique</p>
                </div>
        </div>
</footer>

</body>






