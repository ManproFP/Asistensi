<?php
	session_start();
	if(isset($_POST["logout"])){
		if($_POST["logout"] == 1){
			$_SESSION["logged"]=0;
			session_destroy();
		}
	}
?>

<?php
		if(isset($_SESSION["logged"]))
		{
			if($_SESSION["logged"]==1)
			{
				header("Location: home.php");	
				exit();
			}
		}
		else{
				header("Location: login.php");	
				exit();
		}
?>