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

// Check if there are items in the cart
$cart_check_query = $pdo->prepare("SELECT * FROM orders WHERE customerID = :customer_ID");
$cart_check_query->bindParam(':customer_ID', $_SESSION['id']);
$cart_check_query->execute();
$cart_items = $cart_check_query->fetchAll(PDO::FETCH_ASSOC);

// ... (previous code)

if (isset($_POST['place'])) { 
    $total_price = $_POST['total_price'];
    $customerID = $_POST['customer_ID'];
    $tprice = $_POST['total'];
    $orderStatus = $_POST['status'];

    $inserted_products = array();

    // Insert data into placed_orders table
    $insert_placed_query = $pdo->prepare("INSERT INTO placed_orders (customer_ID, product_ID, qty, total, status) VALUES (:customer_ID, :product_ID, :qty, :totalP, :stat)");

    foreach ($cart_items as $item) {
        $productID = $item['productID'];
        $quantity = $item['quantity'];

        // Check if the product has already been inserted
        if (!isset($inserted_products[$productID])) {
            $insert_placed_query->execute([
                ':customer_ID' => $customerID,
                ':product_ID' => $productID,
                ':qty' => $quantity,
                ':totalP' => $tprice,
                ':stat' => $orderStatus
            ]);

            // Mark the product as inserted
            $inserted_products[$productID] = true;
        }
    }

    // Insert data into sales table only if the order status is "Complete"
    if ($orderStatus === "Complete") {
        $insert_sales_query = $pdo->prepare("INSERT INTO sales (customer_ID, total_price, status) VALUES (:customer_ID, :total_price, :status)");
        $insert_sales_query->execute([
            ':customer_ID' => $customerID,
            ':total_price' => $total_price,
            ':status' => $orderStatus
        ]);
    }

    // Delete data from orders table
    $delete_query = $pdo->prepare("DELETE FROM orders WHERE customerID = :customer_ID");
    $delete_query->bindParam(':customer_ID', $customerID);

    if ($delete_query->execute()) {
        echo "<script>alert('Order Placed!')</script>";
        echo "<script>window.open('user-profile.php','_self')</script>";
    } else {
        echo "<script>alert('Error placing order!')</script>";
        echo "<script>window.open('checkout.php','_self')</script>";
    }
}

?>
