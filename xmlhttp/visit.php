<?php
	session_start();
	if(isset($_GET["id"]) && isset($_GET["type"])){
		$target_id = $_GET["id"];
		$target_type = $_GET["type"];
		$visitor = $_SESSION["user_id"];
		$can_edit = false;
		$button_to_edit="<span class='profile_edit_data'>Edit</span>";

		if($target_id == $visitor){//mengunjungi profil sendiri
			$can_edit = true;
		}
		include '../login/connect.php';
		if($target_type == 1){
			$table = "dosen";
			$req_field = "nama, email, no_hp, pp, status";
			$bind_target = 1;
		}
		else{
			$table = "mahasiswa";	
			$req_field = "nama, email, no_hp, pp, transkrip";
			$bind_target = 2;
		}

		$query = "SELECT ".$req_field." FROM ".$table." WHERE user_id = ?";
		$stmt = $mysqli->prepare($query);
		echo $mysqli->error;
		$stmt->bind_param('s',$target_id);
		$stmt->execute();
		if($bind_target == 1){
			$stmt->bind_result($nama, $email, $no_hp, $pp, $status);
		}
		else{
			$stmt->bind_result($nama, $email, $no_hp, $pp, $transkrip);
		}
		$stmt->store_result();
		$result = $stmt->fetch();
		if($stmt->num_rows == 1){
			if(!empty($result)){
				do{
					echo "<div id='lower_right'>
							<div id='profile_image_holder'>
								<img src='".$pp."' alt='image for ".$target_id."'>";
					if($can_edit){
						  echo "<div id='profile_image_upload'>
									<span>Unggah foto profil baru<span/><br/><br/>
									<form enctype='multipart/form-data' accept-charset='utf-8' method='post' action='uploadpp.php'>
										<span id='profile_image_upload_form_span'>Pilih file image untuk di unggah</span><br>
										<input type='file' size='20' name='file'></input>
											<br></br>
										<input id='profile_image_submit' type='submit' value='unggah'></input>
									</form>
								</div>";
					}
					echo  "</div>
						</div>
					<h3>Profil ";
					if($target_type == 1){
						echo "Dosen UKDW";
					}
					else{
						echo "Mahasiswa UKDW";		
					}
					echo "</h3><div id='lower_left'>
							<h4>".$nama."<br/>[".$target_id."]</h4>
							<span class='profil_label'>Email</span><span>: ".$email."</span>.";
					if($can_edit)echo $button_to_edit;	
					echo ".<br/><br/>
							<span class='profil_label'>No HP</span><span>: ".$no_hp."</span>";
					if($can_edit)echo $button_to_edit;
					echo "<br/><br/>";
					if($target_type == 1){	
						echo "<span class='profil_label'>Status</span><span>: ".$status."</span>";
					}

					if( $target_type == 2 && ($_SESSION["user_id"] == $target_id || $_SESSION["type"] != 2)){//tambahkan transkrip nilai untuk dilihat oleh diri sendiri atau dosen & koordinator
						echo "<span class='profil_label'>Transkrip</span><a id='profile_pop_transkrip' onclick='popTranskrip(\"".$transkrip."\")'>Lihat</a><br/>";
						if($can_edit){
							echo "<form enctype='multipart/form-data' accept-charset='utf-8' method='post' action='uploadtn.php'>
									<span>Perbarui transkrip:</span>
									<span>Pilih file image untuk di unggah</span>
										<input type='hidden' name='id' value='".$_SESSION["user_id"]."'>
										<input type='file' size='20' name='file'></input>
										<input type='submit' value='unggah'></input>
								</form>
							";
						}
					}
					echo "</div>";
				}while( $result = $stmt->fetch() );
			}
		}
		$stmt->close();
		$mysqli->close();
		
	}
	else{
	}
?>