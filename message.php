<?php session_start();
require_once 'inc/connect.php';
// On selectionne les toutes les colonnes de la table users
$select = $bdd->prepare('SELECT * FROM message ORDER BY id_message DESC');
if($select->execute()){
    $messages = $select->fetchAll(PDO::FETCH_ASSOC);
}
else {
    // Erreur de développement
    var_dump($select->errorInfo());
    die; // alias de exit(); => die('Hello world');
}
?>
  <!DOCTYPE html>
  <html>

  <head>
    <meta charset="utf-8">
    <title>Boite de réception</title>

    <!-- ################	Pour Internet Explorer : S'assurer qu'il utilise
la dernière version du moteur de rendu 	###################-->
    <meta http-equiv="X-UA-Compatible" content="IE-edge">

    <!-- ################	Affichage sans zoom pour les mobiles 	###################-->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ################	Font awesome	###################-->

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="assets/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed" rel="stylesheet">

    <!-- ################	Bootstrap CSS 	###################-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


  

    <!-- ################	HTML5 Shiv -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js" integrity="sha256-sqQlcOZwgKkBRRn5WvShSsuopOdq9c3U+StqgPiFhHQ=" crossorigin="anonymous"></script>



  </head>

  <body>





    <div class="container">

      <?php
if($_SESSION['me']['role']=='Administrateur'){
    include 'nav_admin.php';
}
elseif ($_SESSION['me']['role'] == 'Auteur'){
    include 'nav_chef.php';
}
?>

        <h1>BOITE DE RECEPTION</h1>

        <div class='row'>
          <div class="col-xs-12">

            <a href="message_sent.php">Elements envoyés</a>
          </div>
        </div>
        <table class="table table-striped">
          <thead>
            <tr>
              <th></th>
              <th>Date</th>
              <th>De</th>
              <th>Objet</th>
              <th>Aperçu</th>
              <th>Répondre</th>
              <th>Supprimer</th>
            </tr>
          </thead>

          <tbody>
            <!-- foreach permettant d'avoir une ligne <tr> par ligne SQL -->
            <?php foreach($messages as $message): ?>
              <tr>
                <td></td>
                <!--<td><?=$message['id_message']; ?></td>-->
                <td>
                  <?=$message['date']; ?>
                </td>
                <td>
                  <?=$message['firstname'].' '.$message['lastname']; ?>
                </td>
                <td>
                  <?=$message['object']; ?>
                </td>
                <td><a href="display_message.php?id=<?=$message['id_message']?>&amp;source=message">
                  <?=substr($message['content'], 0, 39); ?></a>
                </td>
                <!-- renvoie les 40 premiers caractères du coprs du message-->
                <td>
                  <!-- view_menu.php?id=6 -->
                  <a href="contact_reply.php?id=<?=$message['id_message']; ?>"><i class="fa fa-mail-reply"></i></a>
                </td>
                <td>
                  <a href="delete_message.php?id=<?=$message['id_message']; ?>"><i class="fa fa-trash-o"></i></a>
                </td>
              </tr>
              <?php endforeach; ?>
          </tbody>
        </table>
    </div>
    <footer>
        <div class="row">
                <div class="col-xs-12">
                <p style="text-align:center">Une Réalisation CJCC - Martinique</p>
                </div>
        </div>
    </footer>
  </body>

  </html>