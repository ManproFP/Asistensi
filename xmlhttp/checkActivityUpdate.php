<?php
	session_start(); //Buka sesi
	include '../login/connect.php'; //Akses DB
	$query = 'SELECT waktu FROM recent_activity ORDER BY waktu DESC'; //Query select semua ID pengumuman
	$stmt = $mysqli->prepare($query); //Siapkan statement mysqli
	echo $mysqli->error; // jika terjadi error, tampilkan pesan error;
	$stmt->execute(); //eksekusi statement
	$stmt->bind_result($waktu); //bind hasil search dalam variabel PHP
	$stmt->store_result(); //Simpan hasil pada local memory user
	$result = $stmt->fetch(); //ambil hasil eksekusi statement ke dalam variabel PHP

	// Cek ada berapa banyak baris yang dihasilkan dari pencarian
	if($stmt->num_rows == 0){//Jika tidak ada,
		echo "NO";
	}
	else{//Jika ada,
		$returned_note = "NO"; //siapkan variabel PHP untuk informasi update dengan default pesan "NO"
		if(!empty($result)){//pastikan variabel penampung hasil tidak kosong
			$counter=0;
			do{//Lakukan loop untuk mengakses hasil eksekusi statement perbarisnya
				$counter++;
				if($counter == 1){
					if($_SESSION["newer_activity"] != $waktu){
						$returned_note = "YES";
					}
				}
			}while( $result = $stmt->fetch() );//Loop berlangsung selama hasil eksekusi statement masih bisa di fetch
			if($counter != $_SESSION["number_of_activity"]){
				$returned_note = "YES";
			}
		}
	}
	$stmt->close();//tutup statement
	$mysqli->close();//tutup koneksi ke DB
	
	echo $returned_note; //Kirim variabel yang berisi YES atau NO ke fungsi pemanggil
?>