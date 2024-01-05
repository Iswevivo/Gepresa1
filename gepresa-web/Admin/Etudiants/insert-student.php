<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $cardID = isset($_POST['cardUID'])? $_POST['cardUID'] : "";
    $nom = isset($_POST['matricule'])? htmlspecialchars(strtoupper($_POST['matricule'])) :"";
    $nom = isset($_POST['nom'])? htmlspecialchars(strtoupper($_POST['nom'])) :"";
    $postnom = isset($_POST['postnom'])? htmlspecialchars(strtoupper($_POST['postnom'])) :"";
    $prenom = isset($_POST['prenom'])? htmlspecialchars(ucfirst(strtolower($_POST['prenom']))) :"";
    $sexe = isset($_POST['sexe'])? $_POST['sexe'] :"";
    $promotion = isset($_POST['promotion'])? $_POST['promotion'] :"";
    $matricule = isset($_POST['matricule'])? htmlspecialchars($_POST['matricule']) :"";
    $photo_name = isset($_FILES['photo'])? $_FILES['photo']['name'] :"";
    $photo_path = isset($_FILES['photo']['tmp_name'])? $_FILES['photo']['tmp_name'] :"";

    if(!empty($cardID) &&!empty($matricule) && !empty($nom) && !empty($postnom) && !empty($promotion) && !empty($photo_name)) {

        if ($_FILES['photo']['size']>15000000) {
            $msg= "<div class='bg-danger text-white'>Erreur lors du téléchargement du fichier car le fichier dépasse la taille maximale recommandée ! <br> La pièce jointe doit être une image de 15Mo maximale.</div>";
        }else{
            $extensions_autorisees= array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
            $ext_fichier= $_FILES['photo']['type'];
            
            if (!in_array($ext_fichier, $extensions_autorisees)) {
                $msg= "<div class='bg-danger text-white'>Le fichier choisi est d'un format non autorisé! Seules les extensions suivantes sont autorisée: .jpg, .jpeg, .png, .gif</div>";
            }else{

                $req = $db->query("SELECT * FROM Etudiants WHERE cardUID ='$cardID'");

                if ($req->rowCount() > 0) {
                    $msg = "<div class='alert bg-danger text-white'><span class='bi bi-x-octagon-fill'>   Ce numéro de carte est déjà attribué à un autre étudiant.</span></div>";
                }else{
                    $req = $db->query("SELECT * FROM Surveillants WHERE cardID = '$cardID'");
                        
                    if ($req->rowCount() > 0) {
                        $msg = "<div class='alert bg-danger text-white'><span class='bi bi-x-circle-fill'>    Ce numéro de carte est déjà attribué à un surveillant.</span></div>";
                    }else{

                        if(getStudentByMatricule($matricule) === false){
                            $etudiant = $db->query("SELECT * FROM Etudiants WHERE matricule='$matricule' OR (nom = '$nom' AND postnom='$postnom' AND prenom='$prenom' AND sexe='$sexe' AND promotion_ID= $promotion)");

                            if($etudiant->rowCount() < 1){
                            //Insert query
                                $query = $db->prepare("INSERT INTO `Etudiants` (matricule, nom, postnom, prenom, sexe, promotion_ID, photo, cardUID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                                $params=array($matricule, $nom, $postnom, $prenom, $sexe, $promotion, $photo_name, $cardID);
                                $resultat = $query->execute($params);

                                $upload = move_uploaded_file($photo_path, "../../assets/img/students/$photo_name");

                                if ($resultat && $upload){
                                    $msg="<div class='alert alert-success text-center'>
                                        <span class='bi bi-shield-fill-check'></span>
                                        <strong class='h3'>Felicitation!<strong/><br><br> Nouvel étudiant ajouté avec succès  
                                        <span class='bi bi-check2-all'></span>
                                        </div>";
                                }
                            }else {
                                $msg="<div class='alert alert-warning text-center'>
                                    <span class='bi bi-exclamation-triangle'></span>
                                    <strong class='h3'>Attention !!!<strong/><br><br>Cet étudiant existe déjà dans cette promotion. <br><br>Vérifier le matricule et autres champs s'ils n'existent pas déjà.
                                    <span class='bi bi-shield-exclamation'></span>
                                    </div>";
                            }
                        }else{
                            $msg="<div class='alert alert-warning text-center'>
                                <span class='bi bi-exclamation-triangle'></span>
                                <strong class='h3'>Attention !!!<strong/><br><br>Il existe déjà un étudiant avec ce même matricule <br><br>Vérifier le matricule et autres champs s'ils n'existent pas déjà.
                                <span class='bi bi-shield-exclamation'></span>";
                        }
                    }
                }
            }
        }
    }else{
        $msg="<div class='alert alert-danger text-center'>
            <span class='bi bi-x-octagon-fill'></span>
            <strong class='h3'>Attention !!!<strong/><br><br> Veuillez remplir tous les champs sans oublier de sélectionner une photo de l'étudiant !
            <span class='bi bi-x-lg'></span>
            </div>";
    }
?>
<!DOCTYPE HTML>
<html>
    <?php require_once "../../includes/head2.php"; ?>
    <body>
        <div class="container">
            <br><br>
            <?php
                echo $msg;
                header("refresh:5; url=liste-etudiants.php");
            ?>  
        </div>
    </body>
</html>