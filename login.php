<?php //Log In Function
		//Halaman log in hanya akan ditampilkan jika user belum melakukan login.
		//Untuk itu, cek apakah user sebelumnya telah melakukan login atau belum dengan fungsi berikut
		include 'check_logged.php';
		//Jika belum, maka tampilkan UI untuk halaman log in.
		include 'login/login.html';
?>
