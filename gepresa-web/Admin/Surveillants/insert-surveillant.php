<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $nom = isset($_POST['nomComplet'])? ucwords(strtolower($_POST['nomComplet'])) :"";
    $grade = isset($_POST['grade'])? $_POST['grade'] :"";
    $chef = isset($_POST['chef'])? strtoupper($_POST['chef']) :"";
    $sexe = isset($_POST['sexe'])? $_POST['sexe'] :"";
    $cardID = isset($_POST['cardUID'])? $_POST['cardUID'] :"";

    if(!empty($nom) && !empty($cardID)) {

        $req = $db->query("SELECT * FROM Etudiants WHERE cardUID ='$cardID'");
        if ($req->rowCount() > 0) {
            $msg = "<div class='alert bg-danger text-white'><span class='bi bi-x-octagon-fill'>   Ce numéro de carte est déjà attribué à un étudiant.</span></div>";
        }else{
            $req = $db->query("SELECT * FROM Surveillants WHERE cardID = '$cardID'");
                
            if ($req->rowCount() > 0) {
                $msg = "<div class='alert bg-danger text-white'><span class='bi bi-x-circle-fill'>Ce numéro de carte est déjà attribué à un autre surveillant.</span></div>";
            }else{
                if(getSurveillantByName($nom) === false){
                    $query = $db->prepare("INSERT INTO `Surveillants` (nomComplet, sexe, grade, estChefDeSalle, cardID) VALUES (?, ?, ?, ?, ?)");
                    $params=array($nom, $sexe, $grade, $chef, $cardID);
                    $resultat = $query->execute($params);
                    
                    if ($resultat){
                        $msg="<div class='alert alert-success text-center'>
                            <span class='bi bi-shield-fill-check'></span>
                            <strong class='h3'>Felicitation!<strong/><br><br> Nouveau surveillant ajouté avec succès  
                            <span class='bi bi-check2-all'></span>
                            </div>";
                    }
                }else {
                    $msg="<div class='alert alert-warning text-center'>
                        <span class='bi bi-exclamation-triangle'></span>
                        <strong class='h3'>Attention !!!<strong/><br><br>Il existe déjà un surveillant portant ce nom. <br><br>
                        <span class='bi bi-shield-exclamation'></span>
                        </div>";
                }
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
                header("refresh:5; url=liste-surveillants.php");
            ?>  
        </div>
    </body>
</html>