<?php
	include 'check_not_logged.php';

	if($_SESSION["type"] != 0){
		header('location: index.php');
	}
	else{
		include 'login/connect.php';
		$waktu="normal";
		switch($_POST["hari"]){
			case 1: $hari = "Senin"; $waktu = "khusus"; break;
			case 2: $hari = "Selasa";break;
			case 3: $hari = "Rabu";break;
			case 4: $hari = "Kamis";break;
			case 5: $hari = "Jumat";break;
		}
		if($waktu=="normal"){
			switch($_POST["waktu"]){
				case 1: $sesi = "07:30:00"; break;
				case 2: $sesi = "10:30:00"; break;
				case 3: $sesi = "13:30:00"; break;
				case 4: $sesi = "16:30:00"; break;
			}
		}
		else if($waktu=="khusus"){
			switch($_POST["waktu"]){
				case 1: $sesi = "08:30:00"; break;
				case 2: $sesi = "11:30:00"; break;
				case 3: $sesi = "14:30:00"; break;
				case 4: $sesi = "17:30:00"; break;
			}
		}

		switch($_POST["jenis"]){
			case 1: $jenis="Praktikum";
			case 2: $jenis="Tutorial";
		}
		$jadwal_id = "".$_POST["hari"].$_POST["waktu"].$_POST["ruang"];
		$query2 = "INSERT INTO jadwal (jadwal_id, hari, waktu, jenis, ruang, grup, mk_id) VALUE (?, ?, ?, ?, ? , ? , ?)";
		$stmt2 = $mysqli->prepare($query2);
		echo $mysqli->error;
		$stmt2->bind_param('sssssss',$jadwal_id, $hari, $sesi, $jenis, $_POST["ruang"],$_POST["grup"],$_POST["mk_id"]);
		$stmt2->execute();
		$stmt2->close();

		echo "Perubahan sukses<br/><a href='setting.php'>Kembali</a>";
	}
?>