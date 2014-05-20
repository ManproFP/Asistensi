<?php
	include 'check_not_logged.php';

	if($_SESSION["type"] != 0){
		header('location: index.php');
	}
	else{
		include 'login/connect.php';
		$password = md5($_POST["password"]);
		$query = "INSERT INTO user (user_id, password, user_type) VALUE (? , ? , 1)";
		$stmt = $mysqli->prepare($query);
		echo $mysqli->error;
		$stmt->bind_param('ss',$_POST["dosen_id"],$password);
		$stmt->execute();
		$stmt->close();

		$query2 = "INSERT INTO dosen (nama, dosen_id, email, user_id) VALUE (? , ? , ? , ?)";
		$stmt2 = $mysqli->prepare($query2);
		echo $mysqli->error;
		$stmt2->bind_param('ssss',$_POST["nama"],$_POST["dosen_id"],$_POST["email"],$_POST["dosen_id"] );
		$stmt2->execute();
		$stmt2->close();

		echo "Perubahan sukses<br/><a href='setting.php'>Kembali</a>";
	}
?>