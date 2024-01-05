<?php
    require_once "includes/functions.php";

    $db = db_connection();
    
    if (!empty($_POST['cardID'])) {
        $cardUID = $_POST['cardID'];

        $req = $db->query("SELECT * FROM Etudiants WHERE cardUID ='$cardUID'");
        if ($req->rowCount() > 0) {
        echo "1";
        }else{
            $req = $db->query("SELECT * FROM Surveillants WHERE cardID = '$cardUID'");
                
            if ($req->rowCount() > 0) {
                echo "2";
            }else{
                echo "0";
            }
        }
    }

    if (!empty($_POST['cardID1']) && !empty($_POST['id'])) {
        $cardUID = $_POST['cardID1'];
        $id = $_POST['id'];

        $req = $db->query("SELECT * FROM Etudiants WHERE cardUID ='$cardUID' AND id <> $id");
        if ($req->rowCount() > 0) {
        echo "1";
        }else{
            $req = $db->query("SELECT * FROM Surveillants WHERE cardID = '$cardUID'");
                
            if ($req->rowCount() > 0) {
                echo "2";
            }else{
                echo "0";
            }
        }
    }

    if (!empty($_POST['cardID2']) && !empty($_POST['id'])) {
        $cardUID = $_POST['cardID1'];
        $id = $_POST['id'];

        $req = $db->query("SELECT * FROM Etudiants WHERE cardUID ='$cardUID'");
        if ($req->rowCount() > 0) {
        echo "1";
        }else{
            $req = $db->query("SELECT * FROM Surveillants WHERE cardID = '$cardUID' AND id <> $id");
                
            if ($req->rowCount() > 0) {
                echo "2";
            }else{
                echo "0";
            }
        }
    }
?>