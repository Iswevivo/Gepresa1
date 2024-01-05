<?php 
  // session_start();
  if (!isset($_SESSION['auth'])) {
      header("Location:../../login.php");
    }
?>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="../../assets/img/favicon-isp.png" class="logo d-flex align-items-center">
        <img src="../../assets/img/favicon-isp.png" alt="Logo">
        <span class="d-none d-lg-block">Gepresa</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div>
      <marquee behavior="" direction="left">Gestion des présences des étudiants et des surveillants dans les salles d'examen basée sur la technologie RFID</marquee>
    </div>


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="../Users/user-profile.php" data-bs-target="dropdown-menu" data-bs-toggle="dropdown">
            <!-- <img src="../../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle"> -->
            <span class="d-none d-md-block dropdown-toggle ps-2 fw-bolder"><?= $_SESSION['type'] ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $_SESSION['username'] ?></h6>
              <span><?= $_SESSION['type'] ?></span>
            </li>
    
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../Users/user-profile.php">
                <i class="bi bi-person"></i>
                <span>Mon Profil</span>
              </a>
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../Users/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->