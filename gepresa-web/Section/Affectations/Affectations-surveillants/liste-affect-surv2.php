<?php
  require_once "../../../includes/functions.php";

  $surveillances = getAllsurveillances();
  $surveillants = getAllSurveillants();
  $salles = getAllSalles();
?>
<!doctype html>
<html lang="en">
<?php require_once "../../../includes/head3.php";  ?>

<body>
  <?php require_once "../../../includes/header3.php";  ?>
  <?php require_once "../../../includes/sidebar4.php";  ?>

  <main>
    <div class="container ">
      <div class="row m-3">

        <main role="main" class="col-md-9 ml-sm-auto col-lg-12 col-lg-offset-5 px-4 m-5">
          <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">AFFECTATIONS DES SURVEILLANTS</h1>
            <a class="btn btn-primary text-white ml-5" data-bs-toggle="modal" data-bs-target="#add_eval">Nouvelle affectation</a>
          </div>
          <!-- liste start -->
          <div>
            <table id="data" class="table table-bordered datatable responsive m-3">
              <thead class="bg-primary">
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Date</th>
                  <th scope="col">Salle</th>
                  <th scope="col">Vacation</th>
                  <th scope="col">Surveillants</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($surveillances as $surveillance) : $i++; ?>
                  <tr>
                    <th scope="row"> <?= $i ?> </th>
                    <td><?= date_format(date_create($surveillance['dateSurveillance']), 'd-M-Y') ?> </td>
                    <td rowspan="2">
                      <?php 
                          $query = $db->query("SELECT DISTINCT * FROM Surveiller INNER JOIN Salles ON Salles.id = Surveiller.salleID WHERE dateSurveillance = '".$surveillance['dateSurveillance']."' GROUP BY salleID");
                          $salles = $query->fetchAll(PDO::FETCH_ASSOC);

                          foreach ($salles as $key => $salle) {
                           
                          }
                        ?>
                    </td>
                    <td>
                      <?php echo $surveillance['vacation'];
                            // foreach ($salles as $key => $salle) {
                            //   $vacations = getVacationBySalle($salle['idS']);

                            //   foreach ($vacations as $key => $vacation) {
                            //     echo "<div>".$key.$vacation['vacation']."</div><hr>";
                            //   }
                            // }
                        ?>
                    </td>
                    <td><?= $surveillance['nomSurv'] ?> </td>
                    <td>
                      <a data-toggle="modal" data-bs-toggle="modal" data-bs-target="#editModal<?= $surveillance[0] ?>" class="btn btn-primary text-white"><span class="bi bi-pencil"> Edit</a>

                      <a href="delete-surveillance.php?id=<?= $surveillance[0] ?>" class="btn btn-danger"> <span class="bi bi-trash"></span>
                        Delete</a>
                    </td>
                  </tr>

                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

    <!-- Ajouter une évaluation -->
    <div class="modal fade" id="add_eval" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">NOUVELLE AFFECTATION DE SURVEILLANT</h5>
            <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="insert-affect-surv.php" class="row g-6" method="post" id="addform">

              <div class="form-group">
                <label for="surv" class="text-primary mt-3">Choisir un surveillant : <span class="text-danger">*</span></label>
                <select name="idSurv" id="surv" class="form-control">
                  <?php foreach ($surveillants as $surveillant) : ?>
                    <option value="<?= $surveillant['id'] ?>"><?= $surveillant['grade'].' '.$surveillant['nomComplet'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <div class="form-group">
                  <label for="dateS" class="text-primary mt-3">Jour de surveillance (en date) : <span class="text-danger">*</span></label>
                  <input type="date" name="date" id="dateS" class="form-control">
                </div>
              </div>
              

              <div class="form-group">
                <label for="vac" class="text-primary mt-3">Vacation : <span class="text-danger">*</span></label>
                <select name="vacation" id="vac" class="form-control">
                  <option value="AM">Avant-midi</option>
                  <option value="PM">Après-midi</option>
                </select>
              </div>

              <div class="form-group">
                <label for="salle" class="text-primary mt-3">Salle d'affectation : <span class="text-danger">*</span></label>
                <select name="idSalle" id="salle" class="form-control">
                  <?php foreach ($salles as $salle) : ?>
                    <option value="<?= $salle['id'] ?>"><?= $salle['nomSalle'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="modal-footer mt-3">
                <button type="submit" class="btn btn-lg btn-success"><span class="bi bi-server"></span> Ajouter</button>
              </div>
            </form>

          </div>
        </div>
      </div>

      <?php
      foreach ($surveillances as $index => $surveillance) { ?>
        <!-- Modal Modifer -->
        <div class="modal fade" id="editModal<?= $surveillance['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">MODIFIER UNE SALLE</h5>
                <button type="button" class="btn bnt-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="edit-surveillance.php" method="post">
                  <input type="hidden" name="id" value="<?= $surveillance['id'] ?>">

                  <div class="form-group">
                    <label for="type" class="text-primary mt-3">Type d'évaluation : <span class="text-danger">*</span></label>
                    <select name="type" id="type" class="form-control">
                      <?php foreach ($typesurveillances as $type) : ?>
                        <option value="<?= $type['id'] ?>" <?php if ($type['id'] == $surveillance['type_ID']) echo "selected" ?>><?= $type['designation'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="session" class="text-primary mt-3">Session : <span class="text-danger">*</span></label>
                    <select name="session" id="session" class="form-control">
                      <option value="Février" <?php if ($surveillance['session'] == "Février") echo "selected" ?>>Février</option>
                      <option value="Juillet" <?php if ($surveillance['session'] == "Juillet") echo "selected" ?>>Juillet</option>
                      <option value="Mi-Session" <?php if ($surveillance['session'] == "Mi-Session") echo "selected" ?>>Mi-Session</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="promot" class="text-primary mt-3">Promotion : <span class="text-danger">*</span></label>
                    <select name="promotion" id="promot" class="form-control">
                      <?php foreach ($promotions as $promotion) : ?>
                        <option value="<?= $promotion['idPromot'] ?>" <?php if ($promotion['id'] == $surveillance['promotion_ID']) echo "Février" ?>><?= $promotion['promotion'] . "   " . $promotion['sigleDep'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <div class="form-group">
                      <label for="date" class="text-primary mt-3">Date prévue : <span class="text-danger">*</span></label>
                      <input type="date" name="date" id="date" class="form-control   value=" <?= $surveillance['date_surveillance'] ?>>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="form-group">
                      <label for="intitule" class="text-primary mt-3">Intitulé du cours : <span class="text-danger">*</span></label>
                      <input type="text" name="intitule" id="intitule" class="form-control" value="<?= $surveillance['intitule_cours'] ?>">
                  </div>

                  <div class="form-group">
                    <label for="vacation" class="text-primary mt-3">Vacation : <span class="text-danger">*</span></label>
                    <select name="vacation" id="vacation" class="form-control">
                      <option value="AM">Avant-midi</option>
                      <option value="PM">Après-midi</option>
                    </select>
                  </div>

            </div>

              <div class=" modal-footer">
                      <button type="submit" class="btn btn-primary"> <span class="bi bi-pencil-square"></span> Modifier</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
  </main>

  <?php
  include("../../../includes/footer.php");
  include("../../../includes/js-plugins3.php");
  ?>