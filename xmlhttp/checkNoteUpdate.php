<?php
	session_start(); //Buka sesi
	include '../login/connect.php'; //Akses DB
	$query = 'SELECT note_id, isi FROM pengumuman ORDER BY note_id DESC'; //Query select semua ID pengumuman
	$stmt = $mysqli->prepare($query); //Siapkan statement mysqli
	echo $mysqli->error; // jika terjadi error, tampilkan pesan error;
	$stmt->execute(); //eksekusi statement
	$stmt->bind_result($retreived_id, $retreived_content); //bind hasil search dalam variabel PHP
	$stmt->store_result(); //Simpan hasil pada local memory user
	$result = $stmt->fetch(); //ambil hasil eksekusi statement ke dalam variabel PHP

	// Cek ada berapa banyak baris yang dihasilkan dari pencarian
	if($stmt->num_rows == 0){//Jika tidak ada,
		echo "NO";
	}
	else{//Jika ada,
		$returned_note = "NO"; //siapkan variabel PHP untuk informasi update dengan default pesan "NO"
		if(!empty($result)){//pastikan variabel penampung hasil tidak kosong
			$iterator = 0; //Siapkan variabel iterator;
			do{//Lakukan loop untuk mengakses hasil eksekusi statement perbarisnya
				$array = array($retreived_id,$retreived_content); //siapkan array untuk menampung note_id dan isi pada baris yang sedang diakses
				if($iterator == 0){//untuk akses kali pertama,
					$array_of_retreived_note = array($array); //buat var array note untuk menampung array sebelumnya
				}
				else{//Untuk kali berikutnya,
					array_push($array_of_retreived_note,$array); //push array ke dalam array note
				}
				
				$iterator++; //Lakukan increment untuk iterator
			}while( $result = $stmt->fetch() );//Loop berlangsung selama hasil eksekusi statement masih bisa di fetch
			
			$number_of_retreived_note = $iterator; //Tampung jumlah hasil yang didapat kedalam variabel

			//Proses pengecekan ada tidaknya update
			//Step 1. Bandingkan jumlah hasil yang didapat saat ini dengan jumlah hasil pada sesi yang telah disimpan sebelumnya
			if(!isset($_SESSION["number_of_displayed_note"])){//Jika sesi yang dimaksud belum diset
				$returned_note = "YES"; //Berarti terdapat update pada pengumuman (Sesi yang dimaksud tidak di set berarti sebelumnya tidak ada pengumuman)
			}
			else if($_SESSION["number_of_displayed_note"] != $number_of_retreived_note){//{//Jika sudah diset, bandingkan nilai kedua variabel
					$returned_note = "YES"; //Jika nilai tidak sama, berarti terdapat update pada pengumuman.
			}
			//Step 2. Bandingkan isi dari hasil yang didapat saat ini dengan hasil pada sesi yang disimpan sebelumnya
			else{
				$i = 0;
			   for($i; $i < $number_of_retreived_note; $i++){//buat loop sebanyak jumlah baris pada array
			      $j = 0;
				  for($j; $j < 2; $j++){//buat loop sebanyak jumlah kolom pada array
					if($_SESSION["list_of_displayed_note"][$i][$j] != $array_of_retreived_note[$i][$j]){//j==0 Membandingkan id, j==1 membandingkan isi
						$returned_note = "YES"; //Ketidaksamaan nilai pada kedua variabel berarti terdapat update pada pengumuman
						break;
					}
			      }
			   }
			}
			//$returned_note = $_SESSION["number_of_displayed_note"]."<br/>".$_SESSION["list_of_displayed_note"];
		}
	}
	$stmt->close();//tutup statement
	$mysqli->close();//tutup koneksi ke DB
	
	echo $returned_note; //Kirim variabel yang berisi YES atau NO ke fungsi pemanggil
?>