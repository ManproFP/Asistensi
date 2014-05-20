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
  <title>Jadwal Asistensi UKDW</title>
  <link rel="stylesheet" type="text/css" href="style/main.css">
  <script type="text/javascript">
  <!--
  //-->
  </script>
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
		frame.setAttribute('style','display:block;');
		//tambahkan atribut src dengan file untuk menambahkan pengumuman
		frame.setAttribute('src',src);
	}

	//Fungsi untuk menutup popup
	function closePopUp(box){//closePopUp akan melakukan fungsi refresh Box sebelum kemudian menutup pop up
		switch(box){
			case "content_1_mk" : refreshContent("content_1_mk"); break;
			case "content_2_mk" : refreshContent("content_1_mk"); break;
		}
		var popup = document.getElementById("trans");
		//set kembali elemen popup menjadi hidden
		popup.setAttribute('style','display:none;');
	}

	function refreshContent2(id){
		var content2 = document.getElementById(id);
		xmlhttpContent2=new XMLHttpRequest();
		xmlhttpContent2.onreadystatechange=function(){
			if (xmlhttpContent2.readyState==4 && xmlhttpContent2.status==200){
				content2.innerHTML = xmlhttpContent2.responseText;
			}
		}
		xmlhttpContent2.open("GET","xmlhttp/refreshContent2.php?id="+id,true);
		xmlhttpContent2.send();
	}

	window.onload = function(){

	}
	//-->
  </script>
 </head>

 <body>
	<div class="wrapper"><!--Wrapper 1 halaman penuh-->
		<?php $_SESSION["active_tab"] = 2; $lvl_dir = ''; include 'header.php';?><!--Sertakan header yang telah dibuat dalam file terpisah-->
		<div class="wrapper" id="lower_wrap"><!--Wrapper untuk konten-->
			<div id="content"><!--Tempat untuk konten pada halaman ini-->
				<div id='jadwal_wrapper'>
					<h3>Jadwal Praktikum/Tutorial Mata Kuliah</h3>
					<?php
						if($_SESSION["type"] == 0){
							echo "<div id= 'jadwal_admin_option'>Total jadwal : 2 Praktikum, 0 Tutorial<span class='button_span_mk'>+ Add</span></div>";
						}
						if($_SESSION["type"] == 2){
							echo "<div id= 'jadwal_admin_option'>Klik pada jadwal matakuliah untuk mendaftar/batal.<br/>Keterangan warna : Biru(Belum Mendaftar), Merah (Asistensi Ditolak), Hijau (Asistensi diterima), Hitam (Asistensi masih diproses).</div>";
						}
						for($i = 0; $i <5; $i++){
							if($i==0)$current_i_id = "title";
							else $current_i_id = $i;
							echo "<div id='jadwal_day_".$current_i_id."' class='jadwal_";
								if($i==0) echo "title";
								else echo "content";
							echo "'>";
								for($j = 0; $j <6; $j++){
									if($j==0)$current_j_class = "time";
									else $current_j_class = "day";
									echo "<div class='jadwal_session_".$current_j_class."'>";
										if($i==0 && $j == 0)echo "&nbsp";
										if($j == 0 && $i != 0){
											echo "<b>S</b><br/>
												<b>E</b><br/>
												<b>S</b><br/>
												<b>I</b><br/>
												<b>".$i."</b><br/>
											";
										}
										else if($i == 0 && $j != 0){
											switch($j){
												case 1: echo "Senin";break;
												case 2: echo "Selasa";break;
												case 3: echo "Rabu";break;
												case 4: echo "Kamis";break;
												case 5: echo "Jumat";break;

											}
										}
										else if($j==1){
											$type = ($i + $j) % 2;
											switch($i){
												case 1: echo "<span class='jadwal_color_".$type."'>08:30</span>";break;
												case 2: echo "<span class='jadwal_color_".$type."'>11:30<br/><a class='color_code_4'>Praktikum Teknologi Komputer Grup A (Lab A)</a></span>";break;
												case 3: echo "<span class='jadwal_color_".$type."'>14:30</span>";break;
												case 4: echo "<span class='jadwal_color_".$type."'>17:30</span>";break;
											}
										}
										else{
											$type = ($i + $j) % 2;
											switch($i){
												case 1: echo "<span class='jadwal_color_".$type."'>07:30<br/>"; if($j == 5)echo "<a class='color_code_4'>Praktikum Teknologi Komputer Grup B (Lab A)</a>";echo "</span>";break;
												case 2: echo "<span class='jadwal_color_".$type."'>10:30<br/></span>";break;
												case 3: echo "<span class='jadwal_color_".$type."'>13:30</span>";break;
												case 4: echo "<span class='jadwal_color_".$type."'>16:30</span>";break;
											}
										}
									echo "</div>";
								}
							echo "</div>";
						}
					?>
				</div>
			</div>		
		</div>
		<?php include 'footer.php';?>
	</div>
	<div id="trans" class="pop_up"><!--Transparansi untuk popup-->
		<div class="popup_wrapper"><!--Wrapper untuk popup-->
			<div id='close_button' class="popup_close_button" <?php echo "onclick='closePopUp(\""; if(isset($_SESSION["opened_popup"]))
				echo $_SESSION["opened_popup"]; echo "\")'";?>><span>X</span></div><!--Popup Close Button-->
			<iframe id="frame1" class="popup_content" src=""></iframe><!--Popup Content-->
		</div>
	</div>
 </body>
</html>