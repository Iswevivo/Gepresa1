<?php
    require_once "includes/functions.php";

    $login = isset($_POST['login']) ? $_POST['login'] : "";
    $password = isset($_POST['pass']) ? trim(htmlspecialchars($_POST['pass'])) : "";

    if(isset($_POST['btn-submit'])){
        if(!empty($login) && !empty($password)){
            $db = db_connection();
            $req = $db->prepare("SELECT * FROM Users WHERE login =?");
            $req->execute(array($login));
            $res = $req->fetch(PDO::FETCH_ASSOC);

            if ($res) {
                if (password_verify($password, $res['password'])) {
                    if ($res['statut'] == 1) {
                        session_start();
                        $_SESSION['auth'] = true;
                        $_SESSION['id'] = $res['id'];
                        $_SESSION['type'] = $res['role'];
                        $_SESSION['username'] = $res['login'];

                        if ($_SESSION['type'] == 'Admin' || $_SESSION['type'] == 'SUPER ADMIN') {
                            header("Location:Admin/");
                        }elseif($_SESSION['type'] == 'Section' || $_SESSION['type'] == 'Jury') {
                            header("Location:Section/");
                        }else{
                            $msg = "<div class='alert alert-danger'>Ulisateur inconnu.</div>";
                        }
                    }else {
                        $msg = "<div class='alert alert-warning'>Désolé, Votre compte est désactivé ! Veuillez contacter l'Administrateur pour son activation.</div>";
                    }
                }else {
                    $msg = "<div class='alert alert-warning'>Mot de passe incorrect.</div>";
                }
            }else {
                $msg = "<div class='alert alert-warning'>Username invalide</div>";
            }
        }else {
            $msg = "<div class='alert alert-danger'>Vous devez remplir tous les champs !</div>";
        }
    }
?>