<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $login = isset($_POST['login'])? ($_POST['login']) :"";
    $role = isset($_POST['role'])? ($_POST['role']) :"";

    if(!empty($login) && !empty($role)) {
        if(getUserByLogin($login) === false){

            //Insert query
            $query = $db->prepare("INSERT INTO `Users` (login, role) VALUES (?, ?)");
            $params=array($login, $role);
            $resultat = $query->execute($params);
            
            if ($resultat){
                $msg="<div class='alert alert-success text-center'>
                    <span class='bi bi-shield-fill-check'></span>
                    <strong class='h3'>Felicitation!<strong/><br><br> Nouvel utilisateur ajouté avec succès  
                    <span class='bi bi-check2-all'></span>
                    </div>";
            }
        }else{
            $msg="<div class='alert alert-warning text-center'>
                <span class='bi bi-exclamation-triangle'></span>
                <strong class='h3'>Attention !!!<strong/><br><br>Ce login (username) existe déjà.<br><br>Vérifier le matricule et autres champs s'ils n'existent pas déjà.
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
                header("refresh:3; url=liste-utilisateurs.php");
            ?>  
        </div>
    </body>
</html>