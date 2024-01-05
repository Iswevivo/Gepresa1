<?php 
    session_start();
    if (!$_SESSION['auth']) {
      header("Location:index.php");
    }
    require_once "includes/functions.php";

    $users = getAllUsers();

    if(!empty($_GET)){
      if ($_GET['m']==1) {
        $msg = "Veuillez renseigner tous les champs";
      } elseif($_GET['m']==2) {
        $msg = "Une erreur inconnue est survenue : veuillez essayer plus tard !";
      }elseif($_GET['m']==3) {
        $msg = "Une erreur inattendue s'est produite. Vous devez vous déconnecter puis vous réconnecter pour réessayer.";
      }elseif($_GET['m']==4) {
        $msg = "L'ancien mot de passe est incorrect.";
      }elseif($_GET['m']==5) {
        $msg = "L'ancien et le nouveau mots de passe ne doivent pas être identique.";
      }elseif($_GET['m']==6) {
        $msg = "Les deux nouveaux mots de passe ne sont pas identiques.";
      }elseif($_GET['m']==7) {
        $msg = "Une erreur inattendue s'est produite. Vous devez vous déconnecter puis vous réconnecter pour réessayer.";
      }
    }
?>

<!doctype html>
<html lang="en">
  <?php require_once "includes/head.php";  ?>

  <body>
    <?php require_once "includes/header.php";  ?> 
    <?php require_once "includes/sidebar.php";  ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">My account</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active bg-secondary text-white" data-bs-toggle="tab" data-bs-target="#profile-overview">Information du profil</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link bg-info text-white" data-bs-toggle="tab" data-bs-target="#profile-change-password">Modifier le mot de passe</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview mt-3" id="profile-overview">

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nom d'utilisateur </div>
                    <div class="col-lg-9 col-md-8"><?= $_SESSION['username'] ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Fonction </div>
                    <div class="col-lg-9 col-md-8"><?= $_SESSION['type'] ?></div>
                  </div>
                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form method="POST" action="changePswd.php">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-5 col-form-label">Mot de passe actuel</label>
                      <div class="col-md-8 col-lg-7">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-5 col-form-label">Nouveau mot de passe</label>
                      <div class="col-md-8 col-lg-7">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-5 col-form-label">Confirmer le nouveau mot de passe</label>
                      <div class="col-md-8 col-lg-7">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>
                    
                    <?php if(!empty($msg)) echo "<div class='alert alert-danger'>$msg</div>"; ?>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary"><span class="bi bi-save"></span> Sauvegarder</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

<?php 
    include("includes/footer.php"); 
    include("includes/js-plugins.php"); 
?>