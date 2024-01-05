<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $id = isset($_POST['id'])? $_POST['id'] :"";
    $nom = isset($_POST['nomComplet'])? ucwords(strtolower($_POST['nomComplet'])) :"";
    $grade = isset($_POST['grade'])? $_POST['grade'] :"";
    $chef = isset($_POST['chef'])? $_POST['chef'] :"";
    $sexe = isset($_POST['sexe'])? $_POST['sexe'] :"";
    $cardID = isset($_POST['cardUID2'])? $_POST['cardUID2'] :"";

    if(!empty($nom)) {
        if(!empty($cardID)) {

            $req = $db->query("SELECT * FROM Etudiants WHERE cardUID ='$cardID'");
            if ($req->rowCount() > 0) {
                $msg = "<div class='alert bg-danger text-white'><span class='bi bi-x-octagon-fill'>   Ce numéro de carte est déjà attribué à un étudiant.</span></div>";
            }else{
                $req = $db->query("SELECT * FROM Surveillants WHERE cardID = '$cardID' AND id <> $id");
                    
                if ($req->rowCount() > 0) {
                    $msg = "<div class='alert bg-danger text-white'><span class='bi bi-x-circle-fill'>  Ce numéro de carte est déjà attribué à un autre surveillant.</span></div>";
                }else{
                    $query = $db->prepare("UPDATE `Surveillants` SET nomComplet=?, sexe=?, grade=?, estChefDeSalle=?, cardID=? WHERE id=?");
                    $params=array($nom, $sexe, $grade, $chef, $cardID, $id);
                    $resultat = $query->execute($params);

                    if ($resultat){
                        $msg="<div class='alert alert-success text-center'>
                            <span class='bi bi-shield-fill-check'></span>
                            <strong class='h3'>Felicitation!<strong/><br><br> Nouveau surveillant ajouté avec succès  
                            <span class='bi bi-check2-all'></span>
                            </div>";
                    }
                }
            }
        }else{
            $query = $db->prepare("UPDATE `Surveillants` SET nomComplet=?, sexe=?, grade=?, estChefDeSalle=? WHERE id=?");
            $params=array($nom, $sexe, $grade, $chef, $id);
            $resultat = $query->execute($params);

            if ($resultat){
                $msg="<div class='alert alert-success text-center'>
                    <span class='bi bi-shield-fill-check'></span>
                    <strong class='h3'>Felicitation!<strong/><br><br> Les informations sur ce surveillant ont été modifiées avec succès !
                    <span class='bi bi-check2-all'></span>
                    </div>";
            }
        }
    }else{
        $msg="<div class='alert alert-danger text-center'>
            <span class='bi bi-x-octagon-fill'></span>
            <strong class='h3'>Attention !!!<strong/><br><br> Veuillez renseigner le champ pour le nom du surveillant !
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
                header("refresh:3; url=liste-surveillants.php");
            ?>  
        </div>
    </body>
</html>