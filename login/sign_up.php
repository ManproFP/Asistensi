<?php //Error on Log In Function

	//Pastikan fungsi ini hanya dapat diakses saat user belum dan gagal saat melakukan upaya log in.
	include '../check_logged.php';
	//Jika user sudah login, user akan dialihkan pada halaman index. (Secara normal, halaman ini hanya akan muncul saat upaya login gagal dilakukan,
	//namun user juga dapat mengakses halaman ini secara manual sehingga dirasa perlu untuk melakukan handling)
	//**Pengalihan ditujukan ke halaman index karena umumnya index merupakan gerbang untuk melakukan pengalihan halaman,
	//  serta dapat juga digunakan sebagai beranda suatu website.
		include 'connect.php';
		$user_id = $_POST["nim"];
		$nama = $_POST["nama"];
		$email = $_POST["email"];
		$no_hp = $_POST["no_hp"];
		if($_POST["gender"] == "1"){
			$gender = "Laki-laki";
		}
		else $gender = "Perempuan";
		$password = md5($_POST["password"]);

		$query = "INSERT INTO user (user_id, password, user_type) VALUE (? , ? , 2)";
		$stmt = $mysqli->prepare($query);
		echo $mysqli->error;
		$stmt->bind_param('ss',$user_id,$password);
		$stmt->execute();
		$stmt->close();

		$query2 = "INSERT INTO mahasiswa (nim, nama, user_id, email, no_hp) VALUE (? , ? , ? , ?, ?)";
		$stmt2 = $mysqli->prepare($query2);
		echo $mysqli->error;
		$stmt2->bind_param('sssss',$user_id,$nama,$user_id,$email,$no_hp );
		$stmt2->execute();
		$stmt2->close();

	//Tampilkan UI untuk halaman Log In Error.
	include 'sign_up.html';
	include '../footer.php';
	echo "
	</div>
 </body>
</html>";
?>