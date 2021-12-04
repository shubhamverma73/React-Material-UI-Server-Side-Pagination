<?php 

$mysqli = new mysqli("localhost","root","","test");

if($mysqli->connect_errno) {

	trigger_error('Connection failed: '.$mysqli->error);

} else {
	
	//======= Common Php setting =============
	header('Content-Type: application/json');
	date_default_timezone_set('Asia/Kolkata');
	
	$date = date("Y-m-d");
	$time = date("H:i:s");

	//========= Get Json Data ==============
	$json = file_get_contents('php://input');
	$get = json_decode($json);

}

?>