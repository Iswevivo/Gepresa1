<?php
    require_once "../../../includes/functions.php";

    $db = db_connection();

    $id = isset($_POST['id'])? $_POST['id'] :""; 
    $idSurv = isset($_POST['idSurv'])? $_POST['idSurv'] :""; 
    $idSalle = isset($_POST['idSalle'])? $_POST['idSalle'] :""; 
    $vacation = isset($_POST['vacation'])? $_POST['vacation'] :""; 
    $date = isset($_POST['date'])? $_POST['date'] :""; 

    $update = $db->prepare("UPDATE Surveiller SET dateSurveillance=?, vacation=?, salleID=?, surveillantID=? WHERE id =?");
    $resultat = $update->execute(array($date, $vacation, $idSalle, $idSurv, $id));

    if ($resultat) {
        $msg = "<div class='alert alert-success'>
            <strong>Felicitation!<strong/><br><br> Modification effectuée.
        </div>";
    } else {
        $msg = "<div class='alert alert-danger'>
        <strong>Erreur : !<strong/><br><br> Affectation échouée : une erreur inconnue s'est produite. Veuillez réessayer après une minute
        </div>";
    }   
?>
<!DOCTYPE HTML>
<html>
<?php require_once "../../../includes/head3.php"; ?>

<body>
    <div class="container">
        <br><br>
        <?php
        echo $msg;
        header("refresh:5;url=liste-affect-surv.php");
        ?>
    </div>
</body>

</html>