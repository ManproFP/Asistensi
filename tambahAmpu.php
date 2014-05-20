<?php
	include 'check_not_logged.php';

	if($_SESSION["type"] != 0){
		header('location: index.php');
	}
	else{
		include 'login/connect.php';

		$query2 = "INSERT INTO ampu (dosen_id, mk_id) VALUE (? , ?)";
		$stmt2 = $mysqli->prepare($query2);
		echo $mysqli->error;
		$stmt2->bind_param('ss',$_POST["dosen_id"],$_POST["mk_id"]);
		$stmt2->execute();
		$stmt2->close();

		echo "Perubahan sukses<br/><a href='setting.php'>Kembali</a>";
	}
?>