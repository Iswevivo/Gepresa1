<?php 
    require_once "../../includes/functions.php";
    $db = db_connection();

    $designation = isset($_POST['designation'])? trim(ucfirst(strtolower(htmlspecialchars($_POST['designation'])))) :"";

    if(!empty($designation)) {
        if(getTypeByName($designation) === false){
            $query = $db->prepare("INSERT INTO `typeEvaluation` (designation) VALUES (?)");
            $params=array($designation);
            $resultat = $query->execute($params);
            
            if ($resultat){
                $msg="<div class='alert alert-success text-center'>
                    <span class='bi bi-shield-fill-check'></span>
                    <strong class='h3'>Felicitation!<strong/><br><br> Nouveau type d'évaluation ajouté avec succès  
                    <span class='bi bi-check2-all'></span>
                    </div>";
            }
        }else {
            $msg="<div class='alert alert-warning text-center'>
                <span class='bi bi-exclamation-triangle'></span>
                <strong class='h3'>Attention !!!<strong/><br><br>Ce type existe déjà<br>
                <span class='bi bi-shield-exclamation'></span>
                </div>";
        }
    }else{
        $msg="<div class='alert alert-danger text-center'>
            <span class='bi bi-x-octagon-fill'></span>
            <strong class='h3'>Attention !!!<strong/><br><br> Veuillez remplir le champ Désignation !
            <span class='bi bi-x-lg'></span>
            </div>";
    }
?>

<!DOCTYPE HTML>
<html>
    <?php require_once "../../includes/head2.php"; ?>
    <body>
        <?php
            echo $msg;
            header("refresh:2; url=liste-evaluations.php");
        ?>
    </body>

</html>