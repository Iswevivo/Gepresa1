<?php
  session_start();
  if (!isset($_SESSION['auth'])) {
    header("Location:../../login.php");
  }
  require_once "../../includes/functions.php";
  // session_start();
  // if (!isset($_SESSION['auth'])) {
  //   header("Location:../../");
  // }

  $Evaluations = ($_SESSION['type'] == 'Admin' || $_SESSION['type'] == 'SUPER ADMIN') ? getAllEvaluations() : getEvaluationsByUsertype();
  $promotions = getAllPromotions();
  $promotionsParSection = getPromotionsBySection();
  $typeEvaluations = getAllEvaluationsTypes();
  $data = $_SESSION['type'] == 'Section' ? $promotionsParSection : $promotions;

?>
<!doctype html>
<html lang="en">
<?php require_once "../../includes/head2.php";  ?>

<body>
  <?php require_once "../../includes/header2.php";  ?>
  <?php require_once "../../includes/sidebar2.php";  ?>

  <main>
    <div class="container ">
      <div class="row m-3">

        <main role="main" class="col-md-9 ml-sm-auto col-lg-12 col-lg-offset-5 px-4 m-5">
          <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">EVALUATIONS PROGRAMMEES</h1>
            <?php if ($_SESSION['type'] == 'Admin' || $_SESSION['type'] == 'SUPER ADMIN') { ?>
              <a class="btn btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#add_type"><span class="bi bi-plus"></span> Ajouter un type d'évaluation</a>
            <?php } ?>
            <a class="btn btn-primary text-white ml-5" data-bs-toggle="modal" data-bs-target="#add_eval">Programmer une évaluation</a>
          </div>
          <!-- liste start -->
          <div>
            <table id="data" class="table table-bordered datatable responsive m-3">
              <thead class="bg-primary">
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Date prévue</th>
                  <th scope="col">Heure</th>
                  <th scope="col">Promotion</th>
                  <th scope="col">Type d'évaluation</th>
                  <th scope="col">Session</th>
                  <th scope="col">Intitulé du cours</th>
                  <?php if ($_SESSION['type'] != 'Jury') { ?>
                    <th scope="col">Actions</th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($Evaluations as $evaluation) : $i++; ?>
                  <tr>
                    <th scope="row"> <?= $i ?> </th>
                    <td><?= date_format(date_create($evaluation['date_evaluation']), 'd-M-Y') ?> </td>
                    <td><?= $evaluation['vacation'] ?> </td>
                    <td><?= getPromotionById($evaluation['promotion_ID'])['promotion'] . " " . getPromotionById($evaluation['promotion_ID'])['sigleDep'] ?> </td>
                    <td><?= $evaluation['designation'] ?> </td>
                    <td><?= $evaluation['session'] ?> </td>
                    <td><?= $evaluation['intitule_cours'] ?> </td>
                    <?php if ($_SESSION['type'] != 'Jury') { ?>
                      <td>
                        <a data-toggle="modal" data-bs-toggle="modal" data-bs-target="#editModal<?= $evaluation['idEval'] ?>" class="btn btn-primary text-white"><span class="bi bi-pencil"> Edit</a>

                        <a href="delete-evaluation.php?id=<?= $evaluation['idEval'] ?>" class="btn btn-danger"> <span class="bi bi-trash"></span>
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

    <?php if ($_SESSION['type'] != 'Jury') { ?>

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
              <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">PROGRAMMER UNE EVALUATION</h5>
              <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="insert-evaluation.php" class="row g-6" method="post" id="addform">

                <div class="form-group">
                  <label for="type" class="text-primary mt-3">Type d'évaluation : <span class="text-danger">*</span></label>
                  <select name="type" id="type" class="form-control">
                    <?php foreach ($typeEvaluations as $type) : ?>
                      <option value="<?= $type['id'] ?>"><?= $type['designation'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="session" class="text-primary mt-3">Session : <span class="text-danger">*</span></label>
                  <select name="session" id="session" class="form-control">
                    <option value="Février">Février</option>
                    <option value="Juillet">Juillet</option>
                    <option value="Mi-Session">Mi-Session</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="promot" class="text-primary mt-3">Promotion : <span class="text-danger">*</span></label>
                  <select name="promotion" id="promot" class="form-control">
                    <?php
                    foreach ($data as $promotion) : ?>
                      <option value="<?= $promotion['idPromot'] ?>"><?= $promotion['promotion'] . "   " . $promotion['sigleDep'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group">
                  <div class="form-group">
                    <label for="intitule" class="text-primary mt-3">Intitulé du cours : <span class="text-danger">*</span></label>
                    <input type="text" name="intitule" id="intitule" class="form-control">
                  </div>
                </div>

                <div class="form-group">
                  <div class="form-group">
                    <label for="date" class="text-primary mt-3">Date prévue : <span class="text-danger">*</span></label>
                    <input type="date" name="date" id="date" class="form-control">
                  </div>
                </div>

                <div class="form-group">
                  <label for="vacation" class="text-primary mt-3">Vacation : <span class="text-danger">*</span></label>
                  <select name="vacation" id="vacation" class="form-control">
                    <option value="AM">Avant-midi</option>
                    <option value="PM">Après-midi</option>
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
        foreach ($Evaluations as $index => $evaluation) { ?>
          <!-- Modal Modifer -->
          <div class="modal fade" id="editModal<?= $evaluation['idEval'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">EDITER UNE EVALUATION</h5>
                  <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="edit-evaluation.php" class="row g-6" method="post" id="addform">
                    <input type="hidden" name="id" value="<?= $evaluation['idEval'] ?>">
                    <div class="form-group">
                      <label for="type" class="text-primary mt-3">Type d'évaluation : <span class="text-danger">*</span></label>
                      <select name="type" id="type" class="form-control">
                        <?php foreach ($typeEvaluations as $type) : ?>
                          <option value="<?= $type['id'] ?>" <?php if($evaluation['designation']==$type['designation']) echo 'selected' ?>><?= $type['designation'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="session" class="text-primary mt-3">Session : <span class="text-danger">*</span></label>
                      <select name="session" id="session" class="form-control">
                        <option value="Février" <?php if ($evaluation['session'] == 'Février') echo 'selected'; ?>>Février</option>
                        <option value="Juillet" <?php if ($evaluation['session'] == 'Juillet') echo 'selected'; ?>>Juillet</option>
                        <option value="Mi-Session" <?php if ($evaluation['session'] == 'Mi-Session') echo 'selected'; ?>>Mi-Session</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="promot" class="text-primary mt-3">Promotion : <span class="text-danger">*</span></label>
                      <select name="promotion" id="promot" class="form-control">
                        <?php
                        foreach ($data as $promotion) : ?>
                          <option value="<?= $promotion['idPromot'] ?>" <?php if ($evaluation['promotion_ID'] == $promotion['idPromot']) echo 'selected'; ?>><?= $promotion['promotion'] . "   " . $promotion['sigleDep'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <div class="form-group">
                        <label for="intitule" class="text-primary mt-3">Intitulé du cours : <span class="text-danger">*</span></label>
                        <input type="text" name="intitule" id="intitule" class="form-control" value="<?= $evaluation['intitule_cours'] ?>">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-group">
                        <label for="date" class="text-primary mt-3">Date prévue : <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" class="form-control" value="<?= $evaluation['date_evaluation'] ?>">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="vacation" class="text-primary mt-3">Vacation : <span class="text-danger">*</span></label>
                      <select name="vacation" id="vacation" class="form-control">
                        <option value="AM" <?php if ($evaluation['vacation'] == 'AM') echo 'selected' ?>>Avant-midi</option>
                        <option value="PM" <?php if ($evaluation['vacation'] == 'PM') echo 'selected' ?>>Après-midi</option>
                      </select>
                    </div>

                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary"> <span class="bi bi-pencil-square"></span> Modifier</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
    <?php } } ?>
  </main>

  <?php
  include("../../includes/footer.php");
  include("../../includes/js-plugins2.php");
  ?>