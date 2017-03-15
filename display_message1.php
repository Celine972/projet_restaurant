<?php
session_start();
require_once 'inc/connect.php';
//$source = 'message';

$mess_to_display =[];
/************************* test get si envoie id et source message ************************/
if(isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id']) && isset($_GET['source'])){
	
    $id_mess_to_display = (int) $_GET['id'];
   
    $source = $_GET['source'];
  
/**************** TEST MESSAGE PROVENANT DE BOITE RECEPTION **********/    
    if($source == 'message'){
        //on affiche message de table message dont l'id est id_message
        $select = $bdd->prepare('SELECT * FROM message WHERE id_message = :id_mess_to_display');
        $select->bindValue(':id_mess_to_display', $id_mess_to_display, PDO::PARAM_INT);
       
        
        if($select->execute()){
         
            $mess_to_display = $select->fetch(PDO::FETCH_ASSOC);
            
         
        }
        else {
		// Erreur de développement
		
		die; // alias de exit(); => die('Hello world');
    }} }
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	
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
	
<div class="container">

<div class = 'row'>
<?php
if($_SESSION['me']['role']=='Administrateur'){
    include 'nav_admin.php';
}else {
    include 'nav_chef.php';
}
?>
<h1>Provenance (reception/envoyé)</h1>
    <div class="col-xs-12">
      <?php foreach($mess_to_display as $key): ?>
        <p><?php echo $key['date'];?></p>
        <p><?php echo $key['firstname'].' '.$key['lastname'];?></p>
        <p><?php echo $key['content'];?></p>  
       <?php endforeach; ?> 
    </div>
</div>	 
            
</div>
</body>       