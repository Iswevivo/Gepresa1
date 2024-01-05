<?php
   session_start();
   if ($_SESSION['type'] != 'Admin' && $_SESSION['type'] != 'SUPER ADMIN') {
    header("Location:../404.php");
  }
  require_once("../../includes/functions.php");

$salles = getAllSalles();
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
            <h1 class="h2">LISTE DES SALLES D'EXAMEN</h1>
            <a class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add_section">Ajouter</a>
          </div>
          <!-- liste start -->
          <div>
            <table id="data" class="table datatable datatable responsive m-3">
              <thead class="bg-primary">
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Nom de la salle</th>
                  <th scope="col">Capacité d'acccueil</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($salles as $salle) : $i++; ?>
                  <tr>
                    <th scope="row"> <?= $i ?> </th>
                    <td><?= $salle['nomSalle'] ?> </td>
                    <td><?= $salle['capacite'] ?> </td>
                    <td>
                      <a data-toggle="modal" data-bs-toggle="modal" data-bs-target="#editModal<?= $salle['id'] ?>" class="btn btn-primary text-white"><span class="bi bi-pencil"> Modifier</a>

                      <a href="delete-salle.php?id=<?= $salle['id'] ?>" class="btn btn-danger"> <span class="bi bi-trash"></span>
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
            <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">AJOUTER UNE NOUVELLE SALLE</h5>
            <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="insert-salle.php" class="row g-6" method="post" id="addform">
              <div class="form-group">
                <div class="form-group">
                  <label for="nom" class="text-primary mt-3">Nom de la salle : <span class="text-danger">*</span></label>
                  <input type="text" name="nom" id="nom" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <div class="form-group">
                  <label for="capacite" class="text-primary mt-3">Capacité maximum d'acccueil : <span class="text-danger">*</span></label>
                  <input type="number" name="capacite" id="capacite" class="form-control" placeholder="Ex : 500">
                </div>
              </div>

              <div class="modal-footer">
                <button type="submit" class="btn btn-lg btn-success">Ajouter</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

    <?php
    foreach ($salles as $index => $salle) { ?>
      <!-- Modal Modifer -->
      <div class="modal fade" id="editModal<?= $salle['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">MODIFIER UNE SALLE</h5>
              <button type="button" class="btn bnt-close btn-danger" data-bs-dismiss="modal" aria-bs-label="Fermer">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="edit-salle.php" method="post">

                <input type="hidden" name="id" value="<?= $salle['id'] ?>">

                <div class="form-group">
                  <label for="nom" class="text-primary mt-3">Nom de la salle : <span class="text-danger">*</span></label>
                  <input type="text" name="nom" id="nom" class="form-control" value="<?= $salle['nomSalle'] ?>">
                </div>

                <div class="form-group">
                  <div class="form-group">
                    <label for="capacite" class="text-primary mt-3">Capacité maximale : <span class="text-danger">*</span></label>
                    <input type="number" name="capacite" id="capacote" class="form-control" value="<?= $salle['capacite'] ?>">
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
    <?php } ?>
  </main>

  <?php
  include("../../includes/footer.php");
  include("../../includes/js-plugins2.php");
  ?>