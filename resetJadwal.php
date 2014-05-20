<?php
	include 'check_not_logged.php';

	if($_SESSION["type"] != 0){
		header('location: index.php');
	}
	else{
		include 'login/connect.php';
		$query = "DELETE FROM jadwal";
		$stmt = $mysqli->prepare($query);
		echo $mysqli->error;
		$stmt->execute();
		$stmt->close();

		echo "Perubahan sukses<br/><a href='setting.php'>Kembali</a>";
	}
?>