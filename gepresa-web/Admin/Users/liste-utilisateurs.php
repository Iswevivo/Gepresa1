<?php
   session_start();
   if ($_SESSION['type'] != 'Admin' && $_SESSION['type'] != 'SUPER ADMIN') {
    header("Location:../404.php");
  }
  require_once("../../includes/functions.php");

$users = getAllUsers();
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
            <h1 class="h2">LISTE DES UTILISATEURS</h1>
            <a class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add_section">Ajouter</a>
          </div>
          <!-- liste start -->
          <div>
            <table id="data" class="table datatable table-bordered  responsive m-3">
              <thead class="bg-primary">
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Username</th>
                  <th scope="col">Rôle</th>
                  <th scope="col">Etat compte</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($users as $user) : $i++; ?>
                  <tr>
                    <th scope="row"> <?= $i ?> </th>
                    <td><?= $user['login'] ?> </td>
                    <td><?= $user['role'] ?> </td>
                    <td><?= $user['statut'] == 1 ? "Activé" : "Désactivé" ?> </td>
                    <td>
                      <a data-toggle="modal" data-bs-toggle="modal" data-bs-target="#editModal<?= $user['id'] ?>" class="btn btn-primary">
                        <span class="bi bi-pencil"></span>
                        Modifier
                      </a>

                      <a href="changeAccountState.php?id=<?= $user['id'] ?>" class="<?= $user['statut'] == 0 ? 'btn btn-warning btn-lg' : 'btn btn-success' ?>">
                        <span class="<?= $user['statut'] == 0 ? 'bi bi-check-lg' : 'bi bi-x-lg' ?>"></span>
                        <?= $user['statut'] == 1 ? "Désactiver" : "Activer" ?>
                      </a>
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
            <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">AJOUTER UN ETUDIANT</h5>
            <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="insert-user.php" class="row g-6" method="post" id="addform">
              <div class="form-group">
                <label for="login" class="text-primary mt-3">Username : </label>
                <input type="text" name="login" id="login" class="form-control">
              </div>

              <div class="form-group">
                <label for="role" class="text-primary mt-3">Rôle dans le système : </label>
                <select name="role" id="role" class="form-control">
                  <option value="Admin">Administrateur</option>
                  <option value="Jury" selected>Jury</option>
                  <option value="Section">Section</option>
                </select>
              </div>
              <div class="modal-footer mt-4">
                <button type="submit" class="btn btn-primary">Ajouter</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

    <?php
      foreach ($users as $index => $user) { ?>
        <!-- Modal Modifer -->
        <div class="modal fade" id="editModal<?= $user['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">MODIFIER UN ETUDIANT</h5>
                <button type="button" class="btn bnt-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="edit-user.php" method="post">

                  <input type="hidden" name="id" value="<?= $user['id']; ?>">

                  <div class="form-group">
                    <label for="login" class="text-primary mt-3">Username : </label>
                    <input type="text" name="login" id="login" class="form-control" value="<?= $user['login']; ?>">
                  </div>

                  <div class="form-group">
                    <label for="role" class="text-primary mt-3">Rôle dans le système : </label>
                    <select name="role" id="role" class="form-control">
                      <option value="Admin" <?php if ($user['statut'] == "Admin") echo "selected"; ?>>Administrateur</option>
                      <option value="Jury" <?php if ($user['statut'] == "Jury") echo "selected"; ?>>Jury</option>
                      <option value="Section" <?php if ($user['statut'] == "Section") echo "selected"; ?>>Section</option>
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
      <?php } ?>
  </main>

  <?php
  include("../../includes/footer.php");
  include("../../includes/js-plugins2.php");
  ?>