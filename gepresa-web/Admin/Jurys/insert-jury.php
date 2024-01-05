<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $president = isset($_POST['president'])? ucwords(strtolower($_POST['president'])) :"";
    $sec1 = isset($_POST['sec1'])? ucwords(strtolower($_POST['sec1'])) :"";
    $sec2 = isset($_POST['sec2'])? ucwords(strtolower($_POST['sec2'])) :"";
    $membre = isset($_POST['membre'])? ucwords(strtolower($_POST['membre'])) :"";
    $promotion = isset($_POST['promot'])? $_POST['promot'] :"";

    if(!empty($president) && !empty($sec1) && !empty($sec2) && !empty($membre) && !empty($promotion)) {
        if(getJuryByPromotion($promotion) === false){
            $jury = $db->query("SELECT * FROM Jury WHERE president='$president' OR sec1 = '$sec1' OR sec2='$sec2' OR membre='$membre'");

            if($jury->rowCount() < 1){
            //Insert query
            $login = getPromotionById($promotion)['promotion'].' '.getPromotionById($promotion)['sigleDep'];
            $role = "Jury";

            if(getUserByLogin($login) === false){
                $query = $db->prepare("INSERT INTO `Users` (login, role) VALUES (?, ?)");
                $params=array($login, $role);
                $resultat = $query->execute($params);
                    
                    if ($resultat){
                        $req = $db->query("SELECT max(id) as id FROM Users");
                        $res = $req->fetch();
                    
                        $id = $res['id'];

                        $query = $db->prepare("INSERT INTO `Jury` (id, promotion_ID, president, sec1, sec2, membre) VALUES (?, ?, ?, ?, ?, ?)");
                        $params=array($id, $promotion, $president, $sec1, $sec2, $membre);
                        $resultat = $query->execute($params);
                        
                        if($resultat){
                            $msg="<div class='alert alert-success text-center'>
                                <span class='bi bi-shield-fill-check'></span>
                                <strong class='h3'>Felicitation!<strong/><br><br> Vous avez nommé un nouveau jury avec succès. 
                                <span class='bi bi-check2-all'></span>
                                </div>";
                        }

                    }
                }else {
                    $msg="<div class='alert alert-warning text-center'>
                        <span class='bi bi-exclamation-triangle'></span>
                        <strong class='h3'>Attention !!!<strong/><br><br>Une même personne ne peut pas appartenir à deux jurys.<br><br>Vous avez ajouté des noms qui apparaissent déjà dans la composition d'un autre jury.
                        <span class='bi bi-shield-exclamation'></span>
                        </div>";
                }
            }else{
                $msg="<div class='alert alert-warning text-center'>
                <span class='bi bi-exclamation-triangle'></span>
                <strong class='h3'>Attention !!!<strong/><br><br>Cette promotion a déjà un jury en place.<br><br>Impossible d'avoir deux jurys pour une seule promotion.
                <span class='bi bi-shield-exclamation'></span>
                </div>";
            }
        }else{
            $msg="<div class='alert alert-warning text-center'>
                <span class='bi bi-exclamation-triangle'></span>
                <strong class='h3'>Attention !!!<strong/><br><br>Un jury a déjà été nommé pour cette promotion. <br><br>
                <span class='bi bi-shield-exclamation'></span>";
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
                header("refresh:5; url=liste-jurys.php");
            ?>  
        </div>
    </body>
</html>