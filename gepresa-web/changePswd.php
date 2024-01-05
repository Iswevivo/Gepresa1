<?php 
    session_start();
    if (!isset($_SESSION['auth'])) {
        header("Location:404.php");
    }
    require_once "includes/functions.php";

    $user_id = $_SESSION['id'];
    $login = $_SESSION['username'];
    $oldPass = isset($_POST['password']) ? $_POST['password'] : "";
    $newPass = isset($_POST['newpassword']) ? $_POST['newpassword'] : "";
    $confirmPass = isset($_POST['renewpassword']) ? $_POST['renewpassword'] : "";

    if (!empty($oldPass) && !empty($newPass) && !empty($confirmPass)) {
        if(getUserById($user_id) == true){
            $db = db_connection();
            $query = $db->prepare("SELECT * FROM Users WHERE login=?");
            $query->execute(array($login));
            $res = $query->fetch(PDO::FETCH_ASSOC);
    //  die(var_dump($res));
            if (!empty($res['password'])) {
                if (password_verify($oldPass, $res['password'])) {
                    if(strcmp($oldPass, $newPass) !==0 ){
                        if (strcmp($newPass, $confirmPass) === 0) {
                            $query = $db->prepare("UPDATE Users SET password =? WHERE id=?");
                            $update = $query->execute(array(password_hash($newPass, PASSWORD_BCRYPT), $user_id));

                            if ($update) {
                                $success = "<div class='alert alert-success m-5 fw-bolder'>Votre mot de passe a été modifié avec succès! Vous serez déconnecté dans quelques instants afin de pouvoir vous connecter dores et déjà avec le nouveau mot de passe.</div>";
                            }else{
                                header("Location:user-profile.php?m=7");
                            }
                        }else{
                            header("Location:user-profile.php?m=6");
                        } 
                    }else{
                        header("Location:user-profile.php?m=5");
                    }      
                } else {
                    header("Location:user-profile.php?m=4");
                }
            } else {
                header("Location:user-profile.php?m=3");
            }
        }else {
            header("Location:user-profile.php?m=2");
        }
    } else {
        header("Location:user-profile.php?m=1");
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.php"; ?>
<body>
    <div class="container m-5 p-2 h2 text-center">
        <?php 
            if(!empty($success)){
                echo $success;
                header("refresh:5; url=logout.php");
            }
        ?>
    </div>
</body>
</html>