<?php //Logged Confirmation Function
		//Halaman ini hanya dapat diakses setelah user melakukan log in terlebih dahulu.
		//Untuk itu perlu dilakukan pengecekan dengan memanggil fungsi berikut.
		include 'check_not_logged.php'; //
		//**Pemanggilan fungsi di atas juga dimaksudkan agar variabel yang ada pada Session PHP siap untuk digunakan.
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