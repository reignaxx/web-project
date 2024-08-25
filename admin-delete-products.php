<?php 
	session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

  $hostname = "localhost";
  $username = "root";
  $password = "";
  $db = "cart_system";

	if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Perform the deletion operation in the database
    $deleteQuery = "DELETE FROM product WHERE id = ?";
    $stmt = $con->prepare($deleteQuery);
    $stmt->bind_param("i", $productId);
    
    if ($stmt->execute()) {
        // Deletion successful
        echo "<script>alert('Product deleted successfully!')</script>";
    } else {
        // Handle deletion failure
        echo "<script>alert('Error deleting product.')</script>";
    }

    $stmt->close();
} else {
    // Handle the case where no product ID is provided in the URL
    echo "Product ID not provided.";
}

// Redirect the user to the products page or any other page after deletion
echo "<script>window.location.href='admin-products.php#products';</script>";
?>
