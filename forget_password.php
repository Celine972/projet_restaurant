<?php
//On démarre les sessions
session_start();
require 'inc/connect.php';
require 'function_token.php';


//Création du token via la fonction str_random()
$token = str_random(50);

// Recherche dans la base l'email
if(!empty($_POST['email'])){
    $select = $bdd->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
    $select->bindValue(':email', $_POST['email']);
    
    if($select->execute()){
        
        $user = $select->fetch(PDO::FETCH_ASSOC);
        
        if(!empty($user)){
            
            $tok = $bdd->prepare('INSERT INTO users (confirmation_token) VALUES(:token)');
            $tok->bindValue(':token', $token);
            $tok->execute();
            
            //Envoi par mail du  token pour modification mot de passe
            header('Location: modif_password.php');
            
        }else{
            echo 'error';
        }
    }
}







//Maintenant, on affiche notre page normalement, le champ caché token en plus
?>
  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Mon formulaire anti CSRF</title>
  </head>

  <body>
    <form id="form" name="form" method="post">

      <p>E-mail :
        <label>
          <input type="text" name="email" id="email" />
        </label>
      </p>

      <input type="hidden" name="token" id="token" value="<?php
//Le champ caché a pour valeur le jeton
echo $token;
?>" />
      </p>
      <p>
        <label>
          <input type="submit" name="Envoyer" id="Envoyer" value="Envoyer" />
        </label>
      </p>
    </form>
  </body>

  </html>