<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Declare the credentials to the database
$dbconnecterror = FALSE;
$dbh = NULL;
require_once 'credentials.php';
try{
	
	$conn_string = "mysql:host=".$dbserver.";dbname=".$db;
	
	$dbh= new PDO($conn_string, $dbusername, $dbpassword);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
}catch(Exception $e){
	//return 500 error
	http_response_code(504);
	echo "DB error";
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == "PUT") {
	if(array_key_exists('listID',$_GET)){
		$listID = $_GET['listID'];
	}else{
	//Return 4XX error
	http_response_code(400);
	"No List ID";
	exit();
	
	}

	//decoding the json body from the request
	$task = json_decode(file_get_contents('php://input'), true);

	//Data Validation
	
	if (array_key_exists('completed', $task)) {
		$complete = $task["completed"];
	} else {
		//Return 4XX error
		http_response_code(422);
		echo "completed error";
		exit();
	}
	
	if (array_key_exists('taskName', $task)) {
		$taskName = $task["taskName"];
	} else {
		//Return 4XX error
		http_response_code(422);
		echo "Task Name Error";
		exit();
	}
	
	if (array_key_exists('taskDate', $task)) {
		$taskDate = $task["taskDate"];
	} else {
		//Return 4XX error
		http_response_code(422);
		echo "TaskDate error";
		exit();
	}

	if (!$dbconnecterror) {
		try {
			$sql = "UPDATE doList SET complete=:complete, listItem=:listItem, finishDate=:finishDate WHERE listID=:listID";
			$stmt = $dbh->prepare($sql);
			$stmt->bindParam(":complete", $complete);
			$stmt->bindParam(":listItem", $taskName);
			$stmt->bindParam(":finishDate", $taskDate);
			$stmt->bindParam(":listID", $listID);
			$response = $stmt->execute();
			//return response code
			http_response_code(204);
			exit();


		} catch (PDOException $e) {
			//return 500 message
			http_response_code(500);
			echo "Db Execption";
			exit();

		}
	} else {
		//return 500 message
		http_response_code(500);
		echo "update error";
		exit();
	}

//PUT	

	
}elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
	

	//decoding the json body from the request
	$task = json_decode(file_get_contents('php://input'), true);

	//Data Validation
	
	if (array_key_exists('completed', $task)) {
		$complete = $task["completed"];
	} else {
		//Return 4XX error
		http_response_code(422);
		echo "completed error";
		exit();
	}
	
	if (array_key_exists('taskName', $task)) {
		$taskName = $task["taskName"];
	} else {
		//Return 4XX error
		http_response_code(422);
		echo "Task Name Error";
		exit();
	}
	
	if (array_key_exists('taskDate', $task)) {
		$taskDate = $task["taskDate"];
	} else {
		//Return 4XX error
		http_response_code(422);
		echo "TaskDate error";
		exit();
	}

	if (!$dbconnecterror) {
		try {
			
			$sql = "INSERT INTO doList (complete, listItem, finishDate) VALUES (:complete, :listItem, :finishDate)";
			$stmt = $dbh->prepare($sql);			
			$stmt->bindParam(":complete", $complete);
			$stmt->bindParam(":listItem", $taskName);
			$stmt->bindParam(":finishDate", $taskDate);
			$response = $stmt->execute();
			//return response code
			http_response_code(204);
			exit();


		} catch (PDOException $e) {
			//return 500 message
			http_response_code(500);
			echo "Db Execption";
			exit();

		}
	} else {
		//return 500 message
		http_response_code(500);
		echo "update error";
		exit();
	}

//ADD

}elseif ($_SERVER['REQUEST_METHOD'] == "DELETE") {

if(array_key_exists('listID',$_GET)){
		$listID = $_GET['listID'];
	}else{
	//Return 4XX error
	http_response_code(400);
	"No List ID";
	exit();
	
	}

	if (!$dbconnecterror) {
		try {
			$sql = "DELETE FROM doList where listID = :listID";
			$stmt = $dbh->prepare($sql);			
			$stmt->bindParam(":listID", $listID);
		
			$response = $stmt->execute();	
			http_response_code(204);
			exit();

			
			
		} catch (PDOException $e) {
			http_response_code(500);
			echo "Db Execption";
			exit();
		}	
	} else {
		http_response_code(500);
		echo "update error";
		exit();
	}
	
} else{
	http_response_code(405);
	echo "expected PUT";
		exit();
	
}
?>


