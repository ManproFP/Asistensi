		<div class="wrapper" id="upper_wrap"><!--Wrapper untuk header-->
			<div id="header">
				 <!---->
					<div id="main_menu"><!--Blok untuk Menu Utama-->
						<div id="header_to_beranda" <?php if($_SESSION["active_tab"] == 0) echo 'class="current_menu"'; else echo 'class=""';?>>
							<a href=<?php echo $lvl_dir."home.php"; ?>>BERANDA</a></div>
						<div id="header_to_matakuliah" <?php if($_SESSION["active_tab"] == 1) echo 'class="current_menu"'; else echo 'class=""';?>>
							<a href=<?php echo $lvl_dir."matakuliah.php"; ?>>MATAKULIAH</a></div>
						<div id="header_to_jadwal" <?php if($_SESSION["active_tab"] == 2) echo 'class="current_menu"'; else echo 'class=""';?>>
							<a href=<?php echo $lvl_dir."jadwal.php"; ?>>JADWAL</a></div>
						<div id="header_to_logout">
							<a href=<?php echo $lvl_dir."logout.php"; ?>>LOGOUT</a></div>
						<div id="header_to_profil" <?php if($_SESSION["active_tab"] == 3) echo 'class="current_menu"'; else echo 'class=""';?>>
							<a href=<?php if($_SESSION["type"] == 0) echo $lvl_dir."setting.php"; else echo $lvl_dir."profil.php"; ?>>
								<?php 
									if($_SESSION["type"] == 0)
										echo "[".$_SESSION["user_id"]."] PENGATURAN";
									else echo "[".$_SESSION["user_id"]."] ".$_SESSION["full_name"];
								?>
							</a></div>
					</div>
				<!---->
			</div><!--End of Header-->
		</div><!--End of upper warp-->

		<div class="wrapper" id="second_wrap"><!--Wrapper untuk sub-header-->
			<div id="subheader">
				  <div id="upper_right"><!--header panel kanan -->
				      <form id="search_form" method="get" action=<?php echo $lvl_dir."search_result.php"; ?>><!--Form Cari-->
						<table cellspacing="0">
							<tbody>
								<tr><!--Baris untuk label text field-->
									<td class="label_a"><label for="search">Pencarian</label></td>
									<td class="label_a"><label for="category">Kategori</label></td>
								</tr>
								<tr><!--Baris untuk text field dan tombol login-->
									<td class="field_search"><input name="search" type="text" value=""></td><!--Field Keyword pencarian-->
									<td class="drop_down">
										<select name="category">
											<option value=0 selected>Semua</option>
											<option value=1>Mahasiswa</option>
											<option value=2>Mata Kuliah</option>
											<option value=3>Dosen</option>
										</select>
									</td>
									<td class="field_b"><button type="submit" value="">
										<img src=<?php echo $lvl_dir."images/src_btn.png"; ?> alt="Cari"></button>
									</td>
								</tr>
							</tbody>
						</table>
					 </form><!--End of Search Form-->
				  </div><!--End of Panel Kanan-->

				  <div id="upper_left">
					  <div id="img_title"><!--Tempat untuk image Nama Website-->
					    <a href=<?php echo $lvl_dir."index.php"; ?> rel="nofollow"><!--Anchor agar ketika image di klik, akan memuat ulang halaman awal situs-->
						  <img src=<?php echo $lvl_dir."login/web_title_trans.png"; ?> class="image" alt="Asistensi UKDW">
					    </a>
					  </div>
					  <div id="img_logo"><!--Tempat untuk image Logo UKDW-->
					    <a href="http://www.ukdw.ac.id" target="_blank"><!--Anchor agar ketika image di klik, akan di alihkan ke situs ukdw-->
						  <img src=<?php echo $lvl_dir."login/logo_ukdw.png"; ?> width="61" height="80" class="image" alt="Logo UKDW">
					    </a>
					  </div>
				  </div>
			</div><!--End of Subheader-->
		</div><!--End of second warp-->
		<div id="dummy"></div><!--Untuk menggantikan div upper_wrap yang berposisi fixed-->