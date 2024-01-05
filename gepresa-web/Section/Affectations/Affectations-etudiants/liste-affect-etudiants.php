<?php
    session_start();
    if (!isset($_SESSION['auth'])) {
        header("Location:../../login.php");
      };
  require_once "../../../includes/functions.php";

  $affectations = getAllStudentsAffectations();
  $salles = getAllSalles();
  $promotions = $_SESSION['type']=='Section' ? getPromotionsBySection() : getAllPromotions();
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
            <h1 class="h2">LISTE D'AFFECTATIONS DES ETUDIANTS</h1>
            <?php if ($_SESSION['type'] != 'Jury') { ?>
              <a class="btn btn-primary text-white ml-5" data-bs-toggle="modal" data-bs-target="#add_eval"><span class="bi bi-plus-lg"></span> Nouvelle affectation</a>
            <?php } ?>
            <a class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#print"><span class="bi bi-printer"></span>  Impression des listes</a>
          </div>
          <!-- liste start -->
          <div>
            <table id="data" class="table table-bordered datatable responsive m-3">
              <thead class="bg-primary">
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Nom de l'étudiant</th>
                  <th scope="col">Sexe</th>
                  <th scope="col">Promotion</th>
                  <th scope="col">Salle</th>
                  <th scope="col">Date</th>
                  <?php if ($_SESSION['type'] != 'Jury') { ?>
                    <th scope="col">Action</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($affectations as $affectation) : $i++; ?>
                  <tr>
                    <th scope="row"> <?= $i ?> </th>
                    <td><?= $affectation['nom'] . " " . $affectation['postnom'] . " " . $affectation['prenom'] ?> </td>
                    <td><?= $affectation['sexe'] ?> </td>
                    <td><?= $affectation['promotion'] . " " . $affectation['nomDepart'] ?> </td>
                    <td><?= $affectation['nomSalle'] ?> </td>
                    <td><?= date_format(date_create($affectation['dateAffectation']), 'd/m/Y') ?> </td>
                    <?php if ($_SESSION['type'] != 'Jury') { ?>
                      <td>
                        <a href="delete-salle.php?id=<?= $evaluation[0] ?>" class="btn btn-danger"> <span class="bi bi-trash"></span>
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

    <!-- Ajouter un type d'évaluation -->
    <div class="modal fade" id="add_type" tabindex="-1" role="dialog" aria-hidden="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">AJOUTER UNE NOUVELLE CATEGORIE</h5>
            <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="add-typeEvaluation.php" class="row g-6" method="post" id="addform">

              <div class="form-group">
                <div class="form-group">
                  <label for="design" class="text-primary mt-3">Désignation de la nouvelle catégorie : <span class="text-danger">*</span></label>
                  <input type="text" name="designation" id="design" class="form-control">
                </div>
              </div>

              <div class="modal-footer mt-3">
                <button type="submit" class="btn btn-lg btn-success"><span class="bi bi-server"></span> Enregistrer</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

    <!-- Ajouter une évaluation -->
    <div class="modal fade" id="add_eval" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">NOUVELLE AFFECTATION</h5>
            <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="insert-affect-etudiants.php" class="row g-6" method="post" id="addform">

            <div class="form-group">
                <div class="form-group">
                  <label for="date" class="text-primary mt-3">Date d'affectation : <span class="text-danger">*</span></label>
                  <input type="date" name="date" id="date" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <label for="salle" class="text-primary mt-3">Salle : <span class="text-danger">*</span></label>
                <select name="salle" id="salle" class="form-control">
                  <?php foreach ($salles as $salle) : ?>
                    <option value="<?= $salle['id'] ?>"><?= $salle['nomSalle'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="promot" class="text-primary mt-3">Promotion : <span class="text-danger">*</span></label>
                <select name="promotion" id="promot" class="form-control">
                  <?php foreach ($promotions as $promotion) : ?>
                    <option value="<?= $promotion['idPromot'] ?>"><?= $promotion['promotion'] . "   " . $promotion['sigleDep'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <div class="form-group">
                  <label for="nbre" class="text-primary mt-3">Nombre d'étudiants à affecter : <span class="text-danger">*</span></label>
                  <input type="number" name="nbre" id="nbre" class="form-control">
                </div>
              </div>

              <div class="modal-footer mt-3">
                <button type="submit" class="btn btn-lg btn-success"><span class="bi bi-server"></span> Valider</button>
              </div>
            </form>

          </div>
        </div>
      </div>

  </main>

  <?php
  include("../../../includes/footer.php");
  include("../../../includes/js-plugins3.php");
  ?>