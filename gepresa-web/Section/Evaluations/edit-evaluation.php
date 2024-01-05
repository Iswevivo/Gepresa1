<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();
// die(var_dump($_POST));
    $id = isset($_POST['id'])? $_POST['id'] :"";
    $type = isset($_POST['type'])? $_POST['type'] :"";
    $session = isset($_POST['session'])? $_POST['session'] :"";
    $promotion = isset($_POST['promotion'])? $_POST['promotion'] :"";
    $date = isset($_POST['date'])? $_POST['date'] :"";
    $cours = isset($_POST['intitule'])? htmlspecialchars($_POST['intitule']) :"";
    $vacation = isset($_POST['vacation'])? ($_POST['vacation']) :"";

    if(!empty($type) && !empty($session) && !empty($promotion) && !empty($date) && !empty($cours)) {

        if($date >= date('Y-m-d')){
            $query = $db->prepare("UPDATE `Evaluations` SET date_evaluation=?,  session=?, intitule_cours=?, vacation=?, type_ID=?, promotion_ID=? WHERE id=? ");
            $params = array($date, $session, $cours, $vacation, $type, $promotion, $id);
            $resultat = $query->execute($params);
            // var_dump($resultat);die();
            if ($resultat){
                $msg="<div class='alert alert-success text-center'>
                    <span class='bi bi-shield-fill-check'></span>
                    <strong class='h3'>Felicitation!<strong/><br><br> Les informations sur cette évaluation ont été mises à jour.
                    <span class='bi bi-check2-all'></span>
                </div>";
            }
        }else{
            $msg="<div class='alert alert-warning text-center'>
                <span class='bi bi-exclamation-triangle'></span>
                <strong class='h3'>Attention !!!<strong/><br><br>Vous ne pouvez pas modifier une évaluation dont la date est déjà passée.<br><br>
                <span class='bi bi-shield-exclamation'></span>
            </div>";
        }
    }else{
        $msg="<div class='alert alert-danger text-center'>
            <span class='bi bi-x-octagon-fill'></span>
            <strong class='h3'>Attention !!!<strong/><br><br> Veuillez remplir tous les champs s'il vous plaît ! <br>
            Vérifier que vous avez renseigné le nom du cours et la date de passation de cette évaluation.
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
                header("refresh:3; url=liste-evaluations.php");
            ?>  
        </div>
    </body>
</html>