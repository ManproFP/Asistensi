<?php
	session_start();

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
echo $_FILES["file"]["type"];
echo $_FILES["file"]["size"];
echo in_array($extension, $allowedExts);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 2000000)
&& in_array($extension, $allowedExts)) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  } else {
	$newfilename = "transkrip".$_SESSION["user_id"].".".$extension;
    move_uploaded_file($_FILES["file"]["tmp_name"],
      "images/users/" . $newfilename);

	if($_SESSION["type"]==1){
		$table = "dosen";
	}
	else{
		$table = "mahasiswa";
	}
    $pp ="images/users/".$newfilename;
	include 'login/connect.php';
	$query = "UPDATE ".$table." SET transkrip = ? WHERE user_id = ?";
	$stmt = $mysqli->prepare($query);
	echo $mysqli->error;
	$stmt->bind_param('ss',$pp, $_SESSION["user_id"]);
	$stmt->execute();
  }
}
else {
  echo "Invalid file";
}

header('location: profil.php');
?>