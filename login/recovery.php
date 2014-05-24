<?php //Error on Log In Function

	//Pastikan fungsi ini hanya dapat diakses saat user belum dan gagal saat melakukan upaya log in.
	include '../check_logged.php';
	//Jika user sudah login, user akan dialihkan pada halaman index. (Secara normal, halaman ini hanya akan muncul saat upaya login gagal dilakukan,
	//namun user juga dapat mengakses halaman ini secara manual sehingga dirasa perlu untuk melakukan handling)
	//**Pengalihan ditujukan ke halaman index karena umumnya index merupakan gerbang untuk melakukan pengalihan halaman,
	//  serta dapat juga digunakan sebagai beranda suatu website.

	//Tampilkan UI untuk halaman Log In Error.
	include 'recovery.html';
	include '../footer.php';
	echo "
	</div>
 </body>
</html>";
?>