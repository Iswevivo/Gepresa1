<?php
    require_once "../../../includes/functions.php";

    $db = db_connection();

    $nbre = isset($_POST['nbre'])? $_POST['nbre'] :""; 
    $idSalle = isset($_POST['salle'])? $_POST['salle'] :""; 
    $idPromot = isset($_POST['promotion'])? $_POST['promotion'] :""; 
    $date = isset($_POST['date'])? $_POST['date'] :""; 
    
    $select_all = $db->query("SELECT * FROM EtreAffecte WHERE date_affectation='$date' AND promotion_ID=$idPromot");
    $res = $select_all->fetchall();

    die(var_dump($res));


    if($select_all->rowCount() >= 2){
        $msg = "<div class='alert alert-danger'>
        <strong>Erreur !<strong/><br><br> Un surveillant ne peut pas être affecté plus de deux fois par jour.
        </div>";
    }else{
        $select_surv = $db->query("SELECT * FROM Surveiller WHERE dateSurveillance='$date' AND salleID=$idSalle AND surveillantID=$idSurv AND vacation='$vacation'");

        if($select_surv->rowCount() != 0){
            $msg = "<div class='alert alert-danger'>
            <strong>Erreur !<strong/><br><br> Cette même affectation est déjà effectuée. Vérifiez dans le tableau des affectations précédents vous le trouverez.
            </div>";
        }else{
            $select_surv = $db->query("SELECT * FROM Surveiller WHERE dateSurveillance='$date' AND salleID <> $idSalle AND surveillantID=$idSurv AND vacation='$vacation'");
       
            if($select_surv->rowCount() != 0){
                $msg =  "<div class='alert alert-danger'>
                <strong>Erreur : !<strong/><br><br> Un surveillant ne peut pas être affecté dans deux salles différentes dans une même journée pendant une même vacation.
                </div>";
            }else{
                $insert_query = $db->prepare("INSERT INTO Surveiller (dateSurveillance, vacation, salleID, surveillantID) VALUES(?, ?, ?, ?)");
                $resultat = $insert_query->execute(array($date, $vacation, $idSalle, $idSurv));

                if ($resultat) {
                    $msg = "<div class='alert alert-success'>
                        <strong>Felicitation!<strong/><br><br> L'affectation a réussi.
                    </div>";
                } else {
                    $msg = "<div class='alert alert-danger'>
                    <strong>Erreur : !<strong/><br><br> Affectation échouée : une erreur inconnue s'est produite. Veuillez réessayer après une minute
                    </div>";
                }   
            }
        
        }
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