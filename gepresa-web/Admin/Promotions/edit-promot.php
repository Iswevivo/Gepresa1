<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $id =  $sigle =isset($_POST['id'])?$_POST['id'] : "";
    $designation = isset($_POST['designation']) ? strtoupper($_POST['designation']):"";
    $depart =isset($_POST['depart'])?$_POST['depart'] : "";
    
    if(!empty($designation)){
    //Insert query
        $query = $db->prepare("UPDATE `Promotions` SET designation=?, departement_ID=? WHERE id=?");
        $params=array($designation, $depart, $id);
        $resultat = $query->execute($params);
        
        if ($resultat){
            $msg="<div class='alert alert-success text-center'>
            <strong class='h3'>Felicitation!<strong/><br><br> Modification effectuée.</div>";
        }
    }else {
        $msg="<div class='alert alert-warning text-center'>
        <strong class='h3'>Echec de modification : <strong/><br><br> Veuillew remplir les champs vides.</div>";
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
                header("refresh:3; url=liste-departements.php");
            ?>  
        </div>
    </body>
</html>