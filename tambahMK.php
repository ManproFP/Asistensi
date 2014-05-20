<?php
	include 'check_not_logged.php';

	if($_SESSION["type"] != 0){
		header('location: index.php');
	}
	else{
		include 'login/connect.php';

		$query2 = "INSERT INTO matakuliah (nama, mk_id, sks) VALUE (? , ? , ?)";
		$stmt2 = $mysqli->prepare($query2);
		echo $mysqli->error;
		$stmt2->bind_param('sss',$_POST["nama"],$_POST["mk_id"],$_POST["sks"]);
		$stmt2->execute();
		$stmt2->close();

		echo "Perubahan sukses<br/><a href='setting.php'>Kembali</a>";
	}
?>