<?php
session_start();
require 'inc/connect.php';

var_dump($_SESSION);
$errors = [];

if(!empty($_POST)){

    foreach($_POST as $key => $value){
        $post[$key] = trim(strip_tags($value));
    }

    if($_POST['password'] =! $_POST['password_confirmed'] ){

        $errors='Les mots de passe ne corrrespondent pas';
    }
   else{     
 $success = 'Félicitations mot de passe modifié';
    }
 }

 if(!count($errors) === 0){

$textErrors = implode('<br>', $errors);

 }else {

$up = $bdd ->prepare('UPDATE users SET password = :password  WHERE id_user = :idUser');

$up->bindValue(':idUser', $_SESSION['me']['id'], PDO::PARAM_INT);
$up->bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
 }




?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <!-- Titre de la Page -->
    <title>Modification du mot de passe</title>

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

    <?php
        // Affichage du message d'erreur
        if(isset($textErrors)){
            echo '<p style="color:red">'.$textErrors.'</p>';
        }
        // Affichage du success
        if(isset($success)){
            echo '<p style="color:green">'.$success.'</p>';
        }

        include 'nav_admin.php';
    ?>

        <header class="row">
            <div class="contact col-xs-12">
                <h1>Modification de mot de passe</h1>
            </div>
        </header>

        <section class="row">
            <!-- Début du Formulaire -->
            <div class="col-xs-12">
                <!-- fin du Formulaire -->

                <form method="post" i class="form-horizontal" role="form" data-toggle="validator">
                                      

                    <!-- Password -->
                    <div class="col-md-4 form-group">
                        <label for="text">Mot de passe</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input id="password" type="password" name="password" placeholder="password" class="form-control">      
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="text">Confirmation du mot de passe</label>
                    </div>
                    <div class="col-md-8 form-group">
                        <input id="password_confirmed" type="password" name="password_confirmed" placeholder="password" class="form-control">      
                    </div>

                   

                    <!-- Submit -->
                    <div class="col-lg-12 form-group">
                        <button type="submit" class="btn btn-primary" name="contact" value="Ajouter Contact">Modifier le mot de passe</button>
                    </div>

                </form>
                <!-- Fin de mon formulaire -->

            </div>


        </section>
    </main>

</body>

</html>