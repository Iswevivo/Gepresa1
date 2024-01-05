<?php
    session_start();
    if ($_SESSION['type'] != 'Admin' && $_SESSION['type'] != 'SUPER ADMIN') {
      header("Location:../404.php");
    }
  require_once("../../includes/functions.php");

$surveillants = getAllSurveillants();

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
    <div class="container ">
      <div class="row m-3">

        <main role="main" class="col-md-9 ml-sm-auto col-lg-12 col-lg-offset-5 px-4 m-5">
          <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">LISTE DE TOUS LES SURVEILLANTS</h1>
            <a class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add_section">Ajouter</a>
          </div>
          <!-- liste start -->
          <div>
            <table id="data" class="table datatable table-bordered  responsive m-3">
              <thead class="bg-primary">
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Nom du surveillant</th>
                  <th scope="col">Sexe</th>
                  <th scope="col">Grade</th>
                  <th scope="col">ID Carte</th>
                  <th scope="col">Attribution</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($surveillants as $surveillant) : $i++; ?>
                  <tr>
                    <th scope="row"> <?= $i ?> </th>
                    <td><?= $surveillant['nomComplet'] ?> </td>
                    <td><?= $surveillant['sexe'] ?> </td>
                    <td><?= $surveillant['grade'] ?> </td>
                    <td><?= $surveillant['cardID'] ?> </td>
                    <td><?= $surveillant['estChefDeSalle'] == 1 ? "Chef de salle" : "Surveillant" ?> </td>
                    <td>
                      <a data-toggle="modal" data-bs-toggle="modal" data-bs-target="#editModal<?= $surveillant['id'] ?>" class="btn btn-primary text-white"><span class="bi bi-pencil"> Modifier</a>

                      <a href="delete-surveillant.php?id=<?= $surveillant['id'] ?>" class="btn btn-danger"> <span class="bi bi-trash"></span>
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
            <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">AJOUTER UN SURVEILLANT</h5>
            <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="insert-surveillant.php" class="row g-6" method="post" id="addform">
              <div class="form-group">
                <div class="form-group">
                  <label for="nom" class="text-primary mt-3">Nom complet du surveillant : <span class="text-danger">*</span></label>
                  <input type="text" name="nomComplet" id="nom" class="form-control" placeholder="Ex : Ariane Mukobelwa Arielle">
                </div>

                <div class="form-group">
                  <label for="sexe" class="text-primary mt-3">Sexe : <span class="text-danger">*</span></label>
                  <select name="sexe" id="sexe" class="form-control">
                    <option value="F">Féminin</option>
                    <option value="M">Masculin</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="grade" class="text-primary mt-3">Grade : <span class="text-danger">*</span></label>
                  <select name="grade" id="grade" class="form-control">
                    <option value="Ass.">Assistant</option>
                    <option value="C.T">Chef des travaux</option>
                    <option value="Dr.">Docteur</option>
                    <option value="Prof.">Professeur</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="chef" class="text-primary mt-3">Est chef de salle : <span class="text-danger">*</span></label>
                  <select name="chef" id="chef" class="form-control">
                    <option value="0">NON</option>
                    <option value="1">OUI</option>
                  </select>
                </div>

                <div class="form-group mb-3">
                  <label for=""class="text-primary mt-3">ID de la carte : </label>
                  <textarea name="cardUID" id="cardUID" rows="1" class="form-control"></textarea>
                  <div id="msg"></div>
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
      foreach ($surveillants as $index => $surveillant) { ?>
        <!-- Modal Modifer -->
        <div class="modal fade" id="editModal<?= $surveillant['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">MODIFIER UN SURVEILLANT</h5>
                <button type="button" class="btn bnt-close btn-danger" data-bs-dismiss="modal" aria-label="Fermer">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="edit-surveillant.php" method="post">
                  <input type="hidden" name="id" id="id2" value="<?= $surveillant['id'] ?>">
                  <div class="form-group">
                    <div class="form-group">
                      <label for="nom" class="text-primary mt-3">Nom complet du surveillant : <span class="text-danger">*</span></label>
                      <input type="text" name="nomComplet" id="nom" class="form-control" value="<?= $surveillant['nomComplet'] ?>">
                    </div>

                    <div class="form-group">
                      <label for="sexe" class="text-primary mt-3">Sexe : <span class="text-danger">*</span></label>
                      <select name="sexe" id="sexe" class="form-control">
                        <option value="F" <?php if ($surveillant['sexe'] == "F") echo "selected" ?>>Féminin</option>
                        <option value="M" <?php if ($surveillant['sexe'] == "M") echo "selected" ?>>Masculin</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="grade" class="text-primary mt-3">Grade : <span class="text-danger">*</span></label>
                      <select name="grade" id="grade" class="form-control">
                        <option value="Ass." <?php if ($surveillant['grade'] == "Ass.") echo "selected" ?>>Assistant</option>
                        <option value="C.T" <?php if ($surveillant['grade'] == "C.T") echo "selected" ?>>Chef des travaux</option>
                        <option value="Dr." <?php if ($surveillant['grade'] == "Dr.") echo "selected" ?>>Docteur</option>
                        <option value="Prof." <?php if ($surveillant['grade'] == "Prof.") echo "selected" ?>>Professeur</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="chef" class="text-primary mt-3">Est chef de salle : <span class="text-danger">*</span></label>
                      <select name="chef" id="chef" class="form-control">
                        <option value="0" <?php if ($surveillant['estChefDeSalle'] == 0) echo "selected" ?>>NON</option>
                        <option value="1" <?php if ($surveillant['estChefDeSalle'] == 1) echo "selected" ?>>OUI</option>
                      </select>
                    </div>

                    <hr>
                    <h6 id="" class="text-center">Scanner une carte si vous voulez modifier l'UID présent</h6>
                    <div class="form-group mb-3">
                      <label for="cardUID2"class="text-primary mt-3">ID carte : <?= $surveillant['cardID']; ?></label>
                      <textarea name="cardUID2" id="cardUID2" rows="1" class="form-control"></textarea>
                      <div id="msg1"></div>
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

  
<script>
    var blink = document.getElementById('blink');
    setInterval(function() {
      blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
    }, 750);
</script>