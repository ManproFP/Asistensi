<?php //Logged Confirmation Function
		//Halaman ini hanya dapat diakses setelah user melakukan log in terlebih dahulu.
		//Untuk itu perlu dilakukan pengecekan dengan memanggil fungsi berikut.
		include 'check_not_logged.php'; //
		//**Pemanggilan fungsi di atas juga dimaksudkan agar variabel yang ada pada Session PHP siap untuk digunakan.
?>

<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <title>Hasil Pencarian Asistensi UKDW</title>
  <link rel="stylesheet" type="text/css" href="style/main.css">
  <script type="text/javascript">
  <!--
	//Fungsi untuk menampilkan popup
	function openPopUp(src){
		//alert(src);
		//Tampung elemen popup ke dalam variabel JS
		var popup = document.getElementById('trans');
		//tampilkan elemen tadi (karena sebelumnya elemen tersebut di hide)
		popup.setAttribute('style','display:block;');
		//Tampung elemen frame untuk menampilkan isi popup ke dalam variabel JS
		var frame = document.getElementById('frame1');
		frame.setAttribute('style','display:block');
		//tambahkan atribut src dengan file untuk menambahkan pengumuman
		frame.setAttribute('src',src);
	}

	//Fungsi untuk menutup popup
	function closePopUp(box){//closePopUp akan melakukan fungsi refresh Box sebelum kemudian menutup pop up
		switch(box){
			case "addNote" : refreshNote(); break;
			case "content_2_for_user_type_1": refreshContent2("content_2_for_user_type_1"); break;
			case "content_2_for_user_type_2": refreshContent2("content_2_for_user_type_2"); break;
		}
		var popup = document.getElementById("trans");
		//set kembali elemen popup menjadi hidden
		popup.setAttribute('style','display:none;');
	}

	window.onload = function(){
		var mk =document.getElementsByClassName('search_result_for_matakuliah');
		for (var i = 0; i < mk.length; i++) {
			mk[i].setAttribute('onclick', 'openPopUp(\"detailed_mk.php?id='+mk[i].id+'\")');
		}
		var mhs =document.getElementsByClassName('search_result_for_mahasiswa');
		for (var i = 0; i < mhs.length; i++) {
			mhs[i].setAttribute('onclick', 'window.open(\"visit_profil.php?id='+mhs[i].id+'&type='+2+'\")');
		}
		var dsn =document.getElementsByClassName('search_result_for_dosen');
		for (var i = 0; i < dsn.length; i++) {
			dsn[i].setAttribute('onclick', 'window.open(\"visit_profil.php?id='+dsn[i].id+'&type='+1+'\")');
		}
	}
  //-->
  </script>
 </head>

 <body>
	<div class="wrapper"><!--Wrapper 1 halaman penuh-->
		<?php $_SESSION["active_tab"] = -1; $lvl_dir = ''; include 'header.php';?><!--Sertakan header yang telah dibuat dalam file terpisah (tab aktiv )-->
		<div class="wrapper" id="lower_wrap"><!--Wrapper untuk konten-->
			<div id="content"><!--Tempat untuk konten pada halaman ini-->
				<div id="search_result"><!--Blok hasil pencarian-->
					<div class="site_map"><b>Pencarian</b><br/><a href="index.php">Asistensi UKDW</a> >> <a href="">Pencarian</a></div>
					<?php
						$search_keyword = $_GET["search"];
						$search_category= $_GET["category"];
						$_SESSION["number_of_result"] = 0; //variabel untuk menghitung total hasil pencarian yang ditemukan
						$search_result ="";

						if($search_keyword == ""){//Jika keyword kosong, tidak perlu dilakukan pencarian ke database. Tampilkan hasil pencarian.
							echo "<h4>Hasil pencarian tidak ditemukan.</h4>Tidak ada keyword untuk dicari dalam pencarian Anda.";
						}
						else{
							function searchSomething($table,$keyword,$requested_field,$num_of_field,$field_list){
								//mulai akses ke databes dengan tabel pencarian = mahasiswa
								$nor = $_SESSION["number_of_result"];
								$logicStr = "
								WHERE ";
								for($i = 0; $i < $num_of_field; $i++){
									$logicStr .= $field_list[$i]."
									LIKE '%".$keyword."%' ";
									if(($i+1) != $num_of_field) $logicStr .= "OR ";
								}
								include 'login/connect.php';
								$query = "SELECT DISTINCT ".$requested_field." FROM ".$table." ".$logicStr."ORDER BY ".$field_list[0]." ASC";
								$stmt = $mysqli->prepare($query);
								echo $mysqli->error;
								$stmt->execute();
								$stmt->bind_result($id, $nama);
								$stmt->store_result();
								$result = $stmt->fetch();
								$return_result ="";
								if($stmt->num_rows > 0){
									if(!empty($result)){
										$counter=0;
										$front =  "<br/><b>Kategori ".$table;
										$return_result = "hasil.</b><br/>";
										do{
											$counter++;
											$return_result .= "<spin class='result_listing'>&nbsp&nbsp&nbsp&nbsp".$counter.". </spin><spin class='search_result_for_".$table."' id='".$id."'>[".$id."] ".$nama."</spin><br/>";
										}while( $result = $stmt->fetch() );
										$return_result = $front.": ".$counter." ".$return_result;
									}
									$nor += $counter;
								}
								$stmt->close();
								$mysqli->close();
								$_SESSION["number_of_result"] = $nor;
								return $return_result;
							}

							if( $search_category == 0 || $search_category == 1 ){//Lakukan pencarian untuk kategori semua atau hanya mahasiswa
								$field_list = array("user_id","nama");
								$search_result .= searchSomething('mahasiswa',$search_keyword,'user_id, nama',2,$field_list);
							}
							if( $search_category == 0 || $search_category == 2 ){//Lakukan pencarian untuk kategori semua atau hanya mahasiswa
								$field_list = array("mk_id","nama","sks");
								$search_result .= searchSomething('matakuliah',$search_keyword,'mk_id, nama',3,$field_list);
							}
							if( $search_category == 0 || $search_category == 3 ){//Lakukan pencarian untuk kategori semua atau hanya mahasiswa
								$field_list = array("user_id","nama");
								$search_result .= searchSomething('dosen',$search_keyword,'user_id, nama',2,$field_list);
							}
							
							$elem = "<p>";
							$elemx= "</p>";
							if($search_result == ""){
								$search_result .= "<br/><br/><i>Silahkan mencoba untuk mencari dengan kata kunci yang lain.</i>";
								echo "<h4>Hasil pencarian tidak ditemukan.</h4>";
								$elem = "<span>";
								$elemx= "</span>";
							}

							switch($search_category){
								case 1: $search_category_category = "kategori mahasiswa"; break;
								case 2: $search_category_category = "kategori matakuliah"; break;
								case 3: $search_category_category = "kategori dosen"; break;
								default: $search_category_category = "semua kategori"; break;
							}

							echo $elem."Pencarian untuk kata kunci '".$search_keyword."'.<br/>Total hasil yang ditemukan pada ".$search_category_category." : ".$_SESSION["number_of_result"]." data.".$elemx;
						
							echo $search_result;
						}
					?>
				</div>
			</div>
		</div>
		<?php include 'footer.php';?>
	</div>
	<div id="trans" class="pop_up"><!--Transparansi untuk popup-->
		<div class="popup_wrapper"><!--Wrapper untuk popup-->
			<div id='close_button' class="popup_close_button" onclick="closePopUp(0)"><span>X</span></div><!--Popup Close Button-->
			<iframe id="frame1" class="popup_content" src=""></iframe><!--Popup Content-->
		</div>
	</div>
 </body>
</html>