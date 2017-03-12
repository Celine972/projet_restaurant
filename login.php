<?php
session_start();
require_once 'inc/connect.php';

$post = [];
$errors = [];

if(!empty($_POST)){
	// Nettoyage des données
	foreach($_POST as $key => $value){
		$post[$key] = trim(strip_tags($value));
	}

	if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
		$errors[] = 'L\'adresse email est invalide';
	}
	if(empty($post['password'])){
		$errors[] = 'Le mot de passe doit être complété';
	}

	if(count($errors) === 0){
		$select = $bdd->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
		$select->bindValue(':email', $post['email']);
		if($select->execute()){
			// Permet de stocker l'utilisateur correspondant à l'email dans $user
			$user = $select->fetch(PDO::FETCH_ASSOC);

			if(!empty($user)){
				if(password_verify($post['password'], $user['password'])){
					// Ici le mot de passe saisi correspond à celui en base de données
					$_SESSION['is_logged'] = true;
					$_SESSION['me'] = [
						'id' 		=> $user['id_user'],
						'firstname'	=> $user['firstname'],
						'lastname'	=> $user['lastname'],
						'email'		=> $user['email'],
						'role'		=> $user['role'],
						'nickname'  => $user['nickname'],
					];

					/*header('Location: add_menu.php'); // Redirection vers 
					die;*/
				}
				else { // password_verify
					$errors[] = 'Le couple identifiant/mot de passe est invalide';
				}
			}
			else { // utilisateur inexistant, donc email inexistant en bdd
				$errors[] = 'Le couple identifiant/mot de passe est invalide';
			}
		}
	}
}
?><!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <!-- Titre de la Page -->
    <title>Connexion</title>

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

<?php if(!empty($errors)): ?>
	<p style="color:red;"><?=implode('<br>', $errors);?></p>
<?php endif; ?>

		<header class="row">
            <div class="contact col-xs-12">
                <h1>Connexion</h1>
            </div>
        </header>


		<section class="row">
			<div class="col-xs-12">
				<form method="post" id="contact" class="form-horizontal" role="form" data-toggle="validator">

					<!-- Email -->
					<div class="col-md-4 form-group">
                        <label for="lastname">Email</label>
                    </div>
					<div class="col-md-8 form-group">                      
                        <input id="email"type="email" name="email" placeholder="Email" class="form-control">                  
                    </div>

					<!-- Password -->
                    <div class="col-md-4 form-group">
                        <label for="text">Password</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input id="password" type="password" name="password" placeholder="password" class="form-control">      
                    </div>

					<!-- Submit -->
                    <div class="col-lg-12 form-group">
                        <button type="submit" class="btn btn-primary" name="contact" value="Ajouter Contact">Connexion</button>
                    </div>
				</form>
		</section>

	</main>
</body>
</html>