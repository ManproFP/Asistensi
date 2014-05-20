		<div class="wrapper" id="upper_wrap"><!--Wrapper untuk header-->
			<div id="header">
				 <!---->
				<div id="upper_right"><!--Header panel kanan-->
					<form id="search_form" method="post" action=<?php echo $lvl_dir."search_result.php"; ?>><!--Form Cari-->
						<table cellspacing="0">
							<tbody>
								<tr><!--Baris untuk label text field-->
									<td class="label_a"><label for="search">Pencarian</label></td>
									<td class="label_a"><label for="subject">Subyek</label></td>
								</tr>
								<tr><!--Baris untuk text field dan tombol login-->
									<td class="field_search"><input name="search" type="text" value=""></td>
									<td class="drop_down">
										<select name="subject">
											<option value="semua" selected>Semua</option>
											<option value="mahasiswa">Mahasiswa</option>
											<option value="matakuliah">Mata Kuliah</option>
											<option value="dosen">Dosen</option>
										</select>
									</td>
									<td class="field_b"><input id="submit_search" class="button" type="submit" value="Cari"></td>
								</tr>
							</tbody>
						</table>
					</form><!--End of Search Form-->
					<div id="main_menu"><!--Blok untuk Menu Utama-->
						<div id="header_to_beranda" <?php if($_SESSION["current_header"] == 0) echo 'class="current_menu"'; else echo 'class=""';?>>
							<a href=<?php echo $lvl_dir."home.php"; ?>>BERANDA</a></div>
						<div id="header_to_matakuliah" <?php if($_SESSION["current_header"] == 1) echo 'class="current_menu"'; else echo 'class=""';?>>
							<a href=<?php echo $lvl_dir."matakuliah.php"; ?>>MATAKULIAH</a></div>
						<div id="header_to_jadwal" <?php if($_SESSION["current_header"] == 2) echo 'class="current_menu"'; else echo 'class=""';?>>
							<a href=<?php echo $lvl_dir."jadwal.php"; ?>>JADWAL</a></div>
						<div id="header_to_logout">
							<a href=<?php echo $lvl_dir."logout.php"; ?>>LOGOUT</a></div>
						<div id="header_to_profil" <?php if($_SESSION["current_header"] == 3) echo 'class="current_menu"'; else echo 'class=""';?>>
							<a href=<?php if($_SESSION["type"] == 0) echo $lvl_dir."setting.php"; else echo $lvl_dir."profil.php"; ?>>
								<?php 
									if($_SESSION["type"] == 0)
										echo "[".$_SESSION["user_id"]."] PENGATURAN";
									else echo "[".$_SESSION["user_id"]."] ".$_SESSION["full_name"];
								?>
							</a></div>
					</div>
				</div><!--End of Header Panel Kanan-->
				<!---->
				<div id="upper_left"><!--Header panel Kiri-->
				  <div id="img_logo"><!--Tempat untuk image Logo UKDW-->
				    <a href="http://www.ukdw.ac.id" target="_blank"><!--Anchor agar ketika image di klik, akan di alihkan ke situs ukdw-->
					  <img src=<?php echo $lvl_dir."login/logo_ukdw.png"; ?> width="61" height="80" class="image" alt="Logo UKDW">
				    </a>
				  </div>
				  <div id="img_title"><!--Tempat untuk image Nama Website-->
				    <a href=<?php echo $lvl_dir."index.php"; ?> rel="nofollow"><!--Anchor agar ketika image di klik, akan memuat ulang halaman awal situs-->
					  <img src=<?php echo $lvl_dir."login/web_title_trans.png"; ?> class="image" alt="Asistensi UKDW">
				    </a>
				  </div>
				</div>
			</div>
		</div>
		<div id="dummy"></div><!--Untuk menggantikan div upper_wrap yang berposisi fixed-->