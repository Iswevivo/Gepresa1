<?php
   session_start();
   if ($_SESSION['type'] != 'Admin' && $_SESSION['type'] != 'SUPER ADMIN') {
    header("Location:../404.php");
  }
  require_once("../../includes/functions.php");

  $etudiants = getAllStudents();
  $promotions = getAllPromotions();

  $Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
  file_put_contents('../../showID.php',$Write);

?>
<script type="text/javascript" src="../../UID-check.js"></script>
<!doctype html>
<html lang="en">
<?php require_once "../../includes/head2.php";  ?>


<body>
  <?php require_once "../../includes/header2.php";  ?>
  <?php require_once "../../includes/sidebar2.php";  ?>

  <main>
    <div class="">
      <div class="row m-3">

        <main role="main" class="col-md-9 ml-sm-auto col-lg-12 col-lg-offset-5 px-4 m-5">
          <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">LISTE DES ETUDIANTS</h1>
            <a class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add_section"><span class="bi bi-plus-lg text-white">  </span>Ajouter</a>
          </div>
          <!-- liste start -->
          <div>
            <table id="data" class="table datatable table-bordered responsive m-3">
              <thead class="bg-primary">
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Photo</th>
                  <th scope="col">Matricule</th>
                  <th scope="col">Nom</th>
                  <th scope="col">Postnom</th>
                  <th scope="col">Prénom</th>
                  <th scope="col">Sexe</th>
                  <th scope="col">Card UID</th>
                  <th scope="col">Promotion</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($etudiants as $etudiant) : $i++; ?>
                  <tr>
                    <th scope="row"> <?= $i ?> </th>
                    <td><img src="../../assets/img/students/<?= $etudiant['photo'] ?>" alt="Photo" class="rounded-circle" width="50" height="40"></td>
                    <td><?= $etudiant['matricule'] ?> </td>
                    <td><?= $etudiant['nom'] ?> </td>
                    <td><?= $etudiant['postnom'] ?> </td>
                    <td><?= $etudiant['prenom'] ?> </td>
                    <td><?= $etudiant['sexe'] ?> </td>
                    <td><?= $etudiant['cardUID'] ?> </td>
                    <td><?= $etudiant['promotion'] . " " . $etudiant['sigleDep'] ?> </td>
                    <td>
                      <a data-toggle="modal" data-bs-toggle="modal" data-bs-target="#editModal<?= $etudiant['id'] ?>" class="btn btn-primary text-white"><span class="bi bi-pencil"> </a>

                      <a href="delete-student.php?id=<?= $etudiant['id'] ?>" class="btn btn-danger"> <span class="bi bi-trash"></span>
                        </a>
                        <a href="print-card.php?id=<?= $etudiant['id'] ?>" class="btn btn-secondary"> <span class="bi bi-printer"></span>
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
            <form action="insert-student.php" class="row g-6" method="post" id="addform" enctype="multipart/form-data">
              <h5 id="blink" class="text-center">Scanner une carte pour obtenir son UID</h5>
              <div class="form-group">
                <label for=""class="text-primary mt-3">Card UID : </label>
                <textarea name="cardUID" id="cardUID" rows="1" class="form-control"></textarea>
                <div id="msg"></div>
              </div>

              <div class="form-group">
                <div class="form-group">
                  <label for="matricule" class="text-primary mt-3">Matricule : </label>
                  <input type="text" name="matricule" id="matricule" class="form-control" placeholder="Ex : 5837/18-19">
                </div>

                <label for="nom" class="text-primary mt-3">Nom de l'étudiant : </label>
                <input type="text" name="nom" id="nom" class="form-control">
              </div>

              <div class="form-group">
                <label for="postnom" class="text-primary mt-3">Postnom : </label>
                <input type="text" name="postnom" id="postnom" class="form-control">
              </div>

              <div class="form-group">
                <label for="prenom" class="text-primary mt-3">Prénom : </label>
                <input type="text" name="prenom" id="prenom" class="form-control">
              </div>

              <div class="form-group">
                <label for="sexe" class="text-primary mt-3">Sexe : <span class="text-danger">*</span></label>
                <select name="sexe" id="sexe" class="form-control">
                  <option value="F">Féminin</option>
                  <option value="M">Masculin</option>
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
                <label for="photo" class="text-primary mt-3">Photo de l'étudiant : <span class="text-danger">*</span></label>
                <input type="file" name="photo" id="photo" title="Image de 15Mo maximum">
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
    foreach ($etudiants as $index => $etudiant) { ?>
      <!-- Modal Modifer -->
      <div class="modal fade" id="editModal<?= $etudiant['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">MODIFIER UN ETUDIANT</h5>
              <button type="button" class="btn bnt-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="edit-student.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id" value="<?= $etudiant['id']; ?>">
                <h6 id="" class="text-center">Scanner une carte pour modifier le card UID de cet étudiant</h6>
                <div class="form-group">
                  <label for="cardUID1"class="text-primary mt-3">Card UID : <?= $etudiant['cardUID']; ?></label>
                  <textarea name="cardUID1" id="cardUID1" rows="1" class="form-control"></textarea>
                  <div id="msg1"></div>
                </div>
                <div class="form-group">
                  <label for="matricule" class="text-primary mt-3">Matricule : <span class="text-danger">*</span></label>
                  <input type="text" name="matricule" id="matricule" value="<?= $etudiant['matricule']; ?>" class="form-control">
                </div>

                <div class="form-group">
                  <label for="nom" class="text-primary mt-3">Nom de l'étudiant : <span class="text-danger">*</span></label>
                  <input type="text" name="nom" id="nom" value="<?= $etudiant['nom']; ?>" class="form-control">
                </div>

                <div class="form-group">
                  <label for="postnom" class="text-primary mt-3">Postnom : <span class="text-danger">*</span></label>
                  <input type="text" name="postnom" id="postnom" value="<?= $etudiant['postnom']; ?>" class="form-control">
                </div>

                <div class="form-group">
                  <label for="prenom" class="text-primary mt-3">Prénom : <span class="text-danger">*</span></label>
                  <input type="text" name="prenom" id="prenom" value="<?= $etudiant['prenom']; ?>" class="form-control">
                </div>

                <div class="form-group">
                  <label for="sexe" class="text-primary mt-3">Sexe : <span class="text-danger">*</span></label>
                  <select name="sexe" id="sexe" class="form-control">
                    <option value="F" <?php if ($etudiant['sexe'] == "F") echo "selected" ?>>Féminin</option>
                    <option value="M" <?php if ($etudiant['sexe'] == "M") echo "selected" ?>>Masculin</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="promot" class="text-primary mt-3">Promotion : <span class="text-danger">*</span></label>
                  <select name="promotion" id="promot" class="form-control">
                    <?php foreach ($promotions as $promotion) : ?>
                      <option value="<?= $promotion['idPromot'] ?>" <?php if ($promotion['idPromot'] == $etudiant['idPromot']) echo "selected" ?>><?= $promotion['promotion'] . " " . $promotion['libelle'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>


                <div class="form-group">
                  <label for="photo" class="text-primary mt-3">Photo de l'étudiant : </label>
                  <input type="file" name="photo" id="photo">
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

  <script>
    var blink = document.getElementById('blink');
    setInterval(function() {
      blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
    }, 750);
  </script>