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
  <title>Matakuliah Asistensi UKDW</title>
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
		frame.setAttribute('style','display:block;');
		//tambahkan atribut src dengan file untuk menambahkan pengumuman
		frame.setAttribute('src',src);
	}

	//Fungsi untuk menutup popup
	function closePopUp(box){//closePopUp akan melakukan fungsi refresh Box sebelum kemudian menutup pop up
		switch(box){
			case "content_2_for_user_type_1": refreshContent1("content_1_for_user_type_1"); refreshContent2("content_2_for_user_type_1"); break;
			case "content_2_for_user_type_2": refreshContent1("content_1_for_user_type_2"); refreshContent2("content_2_for_user_type_2"); break;
		}
		var popup = document.getElementById("trans");
		//set kembali elemen popup menjadi hidden
		popup.setAttribute('style','display:none;');
	}
	
	function refreshContent1(id){
		var content1 = document.getElementById(id);
		xmlhttpContent1=new XMLHttpRequest();
		xmlhttpContent1.onreadystatechange=function(){
			if (xmlhttpContent1.readyState==4 && xmlhttpContent1.status==200){
				content1.innerHTML = xmlhttpContent1.responseText;
			}
		}
		xmlhttpContent1.open("GET","xmlhttp/refreshContent1.php?id="+id,true);
		xmlhttpContent1.send();
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
		//Siapkan ID untuk content 2 (untuk cek ada tidaknya content 2)
		var content2ID = "";
		var content1ID = "";
		//Cek apakah ada content 2 untuk tipe user 1 (Dosen)
		if(document.getElementById('content_2_for_user_type_1')!=null){
			//Set ID content 2 (untuk Dosen)
			content2ID = "content_2_for_user_type_1";
		}//Cek apakah ada content 2 untuk tipe user 2 (Mahasiswa)
		else if(document.getElementById('content_2_for_user_type_2') != null){
			//Set ID content 2 (untuk Mahasiswa)
			content2ID = "content_2_for_user_type_2";
		}

		if(document.getElementById('content_1_for_user_type_0')!=null){
			//Set ID content 1 (untuk Koordinator)
			content1ID = "content_1_for_user_type_0";
		}
		else if(document.getElementById('content_1_for_user_type_1') != null){
			//Set ID content 1 (untuk Dosen)
			content1ID = "content_1_for_user_type_1";
		}
		else if(document.getElementById('content_1_for_user_type_2') != null){
			//Set ID content 1 (untuk Mahasiswa)
			content1ID = "content_1_for_user_type_2";
		}
		//Tampilkan Content 1 (jika ada)
		if(content1ID != "") refreshContent1(content1ID);
		//Tampilkan Content 2 (jika ada)
		if(content2ID != "") refreshContent2(content2ID);
	}
  //-->
  </script>
 </head>

 <body>
	<div class="wrapper"><!--Wrapper 1 halaman penuh-->
		<?php $_SESSION["active_tab"] = 1; $lvl_dir = ''; include 'header.php';?><!--Sertakan header yang telah dibuat dalam file terpisah-->
		<div class="wrapper" id="lower_wrap"><!--Wrapper untuk konten-->
			<div id="content"><!--Tempat untuk konten pada halaman ini-->
				<div id="lower_left">
					<div id = 'content_1_mk'>
						<h3>Daftar Mata Kuliah Berpraktikum/Tutorial</h3>
						<span class="content_mk_title">
							<?php
								switch($_SESSION["type"]){
									case 0: echo "Total Mata kuliah"; break;
									case 1: echo "Mata kuliah yang Anda ampu"; break;
									case 2: echo "Mata kuliah di daftar asistensi Anda"; break;
								}
							?>
						</span>
						<div id="content_mk_upper">
							<?php
								switch($_SESSION["type"]){
									case 0: echo "
												<span>Mata kuliah berpraktikum : 1</span>"//<span class='button_span_mk'>+ Add</span>
												."<br/><span>Mata kuliah bertutorial &nbsp: 0</span>"//<span class='button_span_mk'>+ Add</span>
												."<br/><span>Total mata kuliah berpraktikum/tutorial : 1</span>";//<span class='button_span_mk'>+ Add</span>";
											break;
									case 1: $_SESSION["opened_popup"] = 'content_2_for_user_type_1'; echo "<div id='content_2_for_user_type_1'></div>"; break;
									case 2: $_SESSION["opened_popup"] = 'content_2_for_user_type_2'; echo "<div id='content_2_for_user_type_2'></div>"; break;
								}
							?>
						</div>
					</div>
					<div id = 'content_2_mk'>
						<span class="content_mk_title">
							<?php
								switch($_SESSION["type"]){
									case 0: echo "Mata kuliah terdaftar"; break;
									case 1: echo "Mata kuliah lainnya"; break;
									case 2: echo "Mata kuliah lainnya"; break;
								}
							?>
						</span>
						<div id="content_mk_lower">
							<?php
								switch($_SESSION["type"]){
									case 0: echo "<div id='content_1_for_user_type_0'></div>";
											break;
									case 1: echo "<div id='content_1_for_user_type_1'></div>"; break;
									case 2: echo "<div id='content_1_for_user_type_2'></div>"; break;
								}
							?>
						</div>
					</div>
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