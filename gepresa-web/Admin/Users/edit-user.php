<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $id = isset($_POST['id']) ? $_POST['id']:"";
    $login = isset($_POST['login']) ? ($_POST['login']):"";
    $role = isset($_POST['role']) ? ($_POST['role']):"";
    
    if(!empty($login) && !empty($role)){

      if(getUserByLogin($login)===false || getUserByLogin($login)['id'] == $id){
            $query = $db->prepare("UPDATE `Users`SET login=?, role=? WHERE id=?");
            $params=array($login, $role, $id);
            $resultat = $query->execute($params);
            
            if ($resultat){
                $msg="<div class='alert alert-success text-center'>
                <strong class='h3'>Felicitation!<strong/><br><br> Modification effectuée.</div>";
            }
        }else{          
            $msg="<div class='alert alert-warning text-center'>
            <strong class='h3'>Alerte : ce username est déjà pris par un autre utilisateur. <strong/></div>";
        }
    }else {
        $msg="<div class='alert alert-warning text-center'>
        <strong class='h3'>Echec de modification : <strong/><br><br> veuillez remplir les champs vides.</div>";
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