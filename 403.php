<?php
	$_SESSION["current_header"]=-1;
	include 'header.php';
	echo "
	  <div id='content'>
		<div id='lower_left'>
			<div id = 'add_note_title'>
				<h2>403 Forbidden</h2>
			</div>
			<div id = 'add_note_content'>You do not have the proper privilege level to access this page !!</div>
		</div>
	  </div>
	";
?>