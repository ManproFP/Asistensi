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
  <title>Beranda Asistensi UKDW</title>
  <link rel="stylesheet" type="text/css" href="style/main.css">
  <script type="text/javascript">
  <!--
  //-->
  </script>
  <script type="text/javascript">
	<!--
	//Fungsi Delete Pengumuman + AJAX
	function deleteNote(id,node){
		//Tampung element yang akan dihapus kedalam variabel JS
		var note = document.getElementById("note" + id);
		//Buat prompt untuk konfirmasi penghapusan pengumuman
		var sure = confirm("Yakin akan menghapus pengumuman ini?");
		if(sure){//Jika user yakin untuk menghapus
			note.parentNode.remove();
			//Ajax function start here
			xmlhttpDN=new XMLHttpRequest();//buat Req baru
			xmlhttpDN.onreadystatechange=function(){//State untuk req ready
				if (xmlhttpDN.readyState==4 && xmlhttpDN.status==200){//state = 4 (Req Complete) && status = 200 (OK)

				}
			}
			//Open a file for the req
			xmlhttpDN.open("GET","xmlhttp/deleteNote.php?id="+id,true);//parameter(Method, file, Async status.)
			xmlhttpDN.send();
			//Ajax function End here
		}
	}

	function deleteActivity(id){
		//Buat prompt untuk konfirmasi penghapusan pengumuman
		var sure2 = confirm("Yakin akan menghapus berita ini?");
		if(sure2){//Jika user yakin untuk menghapus
			id.parentNode.remove();
			//Ajax function start here
			xmlhttpDA=new XMLHttpRequest();//buat Req baru
			xmlhttpDA.onreadystatechange=function(){//State untuk req ready
				if (xmlhttpDA.readyState==4 && xmlhttpDA.status==200){//state = 4 (Req Complete) && status = 200 (OK)
					//document.getElementById("elem_id").innerHTML=xmlhttp.responseText;
				}
			}
			//Open a file for the req
			xmlhttpDA.open("GET","xmlhttp/deleteActivity.php?id="+id.parentNode.id,true);//parameter(Method, file, Async status.)
			xmlhttpDA.send();
			//Ajax function End here
		}
	}

	//Fungsi Edit Pengumuman
	function editNote(id,btn){
		var note = document.getElementById("note" + id);
		//Ubah attr note agar dapat di edit untuk pengeditan
		note.setAttribute('contentEditable',true);
		//Beri tampilan note yang berbeda untuk menarik perhatian user
		note.setAttribute('style','background-color:#5D1B2B; color:#fff; border:1px solid gray;');

		//Saat user dalam mode edit, ganti tombol Edit menjadi tombol Submit
		btn.setAttribute('style', 'width:40px;');//sesuaikan panjang tombol
		btn.setAttribute('onclick','submitNote('+id+',this)');//sesuaikan fungsi tombol
		btn.innerHTML = "Submit";//sesuaikan nama tombol
	}

	//Fungsi Submit pengumuman yang telah di edit + AJAX
	function submitNote(id,btn){
		//Saat user mensubmit hasil editannya, ubah tombol submit kembali menjadi tombol Edit
		btn.setAttribute('style', 'width:25px;');//kembalikan panjang tombol seperti semula
		btn.setAttribute('onclick','editNote('+id+',this)');//kembalikan ke fungsi edit
		btn.innerHTML = "Edit";//kembalikan nama tombol seperti semula

		var note = document.getElementById("note" + id);
		note.setAttribute('contentEditable',false);//Mode submit selesai, content tidak dapat lagi di edit
		note.setAttribute('style','background:none; color:#000;');//kembalikan tampilan note seperti semula

		//AJAX function start here
		var update = note.innerHTML;
		xmlhttpSN=new XMLHttpRequest();
		xmlhttpSN.onreadystatechange=function(){
			if (xmlhttpSN.readyState==4 && xmlhttpSN.status==200){
				note.innerHTML = xmlhttpSN.responseText;
			}
		}
		xmlhttpSN.open("GET","xmlhttp/updateNote.php?id="+id+"&note="+update,true);//panggil fungsi untuk mengupdate perubahan ke database
		xmlhttpSN.send();
		//AJAX function end here
	}

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
			case "addNote" : refreshNote(); break;
			case "content_2_for_user_type_1": refreshContent2("content_2_for_user_type_1"); break;
			case "content_2_for_user_type_2": refreshContent2("content_2_for_user_type_2"); break;
		}
		var popup = document.getElementById("trans");
		//set kembali elemen popup menjadi hidden
		popup.setAttribute('style','display:none;');
	}

	function refreshActivity(){
		var divBerita = document.getElementById('llc_recent_activity');//siapkan elemen yang contentnya akan di update

		xmlhttpActivity=new XMLHttpRequest();
		xmlhttpActivity.onreadystatechange=function(){
			if (xmlhttpActivity.readyState==4 && xmlhttpActivity.status==200){
				divBerita.innerHTML = xmlhttpActivity.responseText;
			}
		}
		xmlhttpActivity.open("GET","xmlhttp/refreshActivity.php",true);
		xmlhttpActivity.send();
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

	function refreshNote(){
		var divNote = document.getElementById('lower_right');//siapkan elemen yang contentnya akan di update

		xmlhttpNote=new XMLHttpRequest();
		xmlhttpNote.onreadystatechange=function(){
			if (xmlhttpNote.readyState==4 && xmlhttpNote.status==200){
				divNote.innerHTML = xmlhttpNote.responseText;
			}
		}
		xmlhttpNote.open("GET","xmlhttp/refreshNote.php",true);
		xmlhttpNote.send();
	}
	
	function checkActivityUpdate(){
			xmlhttpCAU=new XMLHttpRequest();
			xmlhttpCAU.onreadystatechange=function(){
				if (xmlhttpCAU.readyState==4 && xmlhttpCAU.status==200){
					var activityUpdate = xmlhttpCAU.responseText;
					if(activityUpdate == "YES"){ // Jika pesan yang diterima adalah YES, berarti terdapat update.
						refreshActivity();//panggil fungsi untuk mengupdate Berita yang ditampilkan
					}
				}
				else{
				}
			}
			xmlhttpCAU.open("GET","xmlhttp/checkActivityUpdate.php",true);
			xmlhttpCAU.send();
	}

	function checkNoteUpdate(){
			xmlhttpCNU=new XMLHttpRequest();
			xmlhttpCNU.onreadystatechange=function(){
				if (xmlhttpCNU.readyState==4 && xmlhttpCNU.status==200){
					var noteUpdate = xmlhttpCNU.responseText;
					if(noteUpdate == "YES"){ // Jika pesan yang diterima adalah YES, berarti terdapat update.
						refreshNote();//panggil fungsi untuk mengupdate pengumuman yang ditampilkan
					}
				}
			}
			xmlhttpCNU.open("GET","xmlhttp/checkNoteUpdate.php",true);
			xmlhttpCNU.send();
	}

	window.onload = function(){
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

		//Tampilkan Pengumuman
		refreshNote();
		//Tampilkan Kabar Berita
		refreshActivity();
		//Tampilkan Content 2 (jika ada)
		if(content2ID != "") refreshContent2(content2ID);
		//Cek update untuk pengumuman dan Kabar berita setiap 5 detik
		var myActivity=setInterval(function(){checkActivityUpdate();checkNoteUpdate();},5000);
	}
	//-->
  </script>
 </head>

 <body>
	<div class="wrapper"><!--Wrapper 1 halaman penuh-->
		<?php $_SESSION["active_tab"] = 0; $lvl_dir = ''; include 'header.php';?><!--Sertakan header yang telah dibuat dalam file terpisah-->
		<div class="wrapper" id="lower_wrap"><!--Wrapper untuk konten-->
			<div id="content"><!--Tempat untuk konten pada halaman ini-->
				<div id="lower_right"><!--Kontent Pengumuman pada panel kanan-->
					<script type="text/javascript">
						
					</script>
				</div>
				<div id="lower_left">
					<?php if($_SESSION["type"] == 0){
							$llcid = "admin";
							$_SESSION["opened_popup"] = "addNote";
						}
						else $llcid = "user";
					?>
					<div id=<?php echo "llcid_".$llcid;?>>
						<span class="lower_left_title">Kabar Berita</span>
						<div id="llc_recent_activity" class=<?php echo "llc_recent_activity_".$llcid;?>>
							<!--Content Recent Activity-->
						</div>
					</div>
					<?php if($llcid != "admin"){
						if($_SESSION["type"] == 1){//Judul content 2 (untuk dosen)
							$_SESSION["opened_popup"] = "content_2_for_user_type_1";
							$title2 = "Daftar Matakuliah yang Diampu";
						}
						else {//Judul content 2 (untuk mahasiswa)
								$title2 = "Daftar Asistensi Anda";
								$_SESSION["opened_popup"] = "content_2_for_user_type_2";
						}
						echo "
							<div id='llcid2_".$llcid."'>
								<span class='lower_left_title'>".$title2."</span>
								<div id='content_2_for_user_type_".$_SESSION["type"]."' class='llc_recent_activity_user'>
									<!--Content Daftar Asistensi-->
								</div>
							</div>
						";
					}?>
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