<?php 
  
  session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

  $hostname = "localhost";
  $username = "root";
  $password = "";
  $db = "cart_system";

	
  $pdo = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);

  if (isset($_POST['update'])) { 
    $quantity = $_POST['quantity']; 
    $productID = $_POST['pid'];
    
    // Prepare the statement with the named parameter
    $query = $pdo->prepare("UPDATE orders SET quantity = :qty WHERE productID = :pid");

    // bind the new values to the statement
    $query->bindParam(":qty", $quantity);
    $query->bindParam(":pid", $productID);
    $query->execute();
  }
	echo "<script>alert('Quantity updated!')</script>";
	echo "<script>window.open('checkout.php','_self')</script>";

?>
