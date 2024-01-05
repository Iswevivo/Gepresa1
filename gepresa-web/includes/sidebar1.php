<?php
  //  session_start();
   if (!isset($_SESSION['auth'])) {
       header("Location:../login.php");
     }
  require_once("../includes/functions.php");
?>
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">
    <?php if ($_SESSION['type'] == 'Admin' || $_SESSION['type'] == 'SUPER ADMIN') { ?>

      <li class="nav-item">
        <a class="nav-link " href="./">
          <i class="bi bi-grid"></i>
          <span>Tableau de bord</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../Admin/Sections/liste-sections.php">
          <i class="bi bi-menu-button-wide"></i><span>Sections</span>
        </a>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../Admin/Departements/liste-departements.php">
          <i class="bi bi-journal-text"></i><span>Départements</span>
        </a>
      </li><!-- End Forms Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../Admin/Promotions/liste-promotions.php">
          <i class="bi bi-layout-text-window-reverse"></i><span>Promotions </span>
        </a>

      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../Admin/Etudiants/liste-etudiants.php">
          <i class="ri ri-user-3-fill"></i><span>Etudiants</span>
        </a>
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../Admin/Surveillants/liste-surveillants.php">
          <i class="bi bi-alarm-fill"></i><span>Surveillants</span>
        </a>
      </li><!-- End Icons Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../Admin/Jurys/liste-jurys.php">
          <i class="bi bi-pencil"></i><span>Jurys</span>
        </a>
      </li><!-- End Icons Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../Admin/Salles/liste-salles.php">
          <i class="bi bi-house-fill"></i><span>Salles</span>
        </a>
      </li><!-- End Icons Nav -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="../Admin/Users/liste-utilisateurs.php">
        <i class="bi bi-people-fill"></i>
        <span>Utilisateurs</span>
      </a>
    </li><!-- End Profile Page Nav -->
    <?php }else{ ?>
      <li class="nav-item">
        <a class="nav-link " href="./">
          <i class="bx bx-home"></i>
          <span>Accueil</span>
        </a>
      </li><!-- End Dashboard Nav -->
    <?php    } ?>

    <li class="nav-heading">Gestion Affectation</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="../Section/Evaluations/liste-evaluations.php">
        <i class="bi bi-question-circle"></i>
        <span>Evaluations</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#affectations" data-bs-toggle="collapse" href="#">
        <i class="bi bi-gem"></i><span>Affectations</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="affectations" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a class="nav-link collapsed" href="../Section/Affectations/Affectations-etudiants/liste-affect-etudiants.php">
            <i class="bi bi-question-circle"></i>
            <span>Affectations des étudiants</span>
          </a>
        </li>
        <li>
          <a class="nav-link collapsed" href="../Section/Affectations/Affectations-surveillants/liste-affect-surv.php">
            <i class="bi bi-question-circle"></i>
            <span>Affectations des Surveillants</span>
          </a>
        </li>
      </ul>
    </li>
    <li><span class="divider"></span></li>
    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#fiche-presences" data-bs-toggle="collapse" href="#">
        <i class="bi bi-card-checklist"></i><span>Fiche des présences</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="fiche-presences" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a class="nav-link collapsed" href="../Section/Presences/presences-etudiants.php">
            <i class="bi bi-question-circle"></i>
            <span>Présences des étudiants</span>
          </a>
        </li>
        <li>
          <a class="nav-link collapsed" href="../Section/Presences/presences-surveillants.php">
            <i class="bi bi-question-circle"></i>
            <span>Présences des Surveillants</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="../dev-infos.php">
        <i class="bi bi-question-circle"></i>
        <span>Contacts développeur</span>
      </a>
    </li>

</aside><!-- End Sidebar-->