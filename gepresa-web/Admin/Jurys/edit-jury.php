<?php 
    require_once "../../includes/functions.php";
    $db = db_connection();

    $president = isset($_POST['president'])? ucwords(strtolower($_POST['president'])) :"";
    $sec1 = isset($_POST['sec1'])? ucwords(strtolower($_POST['sec1'])) :"";
    $sec2 = isset($_POST['sec2'])? ucwords(strtolower($_POST['sec2'])) :"";
    $membre = isset($_POST['membre'])? ucwords(strtolower($_POST['membre'])) :"";
    $promotion = isset($_POST['promot'])? $_POST['promot'] :"";
    $id = isset($_POST['id'])? $_POST['id'] :"";

    if(!empty($president) && !empty($sec1) && !empty($sec2) && !empty($membre)) {

        if(getJuryByPromotion($id)===false || getJuryByPromotion($id)['idJ'] == $promotion){

            $login = getPromotionById($id)['promotion']." ".getPromotionById($id)['sigleDep'];

            if(getUserByLogin($login)===false || getUserByLogin($login)['id'] == $id){
                $query = $db->prepare("UPDATE `Jury` SET president=?, sec1=?, sec2=?, membre=?, promotion_ID=? WHERE id=?");
                $params=array($president, $sec1, $sec2, $membre, $promotion, $id);
                $resultat = $query->execute($params);
        
                $query1 = $db->prepare("UPDATE `Users` SET login=? WHERE id=?");
                $params1=array($login, $id);
                $resultat1 = $query->execute($params);

                if ($resultat && $resultat1){
                    $msg="<div class='alert alert-success text-center'>
                        <span class='bi bi-shield-fill-check'></span>
                        <strong class='h3'>Felicitation!<strong/><br><br> Jury modifié avec succès. 
                        <span class='bi bi-check2-all'></span>
                        </div>";
                }else{
                    $msg="<div class='alert alert-success text-center'>
                        <span class='bi bi-shield-fill-check'></span>
                        <strong class='h3'>Attention !<strong/><br><br>Modification impossible : Erreur inconnue survenue. 
                        <span class='bi bi-check2-all'></span>
                        </div>";
                }
            }else{
                $msg="<div class='alert alert-danger text-center'>
                    <span class='bi bi-shield-fill-check'></span>
                    <strong class='h3'>Alerte !<strong/><br><br>Il existe déjà un jury pour la promotion que vous venez de choisir. 
                    <span class='bi bi-check2-all'></span>
                    </div>";
            }
        }else{
            $msg="<div class='alert alert-danger text-center'>
                <span class='bi bi-shield-fill-check'></span>
                <strong class='h3'>Alerte !<strong/><br><br>Modification impossible : la promotion que vous avez choisi a déjà un jury existant. 
                <span class='bi bi-check2-all'></span>
                </div>";
        }
    }else{
        $msg="<div class='alert alert-danger text-center'>
            <span class='bi bi-x-octagon-fill'></span>
            <strong class='h3'>Attention !!!<strong/><br><br> Veuillez remplir tous les champs !
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
                header("refresh:3; url=liste-jurys.php");
            ?>  
        </div>
    </body>
</html>