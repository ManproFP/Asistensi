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
									case 1: echo "Mata kuliah di daftar asistensi Anda"; break;
									case 2: echo "Mata kuliah yang Anda ampu"; break;
								}
							?>
						</span>
						<div id="content_mk_upper">
							<?php
								switch($_SESSION["type"]){
									case 0: echo "
												<span>Mata kuliah berpraktikum : 1</span><span class='button_span_mk'>+ Add</span><br/>
												<span>Mata kuliah bertutorial &nbsp: 0</span><span class='button_span_mk'>+ Add</span><br/>
												<span>Total mata kuliah berpraktikum/tutorial : 1</span><span class='button_span_mk'>+ Add</span>";
											break;
									case 1: echo "<span><a class='mk_click_to_pop'>[TIW015] Teknologi Komputer</a> 5sks. Total asisten: 0 diterima, 3 diproses</span>"; break;
									case 2: echo "<span><a class='mk_click_to_pop'>[TIW015] Teknologi Komputer</a> 5sks. Status: diproses.</span><span class='button_span_mk'>Batal</span>"; break;
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
									case 0: echo "
												<span><a class='mk_click_to_pop'>[TIW015] Teknologi Komputer</a> 5sks.</span><span class='button_span_mk'>Delete</span><br/>
												<span>&nbsp&nbsp&nbsp&nbspTotal jadwal: 2 Praktikum, 0 Tutorial</span>";
											break;
									case 1: echo "<span><i>Belum ada mata kuliah lain untuk ditampilkan saat ini.</i></span>"; break;
									case 2: echo "<span><i>Belum ada mata kuliah lain untuk ditampilkan saat ini.</i>"; break;
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