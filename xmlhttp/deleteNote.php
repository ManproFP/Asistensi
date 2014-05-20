<?php
	session_start();
	if(!isset($_REQUEST["id"])){//id dibutuhkan untuk proses selanjutnya
		header("location: ../index.php");//Jika tidak ada, alihkan ke index.php
	}
	else{
		$note_id = $_REQUEST["id"];//tampung id ke dalam variabel PHP
		
		//Cek, variabel note_id haruslah bertipe int
		if(null != ($note_id = filter_var($note_id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE))){
			include '../login/connect.php';//Jika benar, buka koneksi ke database.

			$query = "DELETE FROM pengumuman WHERE note_id = ?";
			$stmt = $mysqli->prepare($query);
			echo $mysqli->error;
			$stmt->bind_param('i', $note_id);
			$stmt->execute();
			$stmt->close();
			$mysqli->close();
			exit();
		
		}
		else{
			header("location: ../index.php");//Jika salah, alihkan ke index.php
		}
	}
?>