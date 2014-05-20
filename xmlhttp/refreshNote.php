<?php
	session_start(); //Buka sesi
	$returned_note = "<h3>PENGUMUMAN</h3>"; //Siapkan variabel untuk menampung pesan respon xml
	
	include '../login/connect.php';//buka koneksi ke database
	//Query untuk mengambil data pengumuman
	$query = "SELECT note_id, koor_id, tanggal, isi FROM pengumuman ORDER BY note_id DESC";
	//Gunakan statement mysqli hingga didapat halil yang dicari (Penjelasan sama seperti pada file confirm.php).
	$stmt = $mysqli->prepare($query);
	echo $mysqli->error;
	$stmt->execute();
	$stmt->bind_result($note_id, $koor_id, $tanggal, $isi);
	$stmt->store_result();
	$result = $stmt->fetch();
						
	$_SESSION["number_of_note"] = 0;
	//Cek jumlah hasil yang didapat.
	if($stmt->num_rows == 0){//Jika tidak ada, tambahkan pada variabel informasi bahwa tidak ada pengumuman
		$returned_note .= "<div class='note_title'><br/>
				<span id='note_empty' class='note_content'>Tidak ada pengumuman untuk ditampilkan. Silahkan cek dilain waktu.
				</span>
			  </div>";
	}
	else{//Jika ada,
		if(!empty($result)){//pastikan baris yang diakses saat ini tidak kosong
			$iterator = 0;//iterator untuk array
			do{
				$array = array($note_id,$isi); //siapkan array untuk menampung note_id dan isi pada baris yang sedang diakses
				if($iterator == 0){//untuk akses kali pertama,
					$array_of_array = array($array); //buat var array of array untuk menampung array sebelumnya
				}
				else{//Untuk kali berikutnya,
					array_push($array_of_array,$array); //push array ke dalam array of array
				}
					
				//Siapkan Judul pengumuman dari hasil yang sedang diakses kedalam variabel (Berupa 'tanggal pembuatan' dan 'oleh id pembuat')
				$returned_note .= "<div class='note_title'>".date('d-m-Y', strtotime($tanggal))." oleh ".$koor_id;

				//Khusus untuk tipe user = 0 (Koordinator)
				if($_SESSION["type"] == 0){
					//Tampilkan tombol edit dan delete
					$returned_note .= "<span class='note_option' onclick='deleteNote(".$note_id.",this)'>X</span>
						<span class='note_option' onclick='editNote(".$note_id.",this)'>Edit</span>";
				}
					
				//Siapkan isi pengumuman dari hasil yang sedang di akses
				$returned_note .= "<br/><span id='note".$note_id."' class='note_content'>".$isi."</span>"."</div>";
				//lakukan penambahan pada iterator sebelum mengakhiri proses 1x loop
				$iterator++;
			}while( $result = $stmt->fetch() );//Loop berlangsung selama masih ada baris yang dapat diambil dari hasil eksekusi statement

			$_SESSION["number_of_displayed_note"] = $iterator;//Tambahkan pada sesi user jumlah pengumuman yang diperoleh (Untuk tujuan auto update Pengumuman)
			$_SESSION["list_of_displayed_note"] = $array_of_array;//Tambahkan pada sesi daftar dari pengumuman yang ada (berupa list note_id dan isinya)
		}
	}
	//Khusus untuk tipe = 0 (Koordinator)
	if($_SESSION["type"] == 0){
		$linkPopUp = "xmlhttp/addNote.php";
		//$_SESSION["opened_popup"] = "addNote";
		$returned_note .= "<br/><span id='add_note' onclick='openPopUp(\"".$linkPopUp."\")'>+ Add</span>";//Sertakan tombol untuk menambahkan pengumuman baru
	}
	$stmt->close();
	$mysqli->close();

	//Kirimkan pesan yang telah disiapkan kepada fungsi pemanggil
	echo $returned_note;
?>