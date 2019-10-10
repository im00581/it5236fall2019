<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Declare the credentials to the database

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	

	
	if (array_key_exists('fin', $_POST)) {
		$complete = 1;
	} else {
		$complete = 0;
	}
	if (empty($_POST['finBy'])) {
		$finBy = null;
	} else {
		$finBy = $_POST['finBy'];
	}
	$listItem = $_POST['listItem'];
	

				
	
	
	//build url
	
	$url="https://www.ianrossmaxwell.com/api/task.php";
	
	//create json string
	$data = array('completed'=>$complete,'taskName'=>$listItem,'taskDate'=>$finBy);
	$data_json = json_encode($data);
	
	//Make a call to the API
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response  = curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	
	//status code 204
	if($httpcode==204){
		
		header("Location: index.php");
		
	}else {
	
	// api errors (status code not 204)	
	header("Location: index.php?error=add");
			
	}
	
}
