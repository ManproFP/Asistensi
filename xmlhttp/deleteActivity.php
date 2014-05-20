<?php
	session_start();
	if(!isset($_REQUEST["id"])){//id dibutuhkan untuk proses selanjutnya
		header("location: ../index.php");//Jika tidak ada, alihkan ke index.php
	}
	else{
		$waktu = $_REQUEST["id"];//tampung id ke dalam variabel PHP
		include '../login/connect.php';//Jika benar, buka koneksi ke database.
		$query = "DELETE FROM recent_activity WHERE waktu = ?";
		$stmt = $mysqli->prepare($query);
		echo $mysqli->error;
		$stmt->bind_param('s', $waktu);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
		exit();
	}
?>