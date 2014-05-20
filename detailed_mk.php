<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <title>Beranda Asistensi UKDW</title>
  <?php
		session_start();
		if(isset($_GET["id"])){
			$mk_id = $_GET["id"];
		}
	?>
  <link rel="stylesheet" type="text/css" href="style/detailed_mk.css">
 </head>
 <body>
	<?php
		if(!isset($_GET["action"])){//Jika halaman ini dipanggil tanpa mengirim parameter $_POST
			  //Tampilkan UI untuk menambahkan info detail pada MK
			echo "
			  <div class='wrapper'>
				<i class='notif_on_action'>";
				if(isset($_GET["notif"]) && $_GET["notif"] != ""){
					echo $_GET["notif"];
				}
			echo "&nbsp</i>
				<h3>Info Mata Kuliah</h3>";
			//akses tabel matakuliah untuk mendapat info lebih lanjut
			include 'login/connect.php';
			//query untuk mengambil info pada matakuliah
			$query = "SELECT nama, sks FROM matakuliah WHERE mk_id = ?";
			$stmt = $mysqli->prepare($query);
			echo $mysqli->error;
			$stmt->bind_param('s', $mk_id);
			$stmt->execute();
			$stmt->bind_result($nama_mk, $sks_mk);
			$stmt->store_result();
			$result = $stmt->fetch();
			if($stmt->num_rows != 0){
				if(!empty($result)){
					do{
						echo "<h4><span class='right'>".$sks_mk." SKS</span><span class='left'>[".$mk_id."] ".$nama_mk."</span></h4>
						<div class='content'><div id='dosen_pengampu_mk'><span class='content_title'>Dosen Pengampu</span>";
						//akses tabel ampu dan dosen untuk mendapatkan info dosen yang mengampu matakuliah yang dimaksud
						$query2 = "SELECT ampu.dosen_id, dosen.nama FROM ampu INNER JOIN dosen WHERE ampu.mk_id = ? AND dosen.dosen_id = ampu.dosen_id ORDER BY ampu.dosen_id ASC";
						$stmt2 = $mysqli->prepare($query2);
						echo $mysqli->error;
						$stmt2->bind_param('s', $mk_id);
						$stmt2->execute();
						$stmt2->bind_result($dosen_id, $dosen_nama);
						$stmt2->store_result();
						$result2 = $stmt2->fetch();
						if($stmt2->num_rows != 0){
							if(!empty($result2)){
								do{
									echo "
										<br/><span class='dosen_pengampu_mk'>[".$dosen_id."] ".$dosen_nama."</span>
									";
								}while( $result2 = $stmt2->fetch() );
							}
						}
						$stmt2->close();
						echo "</div><div id ='jadwal_mk'><span class='content_title'>Jadwal Mata Kuliah</span><br/>";
						//Akses tabel jadwal untuk mendapatkan info jadwal pada mk
						$query2 = "SELECT jenis, grup, hari, waktu, ruang, jadwal_id FROM jadwal WHERE mk_id = ? ORDER BY grup ASC, jadwal_id ASC";
						$stmt2 = $mysqli->prepare($query2);
						echo $mysqli->error;
						$stmt2->bind_param('s', $mk_id);
						$stmt2->execute();
						$stmt2->bind_result($jadwal_jenis, $jadwal_grup, $jadwal_hari, $jadwal_waktu, $jadwal_ruang, $jadwal_id);
						$stmt2->store_result();
						$result2 = $stmt2->fetch();
						if($stmt2->num_rows != 0){
							if(!empty($result2)){
								do{
									echo "
										<span class='jadwal_mk'>".$jadwal_jenis." Grup ".$jadwal_grup.", ".$jadwal_hari." ".date('H:i',strtotime($jadwal_waktu))." [".$jadwal_ruang."]</span>
									";
									
									$find_user_in_list = false;
									//akses tabel jadwal dan asistensi untuk mendapatkan data mahasiswa yang mengasist pada list jadwal matakuliah dimaksud 
									$query3 = "SELECT mahasiswa.nim, mahasiswa.nama, asistensi.status FROM asistensi INNER JOIN mahasiswa ON asistensi.nim = mahasiswa.nim WHERE asistensi.jadwal_id = ? ORDER BY mahasiswa.nim ASC";
									$stmt3 = $mysqli->prepare($query3);
									echo $mysqli->error;
									$stmt3->bind_param('s', $jadwal_id);
									$stmt3->execute();
									$stmt3->bind_result($nim, $nama, $status_asistensi);
									$stmt3->store_result();
									$result3 = $stmt3->fetch();
									if($stmt3->num_rows != 0){
										if(!empty($result3)){
											do{
												if($_SESSION["user_id"] == $nim)$find_user_in_list = true;
												echo "<div class='list_asisten_mk'><a target='_blank' href='visit.php?id=".$nim."'>[".$nim."] ".$nama."</a> Status: ".$status_asistensi.".";
												if($status_asistensi == "diproses"){
													if($_SESSION["type"]==1){//Action untuk tipe user 1 (Dosen)
														echo "<a href='?id=".$mk_id."&action=tolak&jadwal_id=".$jadwal_id."&nim=".$nim."' class='button_action_asistensi'>Tolak</a><a href='?id=".$mk_id."&action=terima&jadwal_id=".$jadwal_id."&nim=".$nim."' class='button_action_asistensi'>Terima</a>";
													}
													else if($_SESSION["type"]==2){//Action untuk tipe user 2 (Mahasiswa)
														if($_SESSION["user_id"] == $nim)
														echo "<a href='?id=".$mk_id."&action=batal&jadwal_id=".$jadwal_id."' class='button_action_asistensi'>Batal</a>";
													}
												}
												else if($status_asistensi == "diterima"){
														if($_SESSION["type"] == 2 && $_SESSION["user_id"] != $nim){}
														else
														echo "<a href='?id=".$mk_id."&action=batal&jadwal_id=".$jadwal_id."&nim=".$nim."' class='button_action_asistensi'>Batal</a>";
												}
												else if($status_asistensi == "ditolak"){
													if($_SESSION["type"]==1){//Action untuk tipe user 1 (Dosen)
														echo "<a href='?id=".$mk_id."&action=batal&jadwal_id=".$jadwal_id."&nim=".$nim."' class='button_action_asistensi'>Batal</a>";
													}
													else if($_SESSION["type"]==2){//Action untuk tipe user 2 (Mahasiswa)
														if($_SESSION["user_id"] == $nim)
														echo "<a href='?id=".$mk_id."&action=daftar&jadwal_id=".$jadwal_id."' class='button_action_asistensi'>Daftar</a>";
													}
												}
												echo "</div>";
											}while( $result3 = $stmt3->fetch() );
										}
									}
									if(!$find_user_in_list){
										if($_SESSION["type"]==2){
											echo "<div id = 'reg_asistensi'><a href='?id=".$mk_id."&action=daftar&jadwal_id=".$jadwal_id."' class='button_reg_asistensi'>Daftar</a></div>";
										}
									}
									$stmt3->close();
								}while( $result2 = $stmt2->fetch() );
							}
						}
						$stmt2->close();
						echo "</div></div>";
					}while( $result = $stmt->fetch() );
				}
			}
		  }
		  else {//Jika parameter yang dimaksud ada,
			$action = $_GET["action"];// tampung nilainya
			$jadwal_id = $_GET["jadwal_id"];
			//Lakukan perubahan ke database.
			include 'login/connect.php';
			if($action == "daftar"){
				//Tambahkan asistensi mahasiswa ke database.
				$query = "INSERT INTO asistensi (nim, jadwal_id, status) VALUES ( ?, ?, 'diproses') ";
				$stmt = $mysqli->prepare($query);
				echo $mysqli->error;
				$stmt->bind_param('ss', $_SESSION["user_id"], $jadwal_id);
				$stmt->execute();
				$stmt->close();
			
				//Tambahkan pula berita terbaru seputar pendaftaran asistensi ke database
				$aktivitas = "mendaftar asistensi.";
				$query = "INSERT INTO recent_activity (aktivis, aktivitas) VALUES ( ?, ?) ";
				$stmt = $mysqli->prepare($query);
				echo $mysqli->error;
				$stmt->bind_param('ss',$_SESSION["user_id"], $aktivitas);
				$stmt->execute();
				$stmt->close();
				$mysqli->close();

				$note = "Pendaftaran asistensi berhasil dilakukan";
			}
			else if($action == "batal"){
				if($_SESSION["type"] == 1){
					$nim = $_GET["nim"];
					//Ubah status asistensi mahasiswa
					$query = "UPDATE asistensi SET status = 'diproses' WHERE jadwal_id = ? AND nim = ?";
					$stmt = $mysqli->prepare($query);
					echo $mysqli->error;
					$stmt->bind_param('ss', $jadwal_id, $nim);
					$stmt->execute();
					$stmt->close();

					$note = "Status asistensi mahasiswa dibatalkan.";
				}
				else if($_SESSION["type"] == 2){
					//Hapus asistensi mahasiswa
					$query = "DELETE FROM asistensi WHERE jadwal_id = ? AND nim = ?";
					$stmt = $mysqli->prepare($query);
					echo $mysqli->error;
					$stmt->bind_param('ss', $jadwal_id, $_SESSION["user_id"]);
					$stmt->execute();
					$stmt->close();

					//Tambahkan pula berita terbaru seputar pendaftaran asistensi ke database
					$aktivitas = "membatalkan asistensi.";
					$query = "INSERT INTO recent_activity (aktivis, aktivitas) VALUES ( ?, ?) ";
					$stmt = $mysqli->prepare($query);
					echo $mysqli->error;
					$stmt->bind_param('ss',$_SESSION["user_id"], $aktivitas);
					$stmt->execute();
					$stmt->close();
					$mysqli->close();

					$note = "Asistensi pada jadwal yang dipilih dibatalkan.";
				}
			}
			else{
				$nim = $_GET["nim"];
				if($action == "terima"){
					$status = "diterima";
					$aktivitas = "menerima";
				}
				else if($action == "tolak"){
					$status = "ditolak";
					$aktivitas = "menolak";
				}
				
				//Ubah status mahasiswa
				$query = "UPDATE asistensi SET  status = ? WHERE jadwal_id = ? AND nim = ?";
				$stmt = $mysqli->prepare($query);
				echo $mysqli->error;
				$stmt->bind_param('sss', $status, $jadwal_id, $nim);
				$stmt->execute();
				$stmt->close();
			
				//Tambahkan pula berita terbaru seputar pendaftaran asistensi ke database
				$aktivitas .= " asisteni mahasiswa.";
				$query = "INSERT INTO recent_activity (aktivis, aktivitas) VALUES ( ?, ?) ";
				$stmt = $mysqli->prepare($query);
				echo $mysqli->error;
				$stmt->bind_param('ss',$_SESSION["user_id"], $aktivitas);
				$stmt->execute();
				$stmt->close();
				$mysqli->close();

				$note = "Pendaftaran asistensi mahasiswa berhasil ".$status.".";

			}
			  header("location: detailed_mk.php?id=".$mk_id."&notif=".$note);
		  }
	?>
 </body>
</html>