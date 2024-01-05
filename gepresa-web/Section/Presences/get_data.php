<?php
    require_once "../../includes/functions.php";
    setlocale(LC_ALL, "fr_FR.UTF-8", "UTC+2");

    // if (!empty($_GET['UID']) && !empty($_GET['salle'])) {
        $db = db_connection();

        $cardUID = $_GET['UID'];
        $salle = 2;
        $date = date('Y-m-d');

        $heure = date('H:i:s', time());
        $vacation = date('A');

        $msg = null;
        $type = "<div class='badge bg-warning'>En attente</div>";

        if(getSurveillantByCard($cardUID) == true){
            $id = getSurveillantByCard($cardUID)['id'];

            $sql = $db->prepare("SELECT Surveiller.id as id, grade, nomComplet, sexe, dateSurveillance, Surveillants.id as idSurv, salleID, nomSalle
            FROM Surveillants INNER JOIN (Surveiller INNER JOIN Salles ON Salles.id = Surveiller.salleID) 
            ON Surveiller.surveillantID = Surveillants.id WHERE dateSurveillance=? AND Surveillants.id = ? AND Surveiller.salleID=? AND Surveiller.vacation=?");

            $sql->execute(array($date, $id, $salle, $vacation));
            $res = $sql->fetch(PDO::FETCH_ASSOC);

            if($res == true && getSurveillantByCard($cardUID)['id'] == $res['idSurv']){
                if (!$res) {
                    $msg = "<div class='bg-warning p-2 text-white'>Aucune information d'affectation pour cette carte !!!</div>";
                    $data['cardUID']=$cardUID;
                    $data['noms']="--------";
                    $data['sexe']="--------";
                    $data['nomSalle']="--------";
                    $data['grade']="--------";
                    $type = "";
                }else{

                    // $check_query = $db->query("SELECT * FROM Surveiller WHERE surveillantID = $surv_id AND salleID=$idSalle AND dateSurveillance = '$date' AND vacation = '$vacation' ");
                    // $res = $check_query->fetch(PDO::FETCH_ASSOC);

                    if($res == true && $res['timeIn'] === '00:00:00' && $res['timeOut'] === '00:00:00'){   
                        $id = $res['id'];   
                        $surv_id = $res['idSurv'];
                        $data['cardUID']=$cardUID;
                        $data['noms']=$res['noms'];
                        $data['sexe']=$res['sexe']=='F' ? 'Féminin' : 'Masculin';
                        $data['nomSalle']=$nomSalle;
                        $data['grade']=$res['grade'];
                        $nomSalle = getAffectationSurveillantByDate($res['dateSurveillance'])['nomSalle'];
            
                        $update = $db->prepare("UPDATE Surveiller SET timeIn =? WHERE surveillantID =? AND salleID=? AND dateSurveillance=? AND vacation=?");
                        $success = $update->execute(array($heure, $surv_id, $salle, $date, $vacation));

                        if($success){
                            $msg = "<div class='bg-success p-2 text-white'>Vous avez signé votre entrée dans la salle.</div>";
                            $type = "<div class='badge bg-info'>Entrée confirmée</div>";
                        }

                    }elseif($res == true && $res['timeIn'] !== '00:00:00' && $res['timeOut'] === '00:00:00'){   

                        $insert = $db->prepare("UPDATE Passer SET time_out = '$heure' WHERE etudiant_ID =? AND evaluation_ID=?");
                        $success = $insert->execute(array( $student_id, $idEval));
                        
                        $update = $db->prepare("UPDATE Surveiller SET timeIn =? WHERE surveillantID =? AND salleID=? AND dateSurveillance=? AND vacation=?");
                        $success = $update->execute(array($heure, $surv_id, $salle, $date, $vacation));

                        if($success){
                            $msg = "<div class='bg-success p-2 text-white'>Vous avez signé votre sortie.</div>";
                            $type = "<div class='badge bg-info'>Sortie enregistrée</div>";
                        }
                    }elseif($res == true && $res['timeIn'] !== '00:00:00' && $res['timeOut'] !== '00:00:00'){   
                        $type = "<div class='badge bg-info'>Tentative de tricherie</div>";
                        $msg = "<div class='bg-danger p-2 text-white'>Vous avez déjà signé la présence (heure d'entrée et heure de sortie déjà enregistrées). Cela ne peut plus être modifié.</div>";
                    }else{   
                        $type = "<div class='badge bg-info'>Tentative de tricherie</div>";
                        $msg = "<div class='bg-danger p-2 text-white'>Cette carte n'est pas reconnue être affectée dans cette salle.</div>";

                    }
                }
            }else{
                $msg = "<div class='bg-warning p-2 text-white'>Carte non autorisée</div>";
                $data['cardUID']=$cardUID;
                $data['noms']="--------";
                $data['sexe']="--------";
                $data['nomSalle']="--------";
                $data['grade']="--------";
                $type = "";
            }
        }else{
            $msg = "<div class='bg-danger p-2 text-white'>Carte non reconnue</div>";
            $data['cardUID']=$cardUID;
            $data['noms']="--------";
            $data['sexe']="--------";
            $data['nomSalle']="--------";
            $data['grade']="--------";
            $type = "";
        }
    //}
    
?>

 
<!DOCTYPE html>
<html lang="en">

<body>	
    <div>
        <!-- <h5 id="blink" class="text-center">Scannez une nouvelle carte</h5>
        <p id="cardUID"></p> -->
        <form>
            <table  border="1" bordercolor="#10a0c5" align="center"  cellpadding="0" cellspacing="1"  bgcolor="#000" style="padding: 2px" class="p-5">
                <tr>
                    <td  height="40" align="center"  bgcolor="#10a0c5"><font  color="#FFFFFF">
                    <b>Informations du surveillant</b></font></td>
                </tr>
                <tr>
                    <td bgcolor="#f9f9f9">
                        <table   border="0" align="center" cellpadding="5"  cellspacing="0">
                            <tr>
                                <td width="" align="left" class="lf">ID Carte</td>
                                <td style="font-weight:bold">:</td>
                                <td align="left"><?php echo $data['cardUID'];?></td>
                            </tr>
                            <tr bgcolor="#f2f2f2">
                                <td align="left" class="lf">Noms</td>
                                <td style="font-weight:bold">:</td>
                                <td align="left"><?php echo $data['noms'];?></td>
                            </tr>
                            <tr bgcolor="#f2f2f2">
                                <td align="left" class="lf">Grade</td>
                                <td style="font-weight:bold">:</td>
                                <td align="left"><?php echo $data['grade'];?></td>
                            </tr>
                            <tr>
                                <td align="left" class="lf">Genre</td>
                                <td style="font-weight:bold">:</td>
                                <td align="left"><?php echo $data['sexe'];?></td>
                            </tr>
                            <tr bgcolor="#f2f2f2">
                                <td align="left" class="lf">Salle</td>
                                <td style="font-weight:bold">:</td>
                                <td align="left"><?php echo $data['nomSalle'];?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <p><?php echo $msg;?></p>
    <form action="presences-etudiants.php">
        <button type="submit" class="btn btn-outline-success float-right">
            <?= $type; ?>
            <span class="bi bi-check2"> OK</span>
        </button>
    </form>
</body>
</html>

<script>		
    var blink = document.getElementById('blink');
    setInterval(function() {
        blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
    }, 1000); 
</script>