<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $id = isset($_POST['id'])? $_POST['id'] :"";
    $nom = isset($_POST['nom'])? strtoupper($_POST['nom']) :"";
    $capacite = isset($_POST['capacite'])? $_POST['capacite'] :"";

    if(!empty($nom) && !empty($capacite)) {
        $query = $db->prepare("UPDATE `Salles` SET nomSalle=?, capacite=? WHERE id=?");
        $params=array($nom, $capacite, $id);
        $resultat = $query->execute($params);
        
        if ($resultat){
            $msg="<div class='alert alert-success text-center'>
                <span class='bi bi-shield-fill-check'></span>
                <strong class='h3'>Felicitation!<strong/><br><br>Salle modifiée avec succès  
                <span class='bi bi-check2-all'></span>
                </div>";
        }
    }else{
        $msg="<div class='alert alert-danger text-center'>
            <span class='bi bi-x-octagon-fill'></span>
            <strong class='h3'>Attention !!!<strong/><br><br> Veuillez remplir tous les champs s'il vous plaît !
            <span class='bi bi-x-lg'></span>
            </div>";
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
                header("refresh:2; url=liste-salles.php");
            ?>  
        </div>
    </body>
</html>