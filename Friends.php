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

$json = file_get_contents("friends.json");
$data = json_decode($json, true);

$query = "INSERT INTO Friends(MatricFriender, MatricFriendee) VALUES (?, ?)";
$st = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($st, "ss", $MatricFriender, $MatricFriendee);	

if(!$st){
	die('stmt error' .mysqli_stmt_error($st));
}

foreach ($data as $row) {
	$MatricFriender = $row["MatricNumber"];
	echo "Friender is " . $MatricFriender. "Friendee is ";
	
	$tempFriendee = $row["Friends"];
	$ExplodedFriendee = explode(",", $tempFriendee);
	foreach ($ExplodedFriendee as $Exploded){
		echo $Exploded . " ";
		$MatricFriendee = $Exploded;
		mysqli_stmt_execute($st);
		$st->insert_id;
	}
} printf("Error : %s.\n", mysqli_stmt_error($st));

mysqli_close($con);
?>