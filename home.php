<?php
	session_start();
	if(isset($_SESSION["logged"])){
		if($_SESSION["logged"]==0){
			header("location: index.php");
			exit();
		}	
	}
?>

<!DOCTYPE HTML>
<html>
 <head>
  <title>Dummy Beranda Asistensi UKDW</title>
 </head>

 <body>
	Welcome<br/>
	<a href="logout.php">Log Out</a>
 </body>
</html>