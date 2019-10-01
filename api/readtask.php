<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dbconnecterror = FALSE;
$dbh = NULL;
$dbReadError = FALSE;

require_once 'credentials.php';

try{
	
	$conn_string = "mysql:host=".$dbserver.";dbname=".$db;
	
	$dbh= new PDO($conn_string, $dbusername, $dbpassword);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
	$dbconnecterror = TRUE;
}

if (!$dbconnecterror) {
	
	try {
		$sql = "SELECT * FROM doList";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
	} catch (PDOException $e) {
		$dbReadError = TRUE;
	}

}

echo json_encode($result);

?>


