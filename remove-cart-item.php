<?php 
	
	session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

  $hostname = "localhost";
  $username = "root";
  $password = "";
  $db = "cart_system";

	$productID = $_GET['pid'];
  $pdo = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);

	// Prepare the statement with the named parameter
	$query = $pdo->prepare("DELETE FROM orders WHERE productID = :pid");
	$query->bindParam(":pid",$productID);
	$query->execute();
	

	echo "<script>alert('Product successfully removed.')</script>";
	echo "<script>window.open('checkout.php','_self')</script>";

?>
