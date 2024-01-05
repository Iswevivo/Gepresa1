<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $nom = isset($_POST['nom'])? strtoupper($_POST['nom']) :"";
    $capacite = isset($_POST['capacite'])? $_POST['capacite'] :"";

    if(!empty($nom) && !empty($capacite)) {
        if(getSalleByName($nom) === false){
            $query = $db->prepare("INSERT INTO `Salles` (nomSalle, capacite) VALUES (?, ?)");
            $params=array($nom, $capacite);
            $resultat = $query->execute($params);
            
            if ($resultat){
                $msg="<div class='alert alert-success text-center'>
                    <span class='bi bi-shield-fill-check'></span>
                    <strong class='h3'>Felicitation!<strong/><br><br> Une nouvelle salle d'examen a été ajoutée avec succès  
                    <span class='bi bi-check2-all'></span>
                    </div>";
            }
        }else {
            $msg="<div class='alert alert-warning text-center'>
                <span class='bi bi-exclamation-triangle'></span>
                <strong class='h3'>Attention !!!<strong/><br><br>Il existe déjà une autre salle portant ce nom. <br><br>
                <span class='bi bi-shield-exclamation'></span>
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
                header("refresh:5; url=liste-salles.php");
            ?>  
        </div>
    </body>
</html>