<?php
    session_start();
    if (!isset($_SESSION['auth'])) {
        header("Location:../../login.php");
      }
  require_once "../../includes/functions.php";

  $presences = ($_SESSION['type']=='Admin' || $_SESSION['type']=='SUPER ADMIN') ? getAllStudentsAttendances() : getStudentsAttendancesByUsertype();

  $Write = "<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
  file_put_contents('../../showID.php', $Write);
?>
<!doctype html>
<html lang="en">
<?php require_once "../../includes/head2.php";  ?>
<script>
  setInterval(function() {
    $("#cardUID").load("../../showID.php");
  }, 100);
</script>
<body>
  <?php require_once "../../includes/header2.php";  ?>
  <?php require_once "../../includes/sidebar2.php";  ?>

  <main>
    <div class="container ">
      <div class="row m-3">

        <main role="main" class="col-md-9 ml-sm-auto col-lg-12 col-lg-offset-5 px-4 m-5">
          <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h3>FICHE DES PRESENCES DES ETUDIANTS</h3>
            <?php if($_SESSION['type'] == 'Admin' || $_SESSION['type'] == 'SUPER ADMIN'){ ?>
              <a class="btn btn-outline-primary  ml-5" data-bs-toggle="modal" data-bs-target="#add_eval"><span class="bi bi-plus-lg"></span> Nouvelle présence</a>
              <?php } ?>
              <a class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#print"><span class="bi bi-printer"></span> Impression des rapports</a>
          </div>
          <!-- liste start -->
          <div>
            <table id="data" class="table table-bordered datatable responsive m-3">
              <thead class="bg-primary">
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Nom de l'étudiant</th>
                  <th scope="col">Intitulé du cours</th>
                  <th scope="col">Promotion</th>
                  <th scope="col">Date</th>
                  <th scope="col">Salle</th>
                  <th scope="col">Heure entrée</th>
                  <th scope="col">Heure sortie</th>
                  <th scope="col">Obs.</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($presences as $presence) : $i++;
                  if (!is_null(getStudentAffectationByDate($presence['date_presence']))) {
                    $nomSalle = getStudentAffectationByDate($presence['date_presence'])['nomSalle'];
                ?>

                    <tr>
                      <th scope="row"> <?= $i ?> </th>
                      <td><?= $presence['noms'] ?> </td>
                      <td><?= $presence['cours'] ?> </td>
                      <td><?= getStudentById($presence['idEtud'])['promotion'] . ' ' . getStudentById($presence['idEtud'])['sigleDep'] ?> </td>
                      <td><?= date_format(date_create($presence['date_presence']), 'd/m/Y')  ?> </td>
                      <td><?= $nomSalle ?> </td>
                      <td><?= $presence['time_in'] ?> </td>
                      <td><?= $presence['time_out'] ?> </td>
                      <td><?php 
                            if($presence['date_presence'] < date("Y-m-d") && ($presence['time_out'] === '00:00:00' && $presence['time_in'] === '00:00:00')){
                              echo "Absent";
                            }elseif($presence['time_out'] === '00:00:00' && $presence['time_in'] === '00:00:00' && $presence['date_presence'] >= date("Y-m-d")){
                                echo "RAS";
                            }elseif($presence['time_out'] === '00:00:00' && $presence['time_in'] !== '00:00:00' && $presence['date_presence'] != date("Y-m-d")){
                                echo "Suspect";
                            }elseif($presence['time_out'] === '00:00:00' && $presence['time_in'] !== '00:00:00' && $presence['date_presence'] == date("Y-m-d")){
                                echo "-";
                            }elseif($presence['time_out'] !== '00:00:00' && $presence['time_in'] === '00:00:00'){
                                echo "Fraude";
                            }else{
                                echo "Présent";
                            }
                        ?> </td>
                    </tr>
                <?php }
                endforeach; ?>
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

    <?php if($_SESSION['type'] == 'Admin' || $_SESSION['type'] == 'SUPER ADMIN'){ ?>

    <!-- Ajouter une presence -->
    <div class="modal fade" id="add_eval" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">SIGNER UNE PRESENCE --Etudiant</h5>
            <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="show_data">
            <form action="" class="row" method="post" id="addform">
              <h5 id="blink" class="text-center">Scannez votre carte pour signer la présence</h5>
              <p id="cardUID"></p>
              <div class="form-group">
                <table class="table mt-3  table-bordered">
                  <tr class="p-3">
                    <td class="bg-primary text-white text-center"> <strong>Informations de l'étudiant</strong></td>
                  </tr>
                  <tr>
                    <td>
                      <table class="table table-striped">
                        <tr>
                          <td width="113" class="lf">ID Carte</td>
                          <td class="fw-bold">:</td>
                          <td align="left">--------</td>
                        </tr>
                        <tr>
                          <td width="113" class="lf">Noms</td>
                          <td class="fw-bold">:</td>
                          <td align="left">--------</td>
                        </tr>
                        <tr>
                          <td width="113" class="lf">Promotion</td>
                          <td class="fw-bold">:</td>
                          <td align="left">--------</td>
                        </tr>
                        <tr>
                          <td width="113" class="lf">Salle</td>
                          <td class="fw-bold">:</td>
                          <td align="left">--------</td>
                        </tr>
                        <tr>
                          <td width="113" class="lf">Photo</td>
                          <td class="fw-bold">:</td>
                          <td class="float-right">
                            <img src="" alt="">
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>


                <div class="modal-footer mt-3">
                  <div  id="msg"></div><hr>
                  <button type="submit" class="btn btn-outline-success">
                    <span class="bi bi-x-lg"> FERMER</span>
                  </button>
                </div>
            </form>

          </div>
        </div>
      </div>
    <?php } ?>
  </main>

  <?php
  include("../../includes/footer.php");
  include("../../includes/js-plugins2.php");
  ?>

<script>
			var myVar = setInterval(myTimer, 1000);
			var myVar1 = setInterval(myTimer1, 1000);
			var oldID="";
			clearInterval(myVar1);

			function myTimer() {
				var getID=document.getElementById("cardUID").innerHTML;
				oldID=getID;
				if(getID!="") {
					myVar1 = setInterval(myTimer1, 100);
					showUser(getID);
					clearInterval(myVar);
				}
			}
			
			function myTimer1() {
				var getID=document.getElementById("cardUID").innerHTML;
				if(oldID!=getID) {
					myVar = setInterval(myTimer, 100);
					clearInterval(myVar1);
				}
			}
			
			function showUser(str) {
				if (str == "") {
					document.getElementById("show_data").innerHTML = "";
					return;
				} else {
					if (window.XMLHttpRequest) {
						// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp = new XMLHttpRequest();
					} else {
						// code for IE6, IE5
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					}
					xmlhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById("show_data").innerHTML = this.responseText;
						}
					};
					xmlhttp.open("GET","show_data.php?UID="+str,true);
					xmlhttp.send();
				}
			}
			
			var blink = document.getElementById('blink');
			setInterval(function() {
				blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
			}, 750); 
		</script>