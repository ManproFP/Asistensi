<?php //Logged Checking Function
		//Buka akses ke Session PHP
		session_start();
		//Cek apakah apakan variabel logged pada Session telah terset dan nilainya == 1.
		if(isset($_SESSION["logged"]) && $_SESSION["logged"]==1){
			//Jika sudah, berarti user tidak lagi perlu melakukan log in, maka alihkan user pada halaman index.
			//**Pengalihan ditujukan ke halaman index karena umumnya index merupakan gerbang untuk melakukan pengalihan halaman,
			//  serta dapat juga digunakan sebagai beranda suatu website.
			header("location: index.php");
			//exit current script.
			exit();	
		}
?>