<?php 

// echo "La page de connexion";
require_once "../../includes/functions.php";

$id = $_GET['id'];
$db = db_connection();

$req = $db->prepare("DELETE FROM Promotions WHERE id=?");
$resultat = $req->execute(array($id));

if ($resultat){
    $msg="<div class='alert alert-success'>
        <strong>Felicitation!<strong/><br><br> Suppression effectée avec succès.
    </div>";
}else{
    $msg="<div class='alert alert-danger'>
     <strong>Erreur : <strong/><br><br> Suppression échouée.
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
            header("refresh:3;url=liste-promotions.php");
            ?>  
        </div>
    </body>
</html>
