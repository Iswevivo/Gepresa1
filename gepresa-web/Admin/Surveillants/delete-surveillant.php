<?php 

// echo "La page de connexion";
require_once "../../includes/functions.php";

$id = $_GET['id'];
$db = db_connection();

$req = $db->prepare("DELETE FROM Surveillants WHERE id=?");
$resultat = $req->execute(array($id));

if ($resultat){
    $msg="<div class='alert alert-success'>
        <strong>Felicitation!<strong/><br><br> Vous avez supprimé ce surveillant de la base de données.
    </div>";
}else{
    $msg="<div class='alert alert-danger'>
     <strong>Erreur : !<strong/><br><br> Suppression échouée.
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
            header("refresh:5;url=liste-surveillants.php");
            ?>  
        </div>
    </body>
</html>
