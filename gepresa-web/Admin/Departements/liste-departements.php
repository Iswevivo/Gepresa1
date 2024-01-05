
<?php
    session_start();
    
    if ($_SESSION['type'] != 'Admin' && $_SESSION['type'] != 'SUPER ADMIN') {
      header("Location:../404.php");
    }
  require_once("../../includes/functions.php");

$Departements = getAllDepartements();
$sections = getAllSections();

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

        <main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-4 m-5">
          <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">LISTE DES DEPARTEMENTS</h1>
            <a class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add_section">Ajouter</a>
          </div>
          <!-- liste start -->
          <div>
            <table id="data" class="table table-bordered datatable responsive m-3">
              <thead class="bg-primary">
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Libellé</th>
                  <th scope="col">En sigle</th>
                  <th scope="col">Section mère</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($Departements as $depart) : $i++; ?>
                  <tr>
                    <th scope="row"> <?= $i ?> </th>
                    <td><?= $depart['libelle'] ?> </td>
                    <td class="text-center"><?= $depart['sigleDep'] ?> </td>
                    <td class="text-center"><?= $depart['sigleSect'] ?> </td>
                    <td>
                      <a data-toggle="modal" data-bs-toggle="modal" data-bs-target="#editModal<?= $depart['idDep'] ?>" class="btn btn-primary text-white"><span class="bi bi-pencil"> Modifier</a>

                      <a href="delete-depart.php?id=<?= $depart['idDep'] ?>" class="btn btn-danger"> <span class="bi bi-trash"></span>
                        Supprimer</a>
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
            <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">AJOUTER UN DEPARTEMENT</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="insert-depart.php" class="row g-6" method="post" id="addform">

              <div class="col-md-12">
                <div class="form-group">
                  <label for="design" class="text-primary">Nom du département : <span class="text-danger">*</span></label>
                  <input type="text" name="designation" id="design" class="form-control">
                </div>
              </div>

              <div class="col-md-12 mt-3">
                <div class="form-group">
                  <label for="sigle" class="text-primary">Sigle ou abbréviation<span class="text-danger">*</span></label>
                  <input type="text" name="sigle" id="sigle" class="form-control" placeholder="Par exemple : IG ou AGRO-VET">
                </div>
              </div>

              <div class="col-md-12 mt-3">
                <div class="form-group">
                  <label for="section" class="text-primary">Section mère : <span class="text-danger">*</span></label>
                  <select name="section" id="section" class="form-control">
                    <?php foreach ($sections as $section) : ?>
                      <option value="<?= $section['id'] ?>"><?= $section['designation'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
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
    foreach ($Departements as $index => $depart) { ?>
      <!-- Modal Modifer -->
      <div class="modal fade" id="editModal<?= $depart['idDep'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">MODIFIER LA SECTION</h5>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="edit-depart.php" method="post">
                <input type="hidden" name="id" value="<?= $depart['idDep']; ?>">
                <div class="form-group">
                  <label for="design1">Nom du département : </label>
                  <input type="text" name="designation" id="design1" value="<?= $depart['libelle']; ?>" class="form-control">
                </div>
                <div class="form-group mt-3">
                  <label for="sigle1">Sigle du département : </label>
                  <input type="text" name="sigle" id="sigle1" value="<?= $depart['sigleDep']; ?>" class="form-control">
                </div>
                <div class="col-md-12 mt-3">

                  <div class="form-group">
                    <label for="section" class="text-primary">Section mère : <span class="text-danger">*</span></label>
                    <select name="section" id="section" class="form-control">
                      <?php foreach ($sections as $section) : ?>
                        <option value="<?= $section['id'] ?>" <?php if ($section['id'] == $depart['idSect']) echo "selected" ?>><?= $section['designation'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary"> <span class="bi bi-pencil-square"></span> Modifier</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php } 
      include("../../includes/footer.php");
      include("../../includes/js-plugins2.php");
    ?>
  </main>
</body>