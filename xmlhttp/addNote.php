<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <title>Beranda Asistensi UKDW</title>
  <?php
		session_start();
		if(isset($_SESSION["type"]) && $_SESSION["type"] == 0){
			$koor_id = $_SESSION["user_id"];//tampung user_id pada sesi ke dalam variabel php
			$forbidden = false; //user as koor memiliki akses untuk halaman ini
		}
		else{
			$forbidden = true;//user yang bukan koor tidak dapat mengakses
			echo "<link rel='stylesheet' type='text/css' href='../style/main.css'>"; //Sertakan styling untuk halaman 403.php
		}
	?>
  
  <link rel="stylesheet" type="text/css" href="addNote.css">
 </head>
 <body>
	<?php
		if($forbidden){//user yang tidak memiliki hak akses akan diberikan pemberitahuna.
			$lvl_dir = '../'; //Var level dir yang dibutuhkan karena dir pada header bersifat dinamis.
			include '../403.php';//halaman pemberitahuan 'akses yang tidak diijinkan'
		}
		else{//Jika user memiliki hak akses
		  //Minta current date dari server
		  include '../login/connect.php';
		  $query = "SELECT CURRENT_DATE()";
		  $stmt = $mysqli->prepare($query);
		  echo $mysqli->error;
		  $stmt->execute();
		  $stmt->bind_result($tanggal);
		  $stmt->store_result();
		  $result = $stmt->fetch();
		  if($stmt->num_rows == 1){
			if(!empty($result)){
				do{
					$current_date = date('d-m-Y', strtotime($tanggal)); //tampung tanggal dari server ke dalam format d-m-Y.
				}while( $result = $stmt->fetch() );
			}
		  }
		  $stmt->close();
		  $mysqli->close();

		  if(!isset($_POST["isi_pesan_baru"])){//Jika halaman ini dipanggil tanpa mengirim parameter $_POST
			  //Tampilkan UI untuk menambahkan pengumuman baru
			echo "
			  <div class='wrapper'>
				<h3>Tambah Pengumuman</h3>
				<h4><span class='right'>Tanggal : ".$current_date."</span><span class='left'>User_ID : ".$koor_id."</span></h4>
				<span class='content'>Isi pengumuman</span><br/>
				<form id='add_new_note' action='' method='post'>
					<textarea id='field_note' name='isi_pesan_baru'></textarea><br/>
					<input class = 'submit_button' type='submit' value='Submit'>
				</form>
			  </div>
			";
		  }
		  else {//Jika parameter yang dimaksud ada,
			$isi = $_POST["isi_pesan_baru"];// tampung nilainya
			//Lakukan penambahan pengumuman ke database.
			include '../login/connect.php';
			$query = "INSERT INTO pengumuman (tanggal, isi, koor_id) VALUES ( CURRENT_DATE(), ?, ?) ";
			$stmt = $mysqli->prepare($query);
			echo $mysqli->error;
			$stmt->bind_param('ss', $isi, $koor_id);
			$stmt->execute();
			$stmt->close();
			
			//Tambahkan pula berita terbaru seputar penambahan pengumuman ke database
			$aktivitas = "menambahkan pengumuman baru.";
			$query = "INSERT INTO recent_activity (aktivis, aktivitas) VALUES ( ?, ?) ";
			$stmt = $mysqli->prepare($query);
			echo $mysqli->error;
			$stmt->bind_param('ss',$koor_id, $aktivitas);
			$stmt->execute();
			$stmt->close();
			$mysqli->close();
			
			//Tampilkan pengumuman yang telah berhasil ditambahkan ke database
			echo "
			  <div class='wrapper'>
				<span>Pengumuman berhasil ditambahkan.</span>
				<h3>Pengumuman</h3>
				<h4><span>Tanggal : ".$current_date."</span><span class='left'> oleh ".$koor_id."</span></h4>
				<span class='content'>".$_POST["isi_pesan_baru"]."</span><br/>
			  </div>";
		  }
		}
	?>
 </body>
</html>