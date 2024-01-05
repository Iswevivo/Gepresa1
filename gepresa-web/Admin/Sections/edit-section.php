<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $id = isset($_POST['id']) ? $_POST['id']:"";
    $designation = isset($_POST['designation']) ? $_POST['designation']:"";
    $sigle =isset($_POST['sigle'])? strtoupper($_POST['sigle']) : "";
    
    $query = $db->prepare("UPDATE `Sections` SET designation=?, sigle=? WHERE id=?");
    $params=array($designation, $sigle, $id);
    $resultat = $query->execute($params);
    
    if ($resultat){
        $msg="<div class='alert alert-success text-center'>
        <strong class='h3'>Felicitation!<strong/><br><br> Modification effectuée.</div>";
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
                header("refresh:3; url=liste-sections.php");
            ?>  
        </div>
    </body>
</html>