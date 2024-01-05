<?php
session_start();
if (!isset($_SESSION['auth'])) {
  header("Location:../../login.php");
}
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
  <?php require_once "../../../includes/sidebar3.php";  ?>

  <main>
    <div class="container ">
      <div class="row m-3">

        <main role="main" class="col-md-9 ml-sm-auto col-lg-12 col-lg-offset-5 px-4 m-5">
          <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">AFFECTATIONS DES SURVEILLANTS</h1>
            <?php if ($_SESSION['type'] == 'Admin' || $_SESSION['type'] == 'SUPER ADMIN') { ?>
              <a class="btn btn-primary text-white ml-5" data-bs-toggle="modal" data-bs-target="#add_eval">Nouvelle affectation</a>
            <?php } ?>
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
                  <?php if ($_SESSION['type'] != 'Jury') { ?>
                    <th scope="col">Actions</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($surveillances as $surveillance) : $i++; ?>
                  <tr>
                    <td scope="row"> <?= $i ?> </td>
                    <td><?= date_format(date_create($surveillance['dateSurveillance']), 'd-M-Y') ?> </td>
                    <td rowspan="2">
                      <?php
                      // $db = db_connection();

                      // $query = $db->query("SELECT DISTINCT * FROM Surveiller INNER JOIN Salles ON Salles.id = Surveiller.salleID WHERE dateSurveillance = '".$surveillance['dateSurveillance']."' GROUP BY salleID");

                      // while ($salle = $query->fetch()) {
                      echo $surveillance['nomSalle'];
                      //}
                      ?>
                    </td>
                    <td><?php echo $surveillance['vacation']; ?></td>
                    <td><?= $surveillance['nomSurv'] ?> </td>
                    <?php if ($_SESSION['type'] != 'Jury') { ?>
                      <td>
                        <a data-toggle="modal" data-bs-toggle="modal" data-bs-target="#editModal<?= $surveillance['id'] ?>" class="btn btn-primary text-white"><span class="bi bi-pencil"> Edit</a>

                        <a href="delete-surveillance.php?id=<?= $surveillance['id'] ?>" class="btn btn-danger"> <span class="bi bi-trash"></span>
                          Delete</a>
                      </td>
                    <?php } ?>
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
                    <option value="<?= $surveillant['id'] ?>"><?= $surveillant['grade'] . ' ' . $surveillant['nomComplet'] ?></option>
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
    </div>

      <?php
      foreach ($surveillances as $index => $surveillance) { ?>
        <!-- Modal Modifer -->
        <div class="modal fade" id="editModal<?= $surveillance['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">MODIFIER L'AFFECTATION DU SURVEILLANT</h5>
                <button type="button" class="btn bnt-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                 <form action="edit-affect-surv.php" class="row g-6" method="post" id="addform">
                  <input type="hidden" name="id" value="<?= $surveillance['id'] ?>">
              <div class="form-group">
                <label for="surv" class="text-primary mt-3">Nom du surveillant : <span class="text-danger">*</span></label>
                <select name="idSurv" id="surv" class="form-control">
                  <?php foreach ($surveillants as $surveillant) : ?>
                    <option value="<?= $surveillant['id'] ?>" <?php if($surveillance['idSurv']==$surveillant['id']) echo 'selected' ?>><?= $surveillant['grade'] . ' ' . $surveillant['nomComplet'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <div class="form-group">
                  <label for="dateS" class="text-primary mt-3">Jour de surveillance (en date) : <span class="text-danger">*</span></label>
                  <input type="date" name="date" id="dateS" class="form-control" value="<?= $surveillance['dateSurveillance'] ?>">
                </div>
              </div>


              <div class="form-group">
                <label for="vac" class="text-primary mt-3">Vacation : <span class="text-danger">*</span></label>
                <select name="vacation" id="vac" class="form-control">
                  <option value="AM" <?php if($surveillance['vacation']=='AM') echo 'selected'; ?>>Avant-midi</option>
                  <option value="PM" <?php if($surveillance['vacation']=='PM') echo 'selected'; ?>>Après-midi</option>
                </select>
              </div>

              <div class="form-group">
                <label for="salle" class="text-primary mt-3">Salle d'affectation : <span class="text-danger">*</span></label>
                <select name="idSalle" id="salle" class="form-control">
                  <?php foreach ($salles as $salle) : ?>
                    <option value="<?= $salle['id'] ?>" <?php if($surveillance['idSalle']==$salle['id']) echo 'selected'; ?>><?= $salle['nomSalle'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="modal-footer mt-3">
                <button type="submit" class="btn btn-lg btn-info"><span class="bi bi-server"></span> Modifier</button>
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