<?php
session_start();
require_once("../includes/functions.php");

if (!$_SESSION['auth']) {
  header("Location:../login.php");
} elseif ($_SESSION['type'] != 'Admin' && $_SESSION['type'] != 'SUPER ADMIN') {
  header("Location:../404.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<?php
require_once("../includes/head1.php");
?>

<body>
  <?php
  require_once("../includes/header1.php");
  require_once("../includes/sidebar1.php");
  ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Tableau de bord</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-11">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-lg-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Etudiants <span>| Cette année</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-person"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= getStudentsCount(); ?> <span class="text-muted small pt-2 ps-1"> au total</span></h6>
                      <span class="text-success small pt-1 fw-bold"> <?= getStudentsByGender() ?> </span>filles<span class="text-muted small pt-2 ps-1"> incluses</span>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-lg-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Surveillants </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-alarm-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= getSurveillantsCount(); ?> au total</h6>
                      <span class="text-success small pt-1 fw-bold"> <?= getSurveillantsByGender() ?> </span>femme
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-lg-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Utilisateurs </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon text-info rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= getUsersCount(); ?> au total</h6>
                      <span class="text-success small pt-1 fw-bold"> <?= getUsersByState() ?> </span>comptes désactivés
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Sales Card -->
            <div class="col-xxl-4 col-lg-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Evaluations programmées </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon text-danger rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-question-circle"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= getEvaluationsCount(); ?> <span class="text-muted small pt-2 ps-1"> au total</span></h6>
                      <span class="text-success small pt-1 fw-bold"> <?= getEvaluationsByDatePassee() ?> </span>déjà passées
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Sales Card -->
            <div class="col-xxl-4 col-lg-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Salles d'examen</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-house fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= getSallesCount(); ?> <span class="text-muted small pt-2 ps-1"> au total</span></h6>
                      <span class="text-success small pt-1 fw-bold"> <?= getSallesByCapacite() ?> </span>avec capacité ><span class="small pt-2 ps-1">100 </span>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-lg-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="card-body">
                  <h5 class="card-title">Présences signées </h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle bg-success text-white d-flex align-items-center justify-content-center">
                      <i class="bi bi-card-checklist"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?= $nbre = getSurveillantsPresencesCount() + getStudentsPresencesCount(); ?> au total </h6>
                      <span class="text-success small pt-1 fw-bold"><?= round(getStudentsPresencesCount() * 100 / $nbre, 2) ?>%</span> <span class="text-muted small pt-2 ps-1">pour étudiants</span>

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Top Selling -->
            <div class="col-12">
              <div class="card top-selling overflow-auto">

                <div class="card-body pb-0">
                  <h5 class="card-title">Présences récentes | Etudiants</h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">N°</th>
                        <th scope="col">Noms de l'étudiant</th>
                        <th scope="col">Cours</th>
                        <th scope="col">Promotion</th>
                        <th scope="col">Date</th>
                        <th scope="col">Salle</th>
                        <th scope="col">Time In</th>
                        <th scope="col">Time Out</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $presences = ($_SESSION['type'] == 'Admin' || $_SESSION['type'] == 'SUPER ADMIN') ? getAllStudentsAttendances() : getStudentsAttendancesByUsertype();
                      $i = 0;
                      foreach ($presences as $presence) :
                        if (!is_null(getStudentAffectationByDate($presence['date_presence']))) {
                          $nomSalle = getStudentAffectationByDate($presence['date_presence'])['nomSalle'];
                        $nomSalle = getStudentAffectationByDate($presence['date_presence'])['nomSalle'];
                        $i++;
                      ?>
                        <tr>
                          <th scope="row"> <?= $i ?> </th>
                          <td><?= $presence['noms'] ?> </td>
                          <td><?= $presence['cours'] ?> </td>
                          <td><?= getStudentById($presence['idEtud'])['promotion'] . ' ' . getStudentById($presence['idEtud'])['sigleDep'] ?> </td>
                          <td><?= date_format(date_create($presence['date_presence']), 'd/m/Y')  ?> </td>
                          <td><?= $nomSalle ?> </td>
                          <td><?= $presence['time_in'] ?> </td>
                          <td><?= $presence['time_out'] ?> </td>
                        </tr>
                      <?php } endforeach; ?>
                    </tbody>
                  </table>

                </div>

              </div>
            </div><!-- End Top Selling -->

          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php
  include("../includes/footer.php");
  include("../includes/js-plugins1.php");
  ?>

</body>
<script>
  const lis = document.querySelectorAll("li");

  lis.forEach(function(li) {
    li.addEventListener("click", function() {
      li.classList.toggle("active");
    });
  });
</script>

</html>