<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $id = isset($_GET['id']) ? $_GET['id']:"";
    
    $req = getUserById($id);

    if($req == true){
        $status = $req['statut'] == 0 ? 1 : 0;

        $query = $db->prepare("UPDATE `Users` SET statut=? WHERE id=?");
        $params=array($status, $id);
        $resultat = $query->execute($params);
        
        if ($resultat){
            if($status==1){
                $msg="<div class='alert alert-success text-center'>
                <strong class='h3'>Felicitation!<strong/><br><br>Compte activé avec succès.</div>";
            }else{
                $msg="<div class='alert alert-success text-center'>
                <strong class='h3'><strong/><br><br>Compte désactivé avec succès.</div>";
            }
        }else {
            $msg="<div class='alert alert-warning text-center'>
            <strong class='h3'>Echec de modification : <strong/><br><br> Une erreur inconnue s'est produite.</div>";
        }
    }
?>
<!DOCTYPE HTML>
<html>
    <?php require_once "../../includes/head2.php"; ?>
    <body>
        <div class="container">
            <br><br>
            <?php
                echo $msg;
                header("refresh:5; url=liste-utilisateurs.php");
            ?>  
        </div>
    </body>
</html>