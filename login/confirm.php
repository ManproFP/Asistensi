<?php
	session_start();
	if(isset($_SESSION["logged"])){
		if($_SESSION["logged"]==1){
			header("location: ../home.php");
			exit();
		}
	}
?>
				
<?php
	if(isset($_POST["user_id"]) && $_POST["user_id"]!="" && isset($_POST["pass"]) && $_POST["pass"]!="")
	{
		include('connect.php');
		$user_id = $_POST["user_id"];
		$plain_password = $_POST["pass"];
		$type = '';

		$user_id = stripslashes($user_id);
		$plain_password = stripslashes($plain_password);
		$user_id = $mysqli->real_escape_string($user_id);
		$plain_password = $mysqli->real_escape_string($plain_password);
		
		$password = md5($plain_password);

		$query = "SELECT user_id, password, user_type FROM user WHERE user_id =? and password =?";

		$stmt = $mysqli->prepare($query);
		echo $mysqli->error;
		$stmt->bind_param('ss', $user_id, $password);
		$stmt->execute();
		$stmt->bind_result($user_id, $passord, $type);
		$stmt->store_result();

		$result = $stmt->fetch();

		if($stmt->num_rows == 1){
			$_SESSION["logged"] = '1';
			if( !empty( $result ))
			{
				do{
			        $_SESSION["user_id"] = $user_id;
					$_SESSION["type"] = $type;
			    } while( $result = $stmt->fetch() ); 
			}
			$stmt->close();
			
			/*$query2 = "SELECT full_name, nick_name FROM user WHERE user_id =?";
			$stmt2 = $mysqli->prepare($query2);
			$stmt2->bind_param('i', $username);
			$stmt2->execute();
			$stmt2->bind_result($full_name, $nick_name);
			$stmt2->store_result();

			$result2 = $stmt2->fetch();

			if($stmt2->num_rows == 1){
				if( !empty( $result2 ))
				{
					do{
				        $_SESSION["full_name"] = $full_name;
						$_SESSION["nick_name"] = $nick_name;
				    } while( $result2 = $stmt2->fetch() ); 
				}
			}
			$stmt2->close();*/
					
			header("location: ../home.php");
			exit();
		}
		else{
			header("location: error.php");
		}
				
		$stmt->close();
		$mysqli->close();
	}
	else{
			header("location: error.php");
	}
?>