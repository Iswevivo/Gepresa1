<!DOCTYPE html>
<html lang="en">
<?php 
    require_once "includes/head.php"; 
    require_once "connexion.php"; 
?>
<body>
    <div>
    <div class="row p-5">
        <div class="col-lg-2 col-md-2">
            <img src="assets/img/favicon-isp.png" alt="Logo" id="logo" width="100%">
        </div>
        <div class="col-lg-5 col-md-5 text-center">
            <h4 class="fw-bold">Institut Supérieur Pédagogique de Bukavu</h4>
            <h5 class="mt-3">Passion de l'excellence</h5>
            <h5 class="mt-3">Mépris de la médiocrité </h5>   
            <p class="fw-bolder mt-5">Système Web de gestion des présences des étudiants et des surveillants dans les salles d'examen par RFID.</p> 
        </div>
        <div class="col-lg-4 col-nd-4 border bg-light text-center">
            <h1 class=" p-1">Authentification</h1>    <hr>        
            
            <form action="" method="POST">
                <?php if(!empty($msg)) echo $msg; ?>
                <div class="input-group mb-3">
                    <span class="input-group-text bi bi-person"></span>
                    <input type="text" placeholder="Votre username" class="form-control" name="login" id="login" autocomplete="false">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text bi bi-lock"></span>
                    <input type="password" placeholder="Votre mot de passe" class="form-control" name="pass" id="pass">
                    <!-- <span class="input-group-text bi bi-eye"></span> -->
                </div>
                <input type="submit" value="Se connecter" class="btn btn-outline-success m-3" id="submit" name="btn-submit">
            </form>
        </div>
    </div>    

    <?php include "includes/footer.php" ?>
</body>
</html>

