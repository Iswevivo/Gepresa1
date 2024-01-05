<?php if(session_start()) session_destroy(); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once "includes/head.php";  ?>

<body id="wellcome">
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 text-center">
                    <div class="hero-text">
                        <h1>Institut Supérieur Pédagogique de Bukavu</h1>
                        <h3 class="text-light">Passion de l'excellence <span class="bi bi-check-lg text-success"></span></h3>
                        <h3 class="text-light">Mépris de la médiocrité <spqn class="bi bi-x-lg text-danger"></spqn>
                        </h3>
                        <p>Système Web de gestion des présences des étudiants et des surveillants dans les salles d'examen par RFID.</p>
                        <a href="login.php" class="btn btn-outline-primary">Connectez-vous ici <span class="bi bi-arrow-right"></span></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-slider owl-carousel">
            <div class="hs-item set-bg" data-setbg="assets/img/hero/1.jpg"></div>
            <div class="hs-item set-bg" data-setbg="assets/img/hero/2.jpg"></div>
            <div class="hs-item set-bg" data-setbg="assets/img/hero/3.jpg"></div>
        </div>
    </section>
    <?php require_once "includes/js-plugins.php"; ?>
</body>

</html>