<?php
	include 'check_not_logged.php';

	if($_SESSION["type"] != 0){
		header('location: index.php');
	}
?>
<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <title>Setting Asistensi UKDW</title>
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
	function popTranskrip(src){
		//Tampung elemen popup ke dalam variabel JS
		var popup = document.getElementById('trans');
		//tampilkan elemen tadi (karena sebelumnya elemen tersebut di hide)
		popup.setAttribute('style','display:block;');
		//Tampung elemen frame untuk menampilkan isi popup ke dalam variabel JS
		var div_frame = document.getElementById('div_frame');
		div_frame.setAttribute('style','display:block;');
		//tambahkan atribut src dengan file untuk menambahkan pengumuman
		div_frame.innerHTML = "<img src='"+src+"' alt='Transkrip Nilai'>";
	}
	function closePopUp(box){//closePopUp akan melakukan fungsi refresh Box sebelum kemudian menutup pop up
		switch(box){
			case "content_1_mk" : refreshContent("content_1_mk"); break;
			case "content_2_mk" : refreshContent("content_1_mk"); break;
		}
		var popup = document.getElementById("trans");
		var frame1= document.getElementById("frame1");
		var div_frame= document.getElementById("div_frame");
		//set kembali elemen popup menjadi hidden
		popup.setAttribute('style','display:none;');
		frame1.setAttribute('style','display:none;');
		div_frame.setAttribute('style','display:none;');
	}

	function cekDaftarAkunDosen(){
		var req1_error = document.getElementById("req1_error");
		if(req1_error != null){
			req1_error.remove();
		}
		var req11 = document.getElementById("req11");
		var req12 = document.getElementById("req12");
		var req13 = document.getElementById("req13");
		var req14 = document.getElementById("req14");

		if(req11.value == "" || req12.value == "" || req13.value == "" ||  req14.value == ""){
			document.getElementById("req1").innerHTML += "<i id='req1_error'>*Field belum lengkap</i>";
			return false;
		}
		return true;
	}

	function cekHapusAkunDosen(){
		var req2_error = document.getElementById("req2_error");
		if(req2_error != null){
			req2_error.remove();
		}
		var req21 = document.getElementById("req21");

		if(req21.value == ""){
			document.getElementById("req2").innerHTML += "<i id='req2_error'>*Field belum lengkap</i>";
			return false;
		}
		return true;
	}

	function cekResetJadwal(){
		var req3_error = document.getElementById("req3_error");
		if(req3_error != null){
			req3_error.remove();
		}
		var req31 = document.getElementById("req31");

		if(req31.value == ""){
			document.getElementById("req3").innerHTML += "<i id='req3_error'>*Field belum lengkap</i>";
			return false;
		}
		return true;
	}

	function cekTambahMK(){
		var req4_error = document.getElementById("req4_error");
		if(req4_error != null){
			req4_error.remove();
		}
		var req41 = document.getElementById("req41");
		var req42 = document.getElementById("req42");
		var req43 = document.getElementById("req43");

		if(req41.value == "" || req42.value == "" || req43.value == ""){
			document.getElementById("req4").innerHTML += "<i id='req4_error'>*Field belum lengkap</i>";
			return false;
		}
		return true;
	}

	function cekTambahAmpu(){
		var req5_error = document.getElementById("req5_error");
		if(req5_error != null){
			req5_error.remove();
		}
		var req51 = document.getElementById("req51");
		var req52 = document.getElementById("req52");

		if(req51.value == "" || req52.value == ""){
			document.getElementById("req5").innerHTML += "<i id='req5_error'>*Field belum lengkap</i>";
			return false;
		}
		return true;
	}
	
	window.onload = function(){

	}
	//-->
  </script>
 </head>

 <body>
	<div class="wrapper"><!--Wrapper 1 halaman penuh-->
		<?php $_SESSION["active_tab"] = 3; $lvl_dir = ''; include 'header.php';?><!--Sertakan header yang telah dibuat dalam file terpisah-->
		<div class="wrapper" id="lower_wrap"><!--Wrapper untuk konten-->
			<div id="content"><!--Tempat untuk konten pada halaman ini-->
				<div id='setting_wrapper'>
					<h4>Pengaturan Asistensi UKDW</h4>
					<b class='title_setting'>Tambah Akun Dosen</b><br/>
					<form id = 'req1' method='post' action='addDosen.php' onsubmit='return(cekDaftarAkunDosen())'>
						<input class ='setting_field' id='req11' type='text' name='nama' value='' placeholder='Nama Dosen*'>						
						<input class ='setting_field' id='req12' type='text' name='dosen_id' value='' placeholder='ID Dosen*'>
						<input class ='setting_field' id='req13' type='password' name='password' value='' placeholder='Password Dosen*'>
						<input class ='setting_field' id='req14' type='text' name='email' value='' placeholder='Email Dosen*'>
						<input type='submit' name='submit' value='Daftarkan'>
					</form><br/>
					<b class='title_setting'>Hapus Akun Dosen</b><br/>
					<i>Warning : Anda hanya dapat menghapus akun dosen setelah meremove Dosen dari setiap mata kuliah yang diampunya</i>
					<form id = 'req2' method='post' action='removeDosen.php' onsubmit='return(cekHapusAkunDosen())'>		
						<input class ='setting_field' id='req21' type='text' name='dosen_id' value='' placeholder='ID Dosen*'>
						<input type='submit' name='submit' value='Hapus'>
					</form><br/>
					<b class='title_setting'>Reset Jadwal Asistensi</b><br/>
					<i>Warning : Anda akan menghapus seluruh jadwal asistensi yang ada dengan mengklik tombol dibawah</i>
					<form id = 'req3' method='post' action='resetJadwal.php' onsubmit='return(cekResetJadwal())'>		
						<input class ='setting_field' id='req31' type='text' name='verivy' value='' placeholder='Enter something'>
						<input type='submit' name='submit' value='Reset'>
					</form><br/>
					<b class='title_setting'>Tambahkan Matakuliah Berpraktikum/Tutorial</b><br/>
					<form id = 'req4' method='post' action='tambahMK.php' onsubmit='return(cekTambahMK())'>
						<input class ='setting_field' id='req41' type='text' name='mk_id' value='' placeholder='ID MK*'>						
						<input class ='setting_field' id='req42' type='text' name='nama' value='' placeholder='Nama MK*'>
						<input class ='setting_field' id='req43' type='text' name='sks' value='' placeholder='SKS*'>
						<input type='submit' name='submit' value='Tambahkan'>
					</form><br/>
					<b class='title_setting'>Tambahkan Dosen pada Mata Kuliah</b><br/>
					<form id = 'req5' method='post' action='tambahAmpu.php' onsubmit='return(cekTambahAmpu())'>		
						<input class ='setting_field' id='req51' type='text' name='dosen_id' value='' placeholder='ID Dosen*'>
						<input class ='setting_field' id='req52' type='text' name='mk_id' value='' placeholder='ID MK*'>
						<input type='submit' name='submit' value='Tambah'>
					</form><br/>
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
			<div id ="div_frame" class="popup_content">
			</div>
		</div>
	</div>
 </body>
</html>