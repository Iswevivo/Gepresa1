<?php 

    require_once "../../includes/functions.php";
    $db = db_connection();

    $id = isset($_POST['id']) ? $_POST['id']:"";
    $cardID = isset($_POST["cardUID1"]) ? $_POST["cardUID1"]:"";
    $nom = isset($_POST['nom']) ? strtoupper($_POST['nom']):"";
    $postnom = isset($_POST['postnom']) ? strtoupper($_POST['postnom']):"";
    $prenom = isset($_POST['prenom']) ? ucfirst(strtolower($_POST['prenom'])):"";
    $sexe = isset($_POST['sexe']) ? ($_POST['sexe']):"";
    $matricule = isset($_POST['matricule']) ? ($_POST['matricule']):"";
    $promotion = isset($_POST['promotion']) ? ($_POST['promotion']):"";
    $photo_name = isset($_FILES['photo'])? $_FILES['photo']['name'] :"";
    $photo_path = isset($_FILES['photo']['tmp_name'])? $_FILES['photo']['tmp_name'] :"";

    if(!empty($matricule) && !empty($nom) && !empty($postnom) && !empty($promotion)) {

        if(!empty($photo_name) && !empty($photo_path)){
            if ($_FILES['photo']['size']>15000000) {
                $msg= "<div class='bg-warning text-white'>Erreur lors du téléchargement du fichier car le fichier dépasse la taille maximale recommandée ! <br> La pièce jointe doit être une image de 15Mo maximale.</div>";
            }else{
                $extensions_autorisees= array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
                $ext_fichier= $_FILES['photo']['type'];
                
                if (!in_array($ext_fichier, $extensions_autorisees)) {
                    $msg= "<div class='bg-warning text-white'>Le fichier choisi est d'un format non autorisé! Seules les extensions suivantes sont autorisée: .jpg, .jpeg, .png, .gif</div>";
                }else{
                    $picture = true;
                }
            }
        }

        if (!empty($cardID)) {

            $req = $db->query("SELECT * FROM Etudiants WHERE cardUID ='$cardID' AND id <> $id");

            if ($req->rowCount() > 0) {
                $msg = "<div class='alert bg-danger text-white text-center'><span class='bi bi-x-octagon-fill'></span>  Ce numéro de carte est déjà attribué à un autre étudiant.</div>";

            }else{
                $req = $db->query("SELECT * FROM Surveillants WHERE cardID = '$cardID'");
                    
                if ($req->rowCount() > 0) {
                    $msg = "<div class='alert bg-danger text-white trext-center'><span class='bi bi-x-circle-fill'></span>  Ce numéro de carte est déjà attribué à un surveillant.</div>";
                }else{
                    if(getStudentByMatricule($matricule)===false || (getStudentByMatricule($matricule)['matricule'] != $matricule OR getStudentByMatricule($matricule)['id'] == $id)){
                        
                        if(isset($picture)){
                            $query = $db->prepare("UPDATE `Etudiants`SET nom=?, postnom=?, prenom=?, sexe=?, matricule=?, promotion_ID=?, photo=?, cardUID=? WHERE id=?");
                            $params=array($nom, $postnom, $prenom, $sexe, $matricule, $promotion, $photo_name, $cardID, $id);
                            move_uploaded_file($photo_path, "../../assets/img/students/$photo_name");
                        }else{
                            $query = $db->prepare("UPDATE `Etudiants`SET nom=?, postnom=?, prenom=?, sexe=?, matricule=?, promotion_ID=?, cardUID=? WHERE id=?");
                            $params=array($nom, $postnom, $prenom, $sexe, $matricule, $promotion, $cardID, $id);
                        }         
                        
                        $resultat = $query->execute($params);
                
                        if ($resultat){
                            $msg="<div class='alert alert-success text-center'>
                            <strong class='h3'>Felicitation!<strong/><br><br> Modification effectuée.</div>";
                        }
                    }else{          
                        $msg="<div class='alert alert-warning text-center'>
                        <strong class='h3'>Alerte : Ce matricule est déjà attribué à un autre étudiant; impossible donc de le donner à un autre. <strong/></div>";
                    }
                }
            }
        }else{
            if(getStudentByMatricule($matricule)===false || (getStudentByMatricule($matricule)['matricule'] != $matricule OR getStudentByMatricule($matricule)['id'] == $id)){
                
                if(isset($picture)){
                    $query = $db->prepare("UPDATE `Etudiants`SET nom=?, postnom=?, prenom=?, sexe=?, matricule=?, promotion_ID=?, photo=? WHERE id=?");
                    $params=array($nom, $postnom, $prenom, $sexe, $matricule, $promotion, $photo_name, $id);
                    move_uploaded_file($photo_path, "../../assets/img/students/$photo_name");
                }else{
                    $query = $db->prepare("UPDATE `Etudiants`SET nom=?, postnom=?, prenom=?, sexe=?, matricule=?, promotion_ID=? WHERE id=?");
                    $params=array($nom, $postnom, $prenom, $sexe, $matricule, $promotion, $id);
                }

                $resultat = $query->execute($params);
                
                if ($resultat){
                    $msg="<div class='alert alert-success text-center'>
                    <strong class='h3'>Felicitation!<strong/><br><br> Modification effectuée.</div>";
                }

            }else{          
                $msg="<div class='alert alert-warning text-center'>
                <strong class='h3'>Alerte : Ce matricule est déjà attribué à un autre étudiant; impossible donc de le donner à un autre. <strong/></div>";
            }
        }
    }else {
        $msg="<div class='alert alert-warning text-center'>
        <strong class='h3'>Echec de modification : <strong/><br><br> veuillez remplir les champs vides.</div>";
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