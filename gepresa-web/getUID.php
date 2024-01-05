<?php
	// if (!isset($_SESSION['type'])) {
	// 	header("Location:404.php");
	// } else{
		if (isset($_POST)) {
			$UIDresult=$_POST["cardid"];
			$salle = $_POST['salle'];

			$Write="<?php $" . "UIDresult='" . $UIDresult . "'; " . "echo $" . "UIDresult;" . " ?>";
			file_put_contents('showID.php',$Write);
			include "get-info.php";
		}
	// }
?>