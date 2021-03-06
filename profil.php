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
  <title>Profil Asistensi UKDW</title>
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

	function visitProfile(){
		var visit = document.getElementById("profil_wrapper");
		var id = document.getElementById("id_target");
		var type = document.getElementById("tipe_target");
		xmlhttpVisit=new XMLHttpRequest();
		xmlhttpVisit.onreadystatechange=function(){
			if (xmlhttpVisit.readyState==4 && xmlhttpVisit.status==200){
				visit.innerHTML = xmlhttpVisit.responseText;
			}
		}
		xmlhttpVisit.open("GET","xmlhttp/visit.php?id="+id.value+"&type="+type.value,true);
		xmlhttpVisit.send();
	}

	window.onload = function(){
		visitProfile();
		//Siapkan ID untuk content 2 (untuk cek ada tidaknya content 2)
		var content2ID = "";
		//Cek apakah ada content 2 untuk tipe user 1 (Dosen)
		if(document.getElementById('content_2_for_user_type_1')!=null){
			//Set ID content 2 (untuk Dosen)
			content2ID = "content_2_for_user_type_1";
		}//Cek apakah ada content 2 untuk tipe user 2 (Mahasiswa)
		else if(document.getElementById('content_2_for_user_type_2') != null){
			//Set ID content 2 (untuk Mahasiswa)
			content2ID = "content_2_for_user_type_2";
		}
		if(content2ID != "") refreshContent2(content2ID);
	}
	//-->
  </script>
 </head>

 <body>
	<div class="wrapper"><!--Wrapper 1 halaman penuh-->
		<?php $_SESSION["active_tab"] = 3; $lvl_dir = ''; include 'header.php';?><!--Sertakan header yang telah dibuat dalam file terpisah-->
		<div class="wrapper" id="lower_wrap"><!--Wrapper untuk konten-->
			<div id="content"><!--Tempat untuk konten pada halaman ini-->
				<input type = "hidden" id = "id_target" value=<?php echo $_SESSION["user_id"];?>>
				<input type = "hidden" id = "tipe_target" value=<?php echo $_SESSION["type"];?>>
				<div id='profil_wrapper'>
					<!--panggil fungsi visit.php-->
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