<?php //Not Logged Checking Function
		//Buka akses ke Session PHP
		session_start();
		//Cek apakah apakan variabel logged pada Session belum di set.
		if(!isset($_SESSION["logged"])){
			//Jika belum, berarti user belum melakukan login sehingga halaman tidak dapat ditampilkan dan dialihkan pada halaman index.
			//**Pengalihan ditujukan ke halaman index karena umumnya index merupakan gerbang untuk melakukan pengalihan halaman,
			//  serta dapat juga digunakan sebagai beranda suatu website.
			header("location: index.php");
			//exit current script.
			exit();	
		}
?>