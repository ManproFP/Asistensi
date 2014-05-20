<?php //Log In Verification Function

	//Sertakan fungsi untuk mengecek apakah user telah login atau belum.
	include '../check_logged.php';
	//Jika sudah, berarti fungsi Verifikasi Log In ini tidak perlu dilakukan dan  user akan dialihkan pada halaman index.
	//**Pengalihan ditujukan ke halaman index karena umumnya index merupakan gerbang untuk melakukan pengalihan halaman,
	//  serta dapat juga digunakan sebagai beranda suatu website.

	//Cek apakah user telah mengisi user id serta password pada form login yang disediakan.
	if(isset($_POST["user_id"]) && $_POST["user_id"]!="" && isset($_POST["pass"]) && $_POST["pass"]!="")
	{
		//Hubungkan sistem ke database untuk proses confirmasi login.
		include('connect.php');
		//Simpan inputan user sebelumnya dalam variabel php
		$user_id = $_POST["user_id"];
		$plain_password = $_POST["pass"];
		//siapkan variabel type untuk nantinya menyimpan tipe user (type: 0=Admin, 1=Dosen, 2=Mahasiswa).
		$type = '';
		
		//Untuk alasan keamanan pada database, dilakukan proses berikut.

		//Umumnya, fitur magic_quotes pada php.ini di set enable secara default, sehingga server akan menambahkan
		//fungsi addslashes() secara otomatis pada setiap nilai yang di submit melalui GET, POST, maupun cookies.
		if(get_magic_quotes_gpc()){
			//Jika fitur magic_quotes on, maka hapus semua backslash yang secara otomatis ditambahkan oleh fungsi addslashes()
			$_POST = array_map('stripslashes',$_POST); //Melakukan fungsi stripslashes untuk semua variabel pada array POST
		}

		//Selanjutnya, gunakan fungsi mysql real escape string agar karakter spesial seperti quote('), double quote("), \n, \r, \x00
		//dapat diproses secara aman pada query mysql.
		//** Dulunya, digunakan fungsi addslashes() untuk tujuan serupa, namun fungsi tersebut masih terdapat celah untuk terjadinya SQL Injection
		$user_id = $mysqli->real_escape_string($user_id);
		$plain_password = $mysqli->real_escape_string($plain_password);
		
		//Convert plain pasword menggunakan fungsi md5, karena password yang disimpan pada database adalah password yang telah dikonvert dalam bentuk md5.
		$password = md5($plain_password);
		
		//Query yang akan digunakan sebagai statement mysqli
		//** Query menggunakan variabel yang terikat sebagai parameter pada statement demi tujuan keamanan.
		$query = "SELECT user_id, password, user_type FROM user WHERE user_id =? and password =?"; // '?' adalah parameter pada statement.
		
		//Siapkan statement mysqli dengan query sebelumnya.
		$stmt = $mysqli->prepare($query); //$stmt berupa objek
		//Jika statement error, tampilkan pesan error yang ada (Hanya untuk keperluan developing, hapus saat final release).
		echo $mysqli->error;
		//Ikatkan variabel yang di butuhkan sebagai parameter pada statement untuk menggantikan '?' pada query.
		$stmt->bind_param('ss', $user_id, $password); // tipe variabel harus sesuai, i = integer, d = double, s= string, b = blob.
		//Eksekusi query yang telah disiapkan pada statement.
		$stmt->execute();
		//ikatkan set hasil eksekusi statement ke dalam variabel php, jumlah variabel harus sama dengan jumlah hasil yang diberikan.
		$stmt->bind_result($user_id, $password, $type);
		//Transfer set hasil eksekusi statement tadi agar ter'buffer' pada client untuk dapat di 'fetch'.
		$stmt->store_result();
		
		//Ambil set hasil eksekusi yang telah di buffer tadi, dan simpan ke dalam variabel $result.
		$result = $stmt->fetch(); //Variabel berupa Boolean
		
		//Cek apakah set hasil dari statement tadi hanya terdapat 1 baris.
		//** Jika kurang dari 1 baris, berarti tidak ada hasil yang ditemukan.
		//** Jika lebih dari 1 baris, maka terjadi kesalahan dalam proses pencarian karena user_id yang adalah Primary Key bersifat UNIK.
		if($stmt->num_rows == 1){
			//Jumlah baris == 1 berarti ditemukan tepat 1 pasangan user_id dan password yang cocok dengan inputan user.
			$_SESSION["logged"] = '1'; //Set variabel logged pada Session dengan nilai 1 (User berhasil login).
			//pastikan variabel $result yang akan di fetch (di ambil/ dikeluarkan isinya) tidak kosong.
			if( !empty( $result ))
			{
				//Lakukan looping hingga set hasil tidak dapat lagi di fetch (dalam hal ini, karena num_rows==1, maka loop hanya berjalan 1x).
				do{
					//Untuk keperluan lebih lanjut,
					//set variabel user_id pada Session dengan nilai variabel $user_id.
			        $_SESSION["user_id"] = $user_id; //Umumnya, variabel penampung berupa array jika loop lebih dari 1 kali.
					//Set variabel type pada Session dengan nilai variabel $type.
					$_SESSION["type"] = $type;
			    } while( $result = $stmt->fetch() ); // True jika data berhasil di fetch, False jika terjadi error, NULL jika tidak lagi terdapat baris/data.
			}
			//Tutup statement 1 untuk membebaskan 'resource' yang telah digunakan.
			$stmt->close();

			//Selain variabel user_id dan type pada session, juga diperlukan variabel name yang terdapat pada tabel mahasiswa / dosen / koordinator
			//tergantung dari tipe user tersebut. Variabel-variabel tersebut akan dibutuhkan selama user tersebut terlogin ke dalam website.
			//Untuk mendapatkan nama, pertama-tama dibutuhkan tabel yang sesuai dengan tipe user.
			
			//Switch type yang didapat dari hasil eksekusi sebelumnya dengan tipe yang bersesuaian.
			switch($type){
				case 0: $table = "koordinator"; 
						$id = "koor_id"; //var as string
						break;
				case 1: $table = "dosen";
						$id = "dosen_id"; //var as string
						break;
				case 2: $table = "mahasiswa";
						$id = "nim"; //var as integer
						break;
				default: $table = "unidentified";
						$id = "unidentified";
						break;
			} //** 0 sebagai koordinator maupun 2 sebagai mahasiswa telah ditentukan sebelumnya saat proses pembuatan database sehingga mengganti
			  //** switch-case yang telah ada ini memerlukan penyesuaian pada database yang ada.
			
			//query kedua untuk statement 2 dengan parameter untuk mencari nama user.
			$query2 = "SELECT nama FROM ".$table." WHERE user_id =?";
			//siapkan objek statement 2 dari query tadi
			$stmt2 = $mysqli->prepare($query2);
			//Ikatkan variabel yang bersesuaian dengan parameter yang diminta (untuk mengganti '?' pada query).
			$stmt2->bind_param('s', $user_id);
			//Eksekusi statement 2 dengan parameter yang telah siap
			$stmt2->execute();
			//Ikatkan set hasil eksekusi ke dalam variabel php (harus berjumlah sama).
			$stmt2->bind_result($full_name);
			//Transfer set hasil agar dapat di fetch yaitu dengan di'buffer' oleh client
			$stmt2->store_result();
			
			//Fetch statement 2 ke dalam variabel result2
			$result2 = $stmt2->fetch();
			
			//pastikan hasil yang ditemukan hanya ada satu (karena metode pencarian menggunakan user_id yang adalah UNIK).
			if($stmt2->num_rows == 1){
				//jika $result2 tidak kosong
				if( !empty( $result2 ))
				{
					//lakukan loop untuk mengambil isi set hasil.
					do{
						//Set variabel full_name pada Session dengan nama yang ditemukan dari hasil pencarian.
				        $_SESSION["full_name"] = $full_name;
					//fetch kembali statement ke dalam $result2 (karena hanya ada 1 baris hasil, loop hanya berjalan 1x)
				    } while( $result2 = $stmt2->fetch() ); //Jika tidak ada lagi baris/data, maka fetch akan mereturn NULL, loop berhenti.
				}
			}
			//tutup statement 2 untuk melepas 'resource' yang telah digunakan.
			$stmt->close();
			
			//Proses login selesai, data pada Session telah siap, alihkan user pada halaman home untuk memulai jelajahnya di website assistensi ukdw
			header("location: ../home.php");
			//Exit current script.
			exit();
		}
		
		//Jika hasil pencarian pasangan user_id dan password tidak sama dengan 1,
		else{
			//Tutup statement 1 untuk membebaskan 'resource' yang telah digunakan.
			$stmt->close();
			//alihkan user pada fungsi yang meng'handle' error saat log in.
			header("location: error.php");
		}
		
		//Tutup koneksi pada database.
		$mysqli->close();
	}

	//Jika form isian user_id atau password ada yang kosong
	else{
			//alihkan user pada fungsi yang meng'handle' error saat log in.
			header("location: error.php");
	}
?>