<?php
	session_start();
	if(isset($_SESSION["logged"])){
		if($_SESSION["logged"]==1){
			$_SESSION["logged"]=0;
			header("location: index.php");
			exit();
		}
	}
?>
