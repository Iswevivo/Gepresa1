<?php
    session_start();
    if ($_SESSION['type'] != 'Admin' && $_SESSION['type'] != 'SUPER ADMIN') {
      header("Location:../404.php");
    }
  require_once("../../includes/functions.php");

$jurys = getAllJurys();
$promotions = getAllPromotions();
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
            <h1 class="h2">LISTE DES JURYs</h1>
            <a class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add_section">Nommer un jury</a>
          </div>
          <!-- liste start -->
          <div>
            <table id="data" class="table datatable table-bordered  responsive m-3">
              <thead class="bg-primary">
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Promotion</th>
                  <th scope="col">Président</th>
                  <th scope="col">Secrétaire 1</th>
                  <th scope="col">Secrétaire 2</th>
                  <th scope="col">Membre</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($jurys as $jury) :
                  $i++;
                  //$promotion = getPromotionById($jury['promotion_ID']);
                ?>

                  <tr>
                    <th scope="row"> <?= $i ?> </th>
                    <td><?= $jury['designation'] . " " . $jury['nomDepart'] ?> </td>
                    <td><?= $jury['president'] ?> </td>
                    <td><?= $jury['sec1'] ?> </td>
                    <td><?= $jury['sec2'] ?> </td>
                    <td><?= $jury['membre'] ?> </td>
                    <td>
                      <a data-toggle="modal" data-bs-toggle="modal" data-bs-target="#editModal<?= $jury['idJ'] ?>" class="btn btn-primary text-white"><span class="bi bi-pencil"> Modifier</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>

    <!-- Modal Ajout -->
    <div class="modal fade" id="add_section" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">AJOUTER UN JURY</h5>
            <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="insert-jury.php" class="row g-6" method="post" id="addform">

              <div class="form-group">
                <label for="promot" class="text-primary">Promotion : </label>
                <select name="promot" id="promot" class="form-control">
                  <?php foreach ($promotions as $promotion) : ?>
                    <option value="<?= $promotion['idPromot'] ?>"><?= $promotion['promotion'] . " " . $promotion['sigleDep'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="pres" class="text-primary mt-3">Président du jury : </label>
                <input type="text" name="president" id="pres" class="form-control">
              </div>

              <div class="form-group">
                <label for="sec1" class="text-primary mt-3">Secrétaire titulaire : </label>
                <input type="text" name="sec1" id="sec1" class="form-control">
              </div>

              <div class="form-group">
                <label for="sec2" class="text-primary mt-3">Secrétaire adjoint : </label>
                <input type="text" name="sec2" id="sec2" class="form-control">
              </div>

              <div class="form-group">
                <label for="membre" class="text-primary mt-3">Membre témoin : </label>
                <input type="text" name="membre" id="membre" class="form-control">
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Ajouter</button>
          </div>
          </form>

        </div>
      </div>
    </div>

    <?php
    foreach ($jurys as $index => $jury) { ?>
      <!-- Modal Modifer -->
      <div class="modal fade" id="editModal<?= $jury['idJ'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">MODIFIER UN JURY</h5>
              <button type="button" class="btn bnt-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="edit-jury.php" method="post">
                <input type="hidden" name="id" value="<?= $jury['idJ'] ?>">
                <div class="form-group">
                  <label for="promot" class="text-primary">Promotion : </label>
                  <select name="promot" id="promot" class="form-control">
                    <?php foreach ($promotions as $promotion) : ?>
                      <option value="<?= $promotion['idPromot'] ?>" <?php if ($promotion['idPromot'] == $jury['idJ']) echo "selected" ?>><?= $promotion['promotion'] . " " . $promotion['sigleDep'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group">
                  <label for="pres" class="text-primary mt-3">Président du jury : </label>
                  <input type="text" name="president" id="pres" class="form-control" value="<?= $jury['president'] ?>">
                </div>

                <div class="form-group">
                  <label for="sec1" class="text-primary mt-3">Secrétaire titulaire : </label>
                  <input type="text" name="sec1" id="sec1" class="form-control" value="<?= $jury['sec1'] ?>">
                </div>

                <div class="form-group">
                  <label for="sec2" class="text-primary mt-3">Secrétaire adjoint : </label>
                  <input type="text" name="sec2" id="sec2" class="form-control" value="<?= $jury['sec2'] ?>">
                </div>

                <div class="form-group">
                  <label for="membre" class="text-primary mt-3">Membre témoin : </label>
                  <input type="text" name="membre" id="membre" class="form-control" value="<?= $jury['membre'] ?>">
                </div>

                <div class="modal-footer">
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
  include("../../includes/footer.php");
  include("../../includes/js-plugins2.php");
  ?>