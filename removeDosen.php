<?php
	include 'check_not_logged.php';

	if($_SESSION["type"] != 0){
		header('location: index.php');
	}
	else{
		include 'login/connect.php';
		$query = "DELETE FROM dosen WHERE dosen_id = ?";
		$stmt = $mysqli->prepare($query);
		echo $mysqli->error;
		$stmt->bind_param('s',$_POST["dosen_id"]);
		$stmt->execute();
		$stmt->close();

		$query = "DELETE FROM user WHERE user_id = ?";
		$stmt = $mysqli->prepare($query);
		echo $mysqli->error;
		$stmt->bind_param('s',$_POST["dosen_id"]);
		$stmt->execute();
		$stmt->close();

		echo "Perubahan sukses<br/><a href='setting.php'>Kembali</a>";
	}
?>