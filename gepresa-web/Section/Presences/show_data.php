<?php
    require_once "../../includes/functions.php";
    
    if (!empty($_GET['UID'])) {
        $db = db_connection();

        $cardUID = $_GET['UID'];
        $date = date('Y-m-d');
        $heure = date('H:i:s');

        $msg = null;
        $type = "<div class='badge bg-warning'>En attente</div>";

        if(getStudentByCard($cardUID) == true){
            $id = getStudentByCard($cardUID)['id'];

            $sql = $db->prepare("SELECT photo, Etudiants.id as idEtud, cardUID, CONCAT(nom, ' ', postnom, ' ', prenom) as noms, dateAffectation
            FROM Etudiants INNER JOIN (EtreAffecte INNER JOIN Salles ON Salles.id = EtreAffecte.salle_ID) 
            ON EtreAffecte.student_ID = Etudiants.id WHERE dateAffectation=? AND Etudiants.id = ? ");

            $sql->execute(array($date, $id));
            $res = $sql->fetch(PDO::FETCH_ASSOC);

            if($res == true && getStudentByCard($cardUID)['id'] == $res['idEtud']){
                if (!$res) {
                    $msg = "<div class='bg-warning p-2 text-white'>Aucune information d'affectation pour cette carte !!!</div>";
                    $data['cardUID']=$cardUID;
                    $data['noms']="--------";
                    $data['promotion']="--------";
                    $data['nomSalle']="--------";
                    $data['photo']="--------";
                    $data['cours']="--------";
                    $type = "";
                }else{

                    $promotion = getStudentById($res['idEtud'])['promotion'].' '.getStudentById($res['idEtud'])['sigleDep'];
                    $nomSalle = getStudentAffectationByDate($res['dateAffectation'])['nomSalle'];

                    $student_id = $res['idEtud'];
                    $data['cardUID']=$cardUID;
                    $data['noms']=$res['noms'];
                    $data['promotion']=$promotion;
                    $data['nomSalle']=$nomSalle;
                    $data['photo']=$res['photo'];

                    $idPromotion = getStudentById($res['idEtud'])['idPromot'];

                    $select_evaluation = $db->query("SELECT * FROM Evaluations WHERE date_evaluation= '$date' AND promotion_ID=$idPromotion ");
                    $evaluation = $select_evaluation->fetch(PDO::FETCH_ASSOC);

                    // die(var_dump($evaluation));

                    $idEval = $evaluation['id'];

                    $data['cours'] = $evaluation['intitule_cours'];

                    $check_query = $db->query("SELECT * FROM Passer WHERE etudiant_ID = $student_id AND evaluation_ID=$idEval");
                    $res_check = $check_query->fetch(PDO::FETCH_ASSOC);

                    if($res_check == false){                    
                        $insert = $db->prepare('INSERT INTO Passer(date_presence, time_in, etudiant_ID, evaluation_ID) VALUES(?, ?, ?, ?)');
                        $success = $insert->execute(array($date, $heure, $student_id, $idEval));

                        if($success){
                            $type = "<div class='badge bg-info'>Entrée confirmée</div>";
                            $msg = "<div class='bg-success p-2 text-white'>Carte bien reconnue et présence pointée.</div>";
                        }

                    }elseif($res_check == true && $res_check['time_out'] === '00:00:00'){ 

                        $insert = $db->prepare("UPDATE Passer SET time_out = '$heure' WHERE etudiant_ID =? AND evaluation_ID=?");
                        $success = $insert->execute(array( $student_id, $idEval));

                        if($success){
                            $type = "<div class='badge bg-info'>Entrée confirmée</div>";
                            $msg = "<div class='bg-success p-2 text-white'>Carte bien reconnue et présence pointée.</div>";
                        }
                        $type = "<div class='badge bg-info'>Sortie enregistrée</div>";
                    }else{
                        $type = "<div class='badge bg-info'>Tentative de tricherie</div>";
                        $msg = "<div class='bg-danger p-2 text-white'>Vous avez déjà signé la présence (heure d'entrée et heure de sortie déjà enregistrées). Cela ne peut plus être modifié.</div>";
                    }
                }
            }else{
                $msg = "<div class='bg-warning p-2 text-white'>Carte non autorisée</div>";
                $data['cardUID']=$cardUID;
                $data['noms']="--------";
                $data['promotion']="--------";
                $data['nomSalle']="--------";
                $data['photo']="--------";
                $data['cours']="--------";
                $type = "";
            }
        }else{
            $msg = "<div class='bg-danger p-2 text-white'>Carte non reconnue</div>";
            $data['cardUID']=$cardUID;
            $data['noms']="--------";
            $data['promotion']="--------";
            $data['nomSalle']="--------";
            $data['photo']="--------";
            $data['cours']="--------";
            $type = "";
        }
    }
 
?>
 
<!DOCTYPE html>
<html lang="en">
<?php require_once "../../includes/head2.php";  ?>
 
	<body>	
		<div>
            <!-- <h5 id="blink" class="text-center">Scannez une nouvelle carte</h5>
            <p id="cardUID"></p> -->
			<form>
				<table  border="1" bordercolor="#10a0c5" align="center"  cellpadding="0" cellspacing="1"  bgcolor="#000" style="padding: 2px">
					<tr>
						<td  height="40" align="center"  bgcolor="#10a0c5"><font  color="#FFFFFF">
						<b>Informations de l'étudiant</b></font></td>
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
								<tr>
									<td align="left" class="lf">Promotion</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['promotion'];?></td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Salle</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['nomSalle'];?></td>
								</tr>
								<tr bgcolor="#f2f2f2">
									<td align="left" class="lf">Cours</td>
									<td style="font-weight:bold">:</td>
									<td align="left"><?php echo $data['cours'];?></td>
								</tr>
							</table>
						</td>
                        <td align="left">
                            <img src="../../assets/img/students/<?php echo $data['photo'];?>" alt="Non disponible" width='150' height='200'>
                        </td>
					</tr>
				</table>
			</form>
		</div>
		<p><?php echo $msg;?></p>
        <form action="presences-surveillants.php">
            <button type="submit" class="btn btn-outline-success float-right">
                <?= $type; ?>
                <span class="bi bi-check-lg"> OK</span>
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