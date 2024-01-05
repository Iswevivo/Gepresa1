<!doctype html>
<html lang="en">
  <?php require_once "includes/head.php";  ?>

  <body>
    <?php require_once "includes/header.php";  ?> 
    <?php require_once "includes/sidebar.php";  ?> 

  <main id="main" class="main">
    <div class="row">
      <div class="col-6">
        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="assets/img/portrait.jpg" alt="Profile" class="rounded-circle dev-profile-img">
            <h2 class="text-primary">Isaka Wakilongo Eugène</h2>
            <h3 >Web Designer</h3>
            <!-- <div class="social-links mt-2">
              <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div> -->
          </div>
        </div>
      </div>

      <div class="col-6">
        <div class="card">
          <h2 class="text-center mt-3 text-primary">Contacter le concepteur</h2>
          <hr>
          <div class="card-body">
            <ul id="dev-info" class="nav-content h4">
              <li><i class="bi bi-whatsapp text-success mt-2"> </i><span>(243) 971 944 350, 990 266 360</span></li>
              <li><i class="bi bi-google text-info mt-2"></i><span> isakawakilongoeugene@gmail.com</span></li>
              <li><i class="bi bi-facebook text-primary mt-2"> </i><span>Isaac Wakilongo Eugène</span></li>
              <li><i class="bi bi-instagram text-danger mt-2"> </i><span>Isaac Eugene</span></li>
              <li><i class="bi bi-twitter (X) text-primary mt-2"> </i><span>@isaac_eug</span></li>
              <li><i class="bi bi-linkedin text-primary mt-2"> </i><span>Isaka Wakilongo Eugène</span></li>
            </li><!-- End Contact Page Nav -->
          </div>
        </div>
    </div>
  </main>
  
<?php 
    include("includes/footer.php"); 
    include("includes/js-plugins.php"); 
?>