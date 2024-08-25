<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

  $hostname = "localhost";
  $username = "root";
  $password = "";
  $db = "cart_system";

	$userID = $_GET['uid'];
  $pdo = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);

	// Prepare the statement with the named parameter
	$query = $pdo->prepare("DELETE FROM users WHERE id = :uid");
	$query->bindParam(":uid",$userID);
	$query->execute();
	

	echo "<script>alert('Account Successfully Deleted!')</script>";
	echo "<script>window.open('signin-page.php','_self')</script>";

?>
