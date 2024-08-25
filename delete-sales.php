<?php 
	
	session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

  $hostname = "localhost";
  $username = "root";
  $password = "";
  $db = "cart_system";

	$orderID = $_GET['Oid'];

  $pdo = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);

	// Prepare the statement with the named parameter
	$query = $pdo->prepare("DELETE FROM placed_orders WHERE placeOrderID = :Oid");
	$query->bindParam(":Oid", $orderID);
	$query->execute();

	

	echo "<script>alert('Order successfully deleted.')</script>";
	echo "<script>window.open('admin-orders.php','_self')</script>";

?>
