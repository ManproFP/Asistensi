<?php
	include 'check_not_logged.php';

	if($_SESSION["type"] != 0){
		header('location: index.php');
	}
	else{
		if(isset($_POST["verivy"])){
		  if(get_magic_quotes_gpc()){
			$_POST = array_map('stripslashes',$_POST);
		  }
		  $plain_password = $_POST["verivy"];
		  $user_id = $_SESSION["user_id"];
			
		  include 'login/connect.php';

		  $plain_password = $mysqli->real_escape_string($plain_password);
		  $password = md5($plain_password);
		  
		  $query = "SELECT user_id, user_type FROM user WHERE user_id =? and password =?";
		  $stmt = $mysqli->prepare($query);
		  echo $mysqli->error;
		  $stmt->bind_param('ss', $user_id, $password);
		  $stmt->execute();
		  $stmt->bind_result($user_id, $type);
		  $stmt->store_result();
		  
		  $result = $stmt->fetch();
		  if($stmt->num_rows == 1){
			$query2 = "DELETE FROM jadwal";
			$stmt2 = $mysqli->prepare($query2);
			echo $mysqli->error;
			$stmt2->execute();
			$stmt2->close();
			$stmt->close();
		    $mysqli->close();
			echo "Jadwal Asistensi berhasil direset.<br/><a href='setting.php'>Kembali</a>";
		  }
		  else{
			$stmt->close();
			$mysqli->close();
			echo "Password Anda tidak tepat.<br/><a href='setting.php'>Kembali</a>";
		  }
		}
		else{
			echo "Password tidak boleh kosong<br/><a href='setting.php'>Kembali</a>";
		}
	}
?>