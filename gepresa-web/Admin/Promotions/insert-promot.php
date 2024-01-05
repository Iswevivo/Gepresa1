<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $libelle = isset($_POST['designation'])? $_POST['designation'] :"";
    $depart =isset($_POST['depart'])? $_POST['depart'] :"";

    if(!empty($libelle) && !empty($depart)) {
        $promotions = $db->query("SELECT * FROM Promotions WHERE designation = '$libelle' AND departement_ID= $depart");

        if($promotions->rowCount() < 1){
        //Insert query
            $query = $db->prepare("INSERT INTO `Promotions` (designation, departement_ID) VALUES (?, ?)");
            $params=array($libelle, $depart);
            $resultat = $query->execute($params);
            
            if ($resultat){
                $msg="<div class='alert alert-success text-center'>
                    <span class='bi bi-check2-all'></span>
                    <strong class='h3'>Felicitation!<strong/><br><br> Nouvelle promotion ajoutée avec succès  
                </div>";
            }
        }else {
            $msg="<div class='alert alert-warning text-center'>
                <span class='bi bi-shield-exclamation'></span>
                <strong class='h3'>Attention !!!<strong/><br><br> Cette promotion existe déjà pour ce même département.
            </div>";
        }  
    }else{
        $msg="<div class='alert alert-danger text-center'>
            <span class='bi bi-x-lg'></span>
            <strong class='h3'>Attention !!!<strong/><br><br> Veuillez remplir tous les champs s'il vous plaît !
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
                    header("refresh:5; url=liste-promotions.php");
                ?>  
            </div>
        </body>
    </html>