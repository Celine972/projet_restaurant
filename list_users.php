<?php
session_start();
require_once 'inc/connect.php';

// On selectionne les toutes les colonnes de la table users avec un affichage par nom croissant
$select = $bdd->prepare('SELECT * FROM users ORDER BY firstname ASC');
if($select->execute()){
	$users = $select->fetchAll(PDO::FETCH_ASSOC);
}
else {
	// Erreur de développement
	var_dump($select->errorInfo());
	die; 
}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Liste des utilisateurs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles_list_users.css">
 
</head>
<body class="view_user">

<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<hr>
<div class="container">
<?php
if($_SESSION['me']['role']=='Administrateur'){
    include 'nav_admin.php';
}else {
    include 'nav_chef.php';
}
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box no-header clearfix">
                <div class="main-box-body clearfix">
                    <div class="table-responsive">
                        <table class="table user-list">
                            <thead>
                                <tr>

                                <th><span>Id</span></th>
                                
                                <th><span>Utilisateur</span></th>
                                
                                <th class="text-center"><span>Role</span></th>
                                <th><span>Email</span></th>
                                <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($users as $user): ?>
                                <tr>

                                <td>
                                    <!--Affiche l'id l'utilisateur-->
                                       <p><?php echo $user['id_user']?></p>
                                        
                                    </td>

                                    <td>
                                    <!--Affiche nom et prénom de l'utilisateur-->
                                       <p><?php echo $user['firstname'].'  '.$user['lastname'] ?></p>
                                        
                                    </td>
                                   <!--Affichage dô rêle-->
                                    <td class="text-center">
                                        <span class="label label-default"><?php echo $user['role'] ?></span>
                                    </td>
                                    <td>
                                        <p><?php echo $user['email'] ?></p>
                                    </td>

                                    <!--Détails de l'utilisateur-->
                                    <td style="width: 20%;">
                                        <a href="view_user.php" class="table-link">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>

                                        <!--Modification de l'utilisateur-->
                                        <a href="update_user.php?id=<?=$user['id_user'];?>" class="table-link">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>

                                        <!--Suppression de l'utilisateur-->
                                        <a href="delete_user.php?id=<?=$user['id_user'];?>" class="table-link danger">
                                            <span class="fa-stack">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </td>
                               <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript">
	
</script>
</body>
</html>