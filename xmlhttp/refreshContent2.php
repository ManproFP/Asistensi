<?php
  session_start(); //Buka sesi
  $returned_content2 = ""; //Siapkan variabel untuk menampung pesan respon xml
  $user_id = $_SESSION["user_id"];
	
  //cek ID yang diminta untuk content 2
  if($_GET["id"] == "content_2_for_user_type_1"){//Content 2 untuk Dosen (Daftar Matakuliah yang Diampu)
	//buka koneksi ke database
	include '../login/connect.php';
	//Query untuk mengambil data Matakuliah yang diampu
	$query = "SELECT mk_id FROM ampu WHERE dosen_id = ? ORDER BY mk_id ASC";
	//Gunakan statement mysqli hingga didapat halil yang dicari (Penjelasan sama seperti pada file confirm.php).
	$stmt = $mysqli->prepare($query);
	echo $mysqli->error;
	$stmt->bind_param('s', $user_id);
	$stmt->execute();
	$stmt->bind_result($mk_id);
	$stmt->store_result();
	$result = $stmt->fetch();
						
	//Cek jumlah hasil yang didapat.
	if($stmt->num_rows == 0){//Jika tidak ada, tambahkan pada variabel informasi bahwa tidak ada matakuliah yang diampu
		$returned_content2 .= "<div id='matakuliah_diampu_kosong' class='content2'>Tidak ada matakuliah yang Anda ampu saat ini.</div>";
	}
	else{//Jika ada,
		if(!empty($result)){//pastikan baris yang diakses saat ini tidak kosong
			$counter=0;
			do{
				$counter++;
				$linkPopUp = "detailed_mk.php?id=".$mk_id;
				$returned_content2 .= "<div id='matakuliah_".$mk_id."' class='content2'>".$counter.". <span class='list_mk_diampu' onclick='openPopUp(\"".$linkPopUp."\")'>".$mk_id;
				//akses tabel matakuliah untuk mendapat info lebih lanjut
				$query2 = "SELECT nama, sks FROM matakuliah WHERE mk_id = ?";
				$stmt2 = $mysqli->prepare($query2);
				echo $mysqli->error;
				$stmt2->bind_param('s', $mk_id);
				$stmt2->execute();
				$stmt2->bind_result($nama_mk, $sks_mk);
				$stmt2->store_result();
				$result2 = $stmt2->fetch();
				if($stmt2->num_rows != 0){
					if(!empty($result2)){
						do{
							$returned_content2 .= " ".$nama_mk."</span> ".$sks_mk."sks. Total asisten: ";
							//akses tabel jadwal dan asistensi untuk mendapatkan data mahasiswa yang mengasist pada list jadwal matakuliah dimaksud 
							$query3 = "SELECT asistensi.nim, asistensi.status FROM jadwal INNER JOIN asistensi ON jadwal.jadwal_id = asistensi.jadwal_id WHERE jadwal.mk_id = ? ORDER BY asistensi.nim ASC";
							$stmt3 = $mysqli->prepare($query3);
							echo $mysqli->error;
							$stmt3->bind_param('s', $mk_id);
							$stmt3->execute();
							$stmt3->bind_result($nim,$status_asistensi);
							$stmt3->store_result();
							$result3 = $stmt3->fetch();
							if($stmt3->num_rows != 0){
								if(!empty($result3)){
									$count_diproses = 0;
									$count_diterima = 0;
									do{
										if($status_asistensi == "diproses"){
											$count_diproses++;
										}
										else if($status_asistensi == "diterima"){
											$count_diterima++;
										}
									}while( $result3 = $stmt3->fetch() );
									$returned_content2 .= $count_diterima." diterima, ".$count_diproses." diproses.</div>";
								}
							}
							$stmt3->close();
						}while( $result2 = $stmt2->fetch() );
					}
				}
				$stmt2->close();
			}while( $result = $stmt->fetch() );//Loop berlangsung selama masih ada baris yang dapat diambil dari hasil eksekusi statement
		}
	}
	$stmt->close();
	$mysqli->close();
  }
  else if($_GET["id"] == "content_2_for_user_type_1"){//Content 2 untuk Mahasiswa
	
  }

  //Kirimkan pesan yang telah disiapkan kepada fungsi pemanggil
  echo $returned_content2;
?>