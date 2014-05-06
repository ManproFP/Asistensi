<?php //Database Connect Function
	//Nama server MySQL Database
	$server = "localhost";
	//Username MySQL Database
	$username = "root";
	//password MySQL Database
	$password = "";
	//Nama database yang digunakan pada MySQL Database
	$database = "manpro_fp";
	
	//Percobaan koneksi ke MySQL Database
	$mysqli = new mysqli($server, $username, $password, $database)
		//Pesan untuk koneksi gagal.
		or die ("Gagal Koneksi");
?>
