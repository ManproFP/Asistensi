<?php
	session_start();
	if(isset($_SESSION["logged"])){
		if($_SESSION["logged"]==1){
			header("location: index.php");
			exit();
		}	
	}
	include 'login/login.html';
?>
