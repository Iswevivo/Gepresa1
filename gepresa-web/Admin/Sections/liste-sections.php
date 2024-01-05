<?php
    session_start();
    if ($_SESSION['type'] != 'Admin' && $_SESSION['type'] != 'SUPER ADMIN') {
      header("Location:../404.php");
    }
  require_once("../../includes/functions.php");

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
            <h1 class="h2">TOUTES LES SECTIONS</h1>
            <a class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add_section">Ajouter</a>
          </div>
          <!-- liste start -->
          <div>
            <table id="data" class="table datatable center responsive m-3">
              <thead class="bg-primary">
                <tr>
                  <th scope="col" colspan="2">N°</th>
                  <th scope="col">Nom de la section</th>
                  <th scope="col">En sigle</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($sections as $section) : $i++; ?>
                  <tr>
                    <th scope="row"> <?= $i ?> </th>
                    <td id="col-id"><?= $section['id'] ?> </td>
                    <td><?= $section['designation'] ?> </td>
                    <td class="text-center"><?= $section['sigle'] ?> </td>
                    <td>
                      <a data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#editModal<?= $section['id'] ?>" class="btn btn-primary text-white editBtn"><span class="bi bi-pencil"> Modifier</a>

                      <a href="delete-section.php?id=<?= $section['id'] ?>" class="btn btn-danger" id="btn-delete"> <span class="bi bi-trash"></span>
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
            <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">AJOUTER UNE SECTION</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="insert-section.php" class="row g-6" method="post" id="addform">

              <div class="col-md-12">
                <div class="form-group">
                  <label for="design" class="text-primary">Désignation de la section <span class="text-danger">*</span></label>
                  <input type="text" name="designation" id="design" class="form-control" placeholder="Nom de la section">
                </div>
              </div>

              <div class="col-md-12 mt-3">
                <div class="form-group">
                  <label for="sigle" class="text-primary">Sigle ou abbréviation<span class="text-danger">*</span></label>
                  <input type="text" name="sigle" id="sigle" class="form-control" placeholder="Par exemple : SCAI ou H.S.S">
                </div>
              </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><span class="bi bi-server"></span> Ajouter</button>
          </div>
          </form>

        </div>
      </div>
    </div>

    <?php foreach ($sections as $index => $section) { ?>
      <!-- Modal Modifer -->
      <div class="modal fade" id="editModal<?= $section['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">MODIFIER LA SECTION</h5>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="infos">
              <form action="edit-section.php" method="post">
                <div class="form-group">
                  <input type="hidden" name="id" value="<?= $section["id"] ?>" id="idSect">
                  <label for="design1">Nom de la section : </label>
                  <input type="text" name="designation" id="design1" value="<?= $section["designation"] ?>" class="form-control">
                </div>
                <div class="form-group mt-3">
                  <label for="sigle1">Sigle de la section : </label>
                  <input type="text" name="sigle" id="sigle1" value="<?= $section["sigle"] ?>" class="form-control">
                </div>

                <div class="modal-footer mt-3">
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