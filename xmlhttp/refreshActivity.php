<?php
	session_start(); //Buka sesi
	$returned_activity = ""; //Siapkan variabel untuk menampung pesan respon xml
	
	include '../login/connect.php';//buka koneksi ke database
	//Query untuk mengambil data Recent Activity
	$query = "SELECT waktu, aktivis, aktivitas FROM recent_activity ORDER BY waktu DESC";
	//Gunakan statement mysqli hingga didapat halil yang dicari (Penjelasan sama seperti pada file confirm.php).
	$stmt = $mysqli->prepare($query);
	echo $mysqli->error;
	$stmt->execute();
	$stmt->bind_result($waktu, $user_id, $berita);
	$stmt->store_result();
	$result = $stmt->fetch();
						
	//Cek jumlah hasil yang didapat.
	if($stmt->num_rows == 0){//Jika tidak ada, tambahkan pada variabel informasi bahwa tidak ada pengumuman
		$returned_activity .= "<span id='activity_empty' class='note_content'>Tidak ada berita untuk ditampilkan saat ini.</span><br/>";
	}
	else{//Jika ada,
		if(!empty($result)){//pastikan baris yang diakses saat ini tidak kosong
			$counter = 0;//counter berita
			do{
				$counter++;
				if($counter==1){
					$_SESSION["newer_activity"] = $waktu;
				}
				$date = date('d', strtotime($waktu));
				$month = date('m', strtotime($waktu));
				$time = date('H:i:s', strtotime($waktu));
				switch((int)$month){
					case 1 : $month = "Jan"; break;
					case 2 : $month = "Feb"; break;
					case 3 : $month = "Mar"; break;
					case 4 : $month = "Apr"; break;
					case 5 : $month = "Mei"; break;
					case 6 : $month = "Jun"; break;
					case 7 : $month = "Jul"; break;
					case 8 : $month = "Ags"; break;
					case 9 : $month = "Sep"; break;
					case 10 : $month = "Okt"; break;
					case 11 : $month = "Nov"; break;
					case 12 : $month = "Des"; break;
				}

				//Tuliskan berita [Tanggal Bulan (Jam:Menit:Detik) $aktivis $aktivitas]
				$returned_activity .= "<div class='activity_feed' id='".$waktu."'>".$date." ".$month." (".$time.") [".$user_id."] ".$berita;

				//Khusus untuk tipe user = 0 (Koordinator)
				if($_SESSION["type"] == 0){
					//Tampilkan tombol delete untuk menghapus berita
					$id = (string) $waktu;
					$returned_activity .= "<span class='activity_option' onclick='deleteActivity(this)'>X</span></div>";
				}
				else{
					$returned_activity .= "</div>";
				}
			}while( $result = $stmt->fetch() );//Loop berlangsung selama masih ada baris yang dapat diambil dari hasil eksekusi statement
			$_SESSION["number_of_activity"] = $counter;
		}
	}
	$stmt->close();
	$mysqli->close();

	//Kirimkan pesan yang telah disiapkan kepada fungsi pemanggil
	echo $returned_activity;
?>