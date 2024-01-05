<?php 

    require_once "../../../includes/functions.php";
    $db = db_connection();

    $type = isset($_POST['type'])? $_POST['type'] :"";
    $session = isset($_POST['session'])? $_POST['session'] :"";
    $promotion = isset($_POST['promotion'])? $_POST['promotion'] :"";
    $date = isset($_POST['date'])? $_POST['date'] :"";
    $cours = isset($_POST['intitule'])? htmlspecialchars($_POST['intitule']) :"";
    $vacation = isset($_POST['vacation'])? ($_POST['vacation']) :"";

    if(!empty($type) && !empty($session) && !empty($promotion) && !empty($date) && !empty($cours)) {
//die($date."===".date('Y-m-d'));
        if($date >= date('Y-m-d')){

            $req = $db->query("SELECT * FROM Evaluations WHERE type_ID=$type AND session='$session' AND promotion_ID=$promotion AND date_evaluation='$date' AND intitule_cours='$cours'");

            if($req->rowCount() < 1) {
                $query = $db->prepare("INSERT INTO `Evaluations` (session, date_evaluation, intitule_cours, vacation, type_ID, promotion_ID) VALUES (?, ?, ?, ?, ?, ?)");
                $params=array($session, $date, $cours, $vacation, $type, $promotion);
                $resultat = $query->execute($params);
                
                if ($resultat){
                    $dateP = date_format(date_create($date), 'd/m/Y');
                    $msg="<div class='alert alert-success text-center'>
                        <span class='bi bi-shield-fill-check'></span>
                        <strong class='h3'>Felicitation!<strong/><br><br> Vous avez programmé une nouvelle évaluation pour la date du  $dateP
                        <span class='bi bi-check2-all'></span>
                        </div>";
                }
            }else {
                $msg="<div class='alert alert-warning text-center'>
                    <span class='bi bi-exclamation-triangle'></span>
                    <strong class='h3'>Attention !!!<strong/><br><br>Cette évaluation avait déjà été programmée dans cette promotion pour cette même date et même heure.<br><br>
                    <span class='bi bi-shield-exclamation'></span>
                    </div>";
            }
        }else{
            $msg="<div class='alert alert-warning text-center'>
                <span class='bi bi-exclamation-triangle'></span>
                <strong class='h3'>Attention !!!<strong/><br><br>Vous ne pouvez pas programmer une évaluation pour une date déjà passée.<br><br>
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