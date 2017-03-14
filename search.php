<?php
// Je teste pour savoir si j'ai quelque chose dans POST
    if(isset($_POST'requete']) && !empty($_POST)) {

// Je commence à séparer les différents mots clés
        $requete = explode(' ', $_POST'requete']);
// J'initialise ma variable pour la requête SQL
        $like = "";
?>




  <!DOCTYPE html>
  <html lang="fr">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recherche</title>
  </head>

  <body>

    <form action="result.php" method="Post">
      <input type="text" name="requete" size="10">
      <input type="submit" value="Rechercher">
    </form>


  </body>

  </html>