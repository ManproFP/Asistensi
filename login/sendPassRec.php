<?php
	if(isset($_POST["user_id"])){
		$link = "";
		$mail_target = "";
		$user_id = $_POST["user_id"];
		include 'connect.php';
		$query = "SELECT password, user_type FROM user WHERE user_id = ?";
		//Gunakan statement mysqli hingga didapat halil yang dicari (Penjelasan sama seperti pada file confirm.php).
		$stmt = $mysqli->prepare($query);
		echo $mysqli->error;
		$stmt->bind_param('s', $user_id);
		$stmt->execute();
		$stmt->bind_result($password, $user_type);
		$stmt->store_result();
		$result = $stmt->fetch();
		if($stmt->num_rows == 1){//Jika tidak ada, tambahkan pada variabel informasi bahwa tidak ada matakuliah yang diampu
			if(!empty($result)){
				do{
					$link = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."/login/changePassword.php?key=".$password."&id=".$user_id;
					$type = $user_type;
				}while( $result = $stmt->fetch() );//Loop berlangsung selama masih ada baris yang dapat diambil dari hasil eksekusi statement
			}
		}
		$stmt->close();
		
		if($type == 1){
			$table = "dosen";
		}
		else if($type == 2){
			$table = "mahasiswa";
		}
		$query2 = "SELECT email FROM ".$table." WHERE user_id = ?";
		//Gunakan statement mysqli hingga didapat halil yang dicari (Penjelasan sama seperti pada file confirm.php).
		$stmt2 = $mysqli->prepare($query2);
		echo $mysqli->error;
		$stmt2->bind_param('s', $user_id);
		$stmt2->execute();
		$stmt2->bind_result($email);
		$stmt2->store_result();
		$result2 = $stmt2->fetch();
		if($stmt2->num_rows == 1){//Jika tidak ada, tambahkan pada variabel informasi bahwa tidak ada matakuliah yang diampu
			if(!empty($result2)){
				do{
					$mail_target = $email;
				}while( $result2 = $stmt2->fetch() );//Loop berlangsung selama masih ada baris yang dapat diambil dari hasil eksekusi statement
			}
		}
		$stmt2->close();
		$mysqli->close();

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/plain; charset=UTF-8' . "\r\n";
		$headers .= 'Content-Transfer-Encoding: base64' . "\r\n";
		$headers .= 'From: Asistensi UKDW <u915397415@srv2.main-hosting.eu>' . "\r\n";
		if($link != "" && $mail_target != ""){
			$subject = "Password Recovery";
			$message = "Silahkan klik link dibawah ini untuk mengganti password anda.\n\n".$link;
			mail($mail_target,$subject,$message,$headers);
		}
		header('Location: ../index.php');
	}
?>