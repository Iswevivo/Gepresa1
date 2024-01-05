<?php
  session_start();
  if ($_SESSION['type'] != 'Admin' && $_SESSION['type'] != 'SUPER ADMIN') {
    header("Location:../404.php");
  }
require_once "../../includes/functions.php";

$Departements = getAllDepartements();
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

        <main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-4 m-5">
          <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">TOUTES LES PROMOTIONS</h1>
            <a class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#add_section"><span class="bx bx-plus"></span> Ajouter</a>
          </div>
          <!-- liste start -->
          <div>
            <table id="data" class="table datatable table-bordered  responsive m-3">
              <thead class="bg-primary">
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Désignaion</th>
                  <th scope="col">Section mère</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;

                foreach ($promotions as $promotion) : $i++; ?>
                  <tr>
                    <th scope="row"> <?= $i ?> </th>
                    <td><?= $promotion['promotion'] . " " . $promotion['sigleDep'] ?> </td>
                    <td class="text-center"><?= $promotion['sigleSect'] ?> </td>
                    <td>
                      <a data-toggle="modal" data-bs-toggle="modal" data-bs-target="#editModal<?= $promotion['idPromot'] ?>" class="btn btn-primary text-white"><span class="bi bi-pencil"> Modifier</a>

                      <a href="delete-promot.php?id=<?= $promotion['idPromot'] ?>" class="btn btn-danger"> <span class="bi bi-trash"></span>
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
            <h5 class="modal-title" id="exampleModalLabel" class="text-primary text-center">AJOUTER UNE PROMOTION</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="insert-promot.php" class="row g-6" method="post" id="addform">

              <div class="col-md-12">
                <div class="form-group">
                  <label for="design" class="text-primary">Désignation : <span class="text-danger">*</span></label>
                  <select name="designation" id="design" class="form-control">
                      <option value="L1 LMD">L1 LMD</option>
                      <option value="L2 LMD">L2 LMD</option>
                      <option value="L3 LMD">L3 LMD</option>
                      <option value="L4 LMD">L4 LMD</option>
                      <option value="G3">G3</option>        
                      <option value="L1">L1</option>               
                      <option value="L2">L2</option>                      
                  </select>
                </div>
              </div>

              <div class="col-md-12 mt-3">
                <div class="form-group">
                  <label for="section" class="text-primary">Département : <span class="text-danger">*</span></label>
                  <select name="depart" id="section" class="form-control">
                    <?php foreach ($Departements as $depart) : ?>
                      <option value="<?= $depart['idDep'] ?>"><?= $depart['libelle'] ?></option>
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
    foreach ($promotions as $index => $promotion) { ?>
      <!-- Modal Modifer -->
      <div class="modal fade" id="editModal<?= $promotion['idPromot'] ?>" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">MODIFIER LA SECTION</h5>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fermer">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="edit-promot.php" method="post">
                <input type="hidden" name="id" value=<?= $promotion['idPromot'] ?>>
                <div class="form-group">
                  <label for="design1">Designation : </label>
                  <select name="designation" id="design1" class="form-control">
                      <option value="L1 LMD" <?php if($promotion['promotion']=='L1 LMD') echo 'selected' ?>>L1 LMD</option>
                      <option value="L2 LMD" <?php if($promotion['promotion']=='L2 LMD') echo 'selected' ?>>L2 LMD</option>
                      <option value="L3 LMD" <?php if($promotion['promotion']=='L3 LMD') echo 'selected' ?>>L3 LMD</option>
                      <option value="L4 LMD" <?php if($promotion['promotion']=='L4 LMD') echo 'selected' ?>>L4 LMD</option>
                      <option value="G3" <?php if($promotion['promotion']=='G3') echo 'selected' ?>>G3</option>        
                      <option value="L1" <?php if($promotion['promotion']=='L1') echo 'selected' ?>>L1</option>               
                      <option value="L2" <?php if($promotion['promotion']=='L2') echo 'selected' ?>>L2</option>                      
                  </select>
                </div>

                <div class="col-md-12 mt-3">
                <div class="form-group">
                  <label for="section" class="text-primary">Département : <span class="text-danger">*</span></label>
                  <select name="depart" id="section" class="form-control">
                    <?php foreach ($Departements as $depart) : ?>
                      <option value="<?= $depart['idDep'] ?>" <?php if($depart['idDep']==$promotion['idDep']) echo "selected" ?>><?= $depart['libelle'] ?></option>
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