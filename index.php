<?php //Action on Log Out Function
		//Buka Akses ke Session PHP agar setiap variabel pada Session yang telah terset siap untuk digunakan.
		session_start();
		//cek apakah halaman ini dipanggil dengan mengeset variabel $_POST["logout"]==1.
		if(isset($_SESSION["logout"]) && $_SESSION["logout"]==1){
			//Jika ya, berarti halaman ini dipanggil setelah user melakukan logout.
			//Unset semua variabel pada Session yg telah di set sebelumnya.
			session_unset();
			//Hapus keseluruhan Session yang ada, dengan demikian user akan diwajibkan untuk melakukan login.
			//**Pembuatan ulang suatu Session akan dilakukan saat user berhasil login.
			session_destroy();
		}
?>

<?php //Action on Logged Function
		//Cek apakah variabel $_SESSION["logged"] telah terset dan nilainya == 1.
		if(isset($_SESSION["logged"]) && $_SESSION["logged"]==1)
		{
			//Jika ya, berarti user telah melakukan login sebelumnya, maka alihkan user ke halaman home.
			header("Location: home.php");
			//exit current script.
			exit();
		}
		//Jika tidak, berarti user belum melakukan log in.
		else{
			//Alihkan user pada halaman log in.
			header("Location: login.php");	
			//exit current script.
			exit();
		}
?>