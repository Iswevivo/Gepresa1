<?php 

    // echo "La page de connexion";
    require_once "../../includes/functions.php";

    $id = $_GET['id'];
    $db = db_connection();

    $req = $db->query("SELECT * FROM Evaluations WHERE id=$id");
    $eval = $req->fetch();

    if($eval['date_evaluation'] >= date('Y-m-d')){
        $req = $db->prepare("DELETE FROM Evaluations WHERE id=?");
        $resultat = $req->execute(array($id));                                                                                                                                                                                                                                                                                                                                      

        if ($resultat){
            $msg="<div class='alert alert-success'>
                <strong>Felicitation!<strong/><br><br> Vous avez retiré cette évaluation de l'horaire.
            </div>";
        }else{
            $msg="<div class='alert alert-danger'>
            <strong>Erreur : !<strong/><br><br> Suppression échouée.
            </div>";
        }
    }else{
        $msg="<div class='alert alert-danger'>
        <strong>Attention : !<strong/><br><br> Vous ne pouvez pas supprimé une évaluation dont la date est déjà passée.
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
            header("refresh:5;url=liste-evaluations.php");
            ?>  
        </div>
    </body>
</html>
