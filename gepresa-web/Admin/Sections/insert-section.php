<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $designation = isset($_POST['designation'])? $_POST['designation'] :"";
    $sigle =isset($_POST['sigle'])? strtoupper($_POST['sigle']) :"";

    if(!empty($designation) && !empty($sigle)) {
        $sections = $db->query("SELECT * FROM Sections WHERE sigle = '$sigle'");
        $users = $db->query("SELECT * FROM Users WHERE login = '$sigle'");

        if($sections->rowCount() < 1 && $users->rowCount() < 1){
            //Insert query
            $role = "Section";
            
            $query = $db->prepare("INSERT INTO `Users` (login, role) VALUES (?, ?)");
            $params=array(trim($sigle), $role);
            $resultat = $query->execute($params);
                
            if ($resultat){
                $req = $db->query("SELECT max(id) as id FROM Users");
                $res = $req->fetch();
               
                $id = $res['id'];

                $query = $db->prepare("INSERT INTO `Sections` (id, designation, sigle) VALUES (?, ?, ?)");
                $params=array($id, $designation, $sigle);
                $resultat = $query->execute($params);
                
                if($resultat){
                    $msg="<div class='alert alert-success text-center'>
                        <span class='bi bi-shield-fill-check'></span>
                        <strong class='h3'>Felicitation!<strong/><br><br> Nouvelle section ajoutée avec succès. 
                        <span class='bi bi-check2-all'></span>
                        </div>";
                }

            }
        }else {
            if($sections->rowCount() > 0 ){
                $msg="<div class='alert alert-warning text-center'>
                    <span class='bi bi-exclamation-triangle'></span>
                    <strong class='h3'>Attention !!!<strong/><br><br> Il existe déjà une section qui porte le même sigle.
                    <span class='bi bi-shield-exclamation'></span>
                    </div>";
            }elseif($users->rowCount() > 0 ){
                $msg="<div class='alert alert-warning text-center'>
                    <span class='bi bi-exclamation-triangle'></span>
                    <strong class='h3'>Attention !!!<strong/><br><br> Un autre utilisateur utilise déjà ce sigle comme username.
                    <span class='bi bi-shield-exclamation'></span>
                    </div>";
            }
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
                header("refresh:5; url=liste-sections.php");
            ?>  
        </div>
    </body>
</html>