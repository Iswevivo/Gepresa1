<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $libelle = isset($_POST['designation'])? $_POST['designation'] :"";
    $sigle =isset($_POST['sigle'])? strtoupper($_POST['sigle']) :"";
    $section =isset($_POST['section'])? ($_POST['section']) :"";

    if(!empty($libelle) && !empty($sigle)  && !empty($section)) {
        $departs = $db->query("SELECT * FROM Departements WHERE sigle = '$sigle'");

        if($departs->rowCount() < 1){
        //Insert query
            $query = $db->prepare("INSERT INTO `Departements` (libelle, sigle, section_ID) VALUES (?, ?, ?)");
            $params=array($libelle, $sigle, $section);
            $resultat = $query->execute($params);
            
            if ($resultat){
                $msg="<div class='alert alert-success text-center'>
                    <span class='bi bi-check2-all'></span>
                    <strong class='h3'>Felicitation!<strong/><br><br> Nouveau département ajouté avec succès  
                </div>";
            }
        }else {
            $msg="<div class='alert alert-warning text-center'>
                <span class='bi bi-shield-exclamation'></span>
                <strong class='h3'>Attention !!!<strong/><br><br> Il existe déjà un autre département qui porte a le même sigle.
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
                    header("refresh:5; url=liste-departements.php");
                ?>  
            </div>
        </body>
    </html>