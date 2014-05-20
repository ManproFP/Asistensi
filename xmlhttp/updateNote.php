<?php
	session_start();
	if(!isset($_REQUEST["id"]) || !isset($_REQUEST["note"])){//id dibutuhkan untuk proses selanjutnya
		header("location: ../index.php");//Jika tidak ada, alihkan ke index.php
	}
	else{
		//tampung id dan note ke dalam variabel PHP
		$note_id = $_REQUEST["id"];
		$isi = $_REQUEST["note"];

		//Cek, variabel note_id haruslah bertipe int
		if(null != ($note_id = filter_var($note_id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE))){
			include '../login/connect.php';//Jika benar, buka koneksi ke database.

			$query = "UPDATE pengumuman SET isi = ? WHERE note_id = ?";
			$stmt = $mysqli->prepare($query);
			echo $mysqli->error;
			$stmt->bind_param('si', $isi, $note_id);
			$stmt->execute();
			$stmt->close();
			$mysqli->close();

			echo $isi;
			exit();
		}
		else{
			header("location: ../index.php");//Jika salah, alihkan ke index.php
		}
	}
?>