<?php

//ETAT : fonctionne

require_once 'inc/connect.php';

//$source = 'message';
/*$_GET['id'] = 2;
$_GET['source'] = 'sent';
echo 'toto';*/

$mess_to_display =[];
/************************* test get si envoie id et source message ************************/
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['source'])){
	
    $id_mess_to_display = (int) $_GET['id'];
      
    $source = $_GET['source'];
  




/**************** TEST MESSAGE PROVENANT DE ELEMENTS ENVOYES **********/    
    if($source == 'sent'){
        //on affiche message de table message dont l'id est id_message
        $selectOne = $bdd->prepare('SELECT * FROM sent WHERE id_message_sent = :id_mess_to_display');
        $selectOne->bindValue(':id_mess_to_display', $id_mess_to_display, PDO::PARAM_INT);

       
        if($selectOne->execute()){
            $mess_to_display = $selectOne->fetch(PDO::FETCH_ASSOC);
            
        }
        else {
		// Erreur de développement
		var_dump($query->errorInfo());
		die; // alias de exit(); => die('Hello world');
        }
    }
}
/**************************************************************************/

/**************** TEST MESSAGE PROVENANT DE BOITE RECEPTION **********/    
    if($source == 'message'){
        //on affiche message de table message dont l'id est id_message
        $selectOne = $bdd->prepare('SELECT * FROM message WHERE id_message = :id_mess_to_display');
        $selectOne->bindValue(':id_mess_to_display', $id_mess_to_display, PDO::PARAM_INT);

                
        if($selectOne->execute()){
          
            $mess_to_display = $selectOne->fetch(PDO::FETCH_ASSOC);
            
        }
        else {
		// Erreur de dévelloppement
		
		die; // alias de exit(); => die('Hello world');
        }
    } 

?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=$mess_to_display['object'];?> </title>
	
<!-- ################	Pour Internet Explorer : S'assurer qu'il utilise
	la dernière version du moteur de rendu 	###################-->    
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    
    <!-- ################	Affichage sans zoom pour les mobiles 	###################-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
	<!-- ################	Font awesome	###################-->
    
    <!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">-->
    
    <link href="assets/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Condensed" rel="stylesheet">
	
    <!-- ################	Bootstrap CSS 	###################-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <!-- ################	Normalize CSS 	Inutile si bootstrp CSS ###################
	<link rel="stylesheet" href="assets/css/normalize.css">-->
	
	<!-- ################	Styles CSS 	###################-->
    <link rel="stylesheet" href="assets/css/styles.css">
    
    <!-- ################	HTML5 Shiv -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js" integrity="sha256-sqQlcOZwgKkBRRn5WvShSsuopOdq9c3U+StqgPiFhHQ=" crossorigin="anonymous"></script>
    


</head>
<body>
	<h1> </h1>
<div class="container">
<div class = 'row'>
    <div class="col-xs-12">
     
     
       <p>date : <?=$mess_to_display['date'];?></p>
       
        <p>De : <?=$mess_to_display['firstname'].' '.$mess_to_display['lastname'];?></p>
        <p><?=$mess_to_display['content'];?></p>  
        
    </div>
</div>	 
            
</div>
</body>       

	
   