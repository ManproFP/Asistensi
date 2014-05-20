<?php //Log Out Function
		//Buka akses ke Session PHP
		session_start();
		//set variabel logout dengan nilai 1.
		$_SESSION["logout"]=1;
		//alihkan ke halaman index untuk proses lebih lanjut.
		header("location: index.php");
		//exit current script.
		exit();
?>
