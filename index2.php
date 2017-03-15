<?php
session_start();

?>

<!DOCTYPE html>
<html>
    <!-- L'Entete de ma page -->
    <head>
        
        <!-- Encodage des Caractères -->
        <meta charset="UTF-8">
        
        <!-- Titre de ma Page -->
        <title>Accueil</title>
        
        <!-- Déclaration des Feuilles de Styles -->
        <link href="assets/css/normalize.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/styles.css">
        
        <!-- Google Font -->
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        
        <!-- FontAwesome -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        
    </head>
    <body>
     <?php 
	
    
    if(isset($_SESSION['is_logged']) && $_SESSION['is_logged']){
    echo 'Bonjour '.$_SESSION['me']['firstname'].' '.$_SESSION['me']['lastname'].'.';   
    }

                

?>
        
        <!-- Le Contenu de ma Page -->
        <div class="page">
           
            <p>After Coding: le petit creux entre 2 balises</p>
            
            <!-- TOPHEADER -->
        <!--<div class="topheader">-->
                <p><i class="fa fa-user-circle-o" aria-hidden="true"></i> Espace Clients : <a href="login.php">Connexion</a> | <a href="add_user.php">Inscription</a></p>
        
        
        <!--</div>        -->
            <!-- HEADER -->
            <header>
<?php if($_SESSION['me']['role']=='Administrateur'){
    include 'nav_admin.php';
}else {
    include 'nav_chef.php';
}?>



<!--
            <div class="logo">
                    <a href="index.html">
                        <img src="assets/img/logo_final.png" alt="Logo After Coding">
                    </a>
            </div>
-->

            </header>
        </div>


        <div class="projecteur">
            <img src="assets/img/424957%20-%20lounge.jpg">
        </div>
        <div class="page">
            <section>
                    
                    <article>
                        <h2>Les Recettes</h2>  
                    </article>
                    <div class="partenaires">
                    <ul>
                       <li><img src="assets/img/slide/carre1.jpg"></li>
                        <li><img src="assets/img/slide/carre2.jpg"></li>
                        <li><img src="assets/img/slide/carre3.jpg"></li>
                        <li><img src="assets/img/slide/carre4.jpg"></li>
                        </ul>
                        </div>
            </section>
<!--
    <footer>
               <div class="page">
                <div class="gmap">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22992739.50431434!2d-11.654303520205906!3d45.29365935438472!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd368d04c5a4898b%3A0xaf68f2954ec842c6!2sKaisen+Sushi+Bar!5e0!3m2!1sfr!2sfr!4v1483734640015" width="100%" height="210" frameborder="0" style="border:0" allowfullscreen></iframe>
                </div>
                <div class="newsletter">
                    <form action="newsletter.php" method="POST"
                        name="newsletter">
                        <fieldset>
                            <legend>Newsletter</legend>
                            <input type="text" name="nom" placeholder="Nom">
                            <input type="text" name="prenom" placeholder="Prénom">
                            <input type="email" name="email" placeholder="Email" required>
                            <input type="submit" value="M'inscrire !">
                        </fieldset>    
                    </form>
                </div>
                <div class="contact">
                    <fieldset>
                      <legend>Contact</legend>
                    <address>
                        <strong>ISEN</strong> <br>
                        <a href="tel:+596696778919"><i class="fa fa-phone" aria-hidden="true"></i> 0696 77 89 19</a> <br>
                        <a href="mailto:wf3@hl-media.fr"><i class="fa fa-envelope" aria-hidden="true"></i> wf3@hl-media.fr</a> <br>
                        41 Boulevard VAUBAN <br>
                        59000 Lille <br>
                        FRANCE
                    </address>
                    </fieldset>
                </div>
                </div>
    </footer>    
-->
        </div>

    </body>
</html>



