<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

$hostname = "localhost";
$username = "root";
$password = "";
$db = "cart_system";

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$db", $username, $password);

    if (isset($_POST['add'])) {
        $id = $_POST['id'];
        $user = $_SESSION['id'];
        $quantity = $_POST['quantity'];

        // Check if the product ID and the user ID already exist in the orders table
        $check_query = $pdo->prepare("SELECT * FROM orders WHERE customerID = ? AND productID = ?");
        $check_query->execute([$user, $id]);
        $num_rows = $check_query->rowCount();

        if ($num_rows == 0) {
            $insert_query = $pdo->prepare("INSERT INTO orders (customerID, productID, quantity) VALUES (?, ?, ?)");
            $insert_query->execute([$user, $id, $quantity]);

            echo "<script>alert('$quantity of this product successfully added to your cart.')</script>";
            echo "<script>window.open('user-home.php#categories','_self')</script>";
        } else {
            // Display a message to the user that the product is already in the cart
            echo "<script>alert('Product is already in the cart!')</script>";
            echo "<script>window.open('user-home.php#categories','_self')</script>";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
