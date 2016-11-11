<?php
$servername = "localhost";
$username = "username";
$password = "password";
$database = "database";

// Create connection
$con = mysqli_connect($servername, $username, $password);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

mysqli_select_db($con, $database);

$json = file_get_contents("CreateUser.json");
$data = json_decode($json, true);

$query = "INSERT INTO UserAccounts(MatricNumber, Password, FirstName, LastName, LoginDateTime, Facebook) VALUES (?, ?, ?, ?, ?, ?)";
$st = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($st, "sssssi", $MatricNumber, $Password, $FirstName, $LastName, $LoginDateTime, $Facebook);	

if(!$st){
	die('stmt error' .mysqli_stmt_error($st));
}

foreach ($data as $row) {
	$MatricNumber = $row["MatricNumber"];
	$Password = $row["Password"];
	$FirstName = $row["FirstName"];
	$LastName = $row["LastName"];
	$LoginDateTime = $row["LoginDateTime"];
	$Facebook = intval($row["Facebook"]);
	echo "Insert into the database ". $MatricNumber. " " .$Password. " " . $FirstName. " " .$LastName. " " .$Facebook. "<br>";
	
	mysqli_stmt_execute($st);
	$st->insert_id;
} printf("Error : %s.\n", mysqli_stmt_error($st));

mysqli_close($con);
?>