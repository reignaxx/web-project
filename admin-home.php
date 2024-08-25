<?php 
  
  session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

  if ($user_data['user_type'] !== 'admin') {
    header("Location: user-home.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Home - Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arapey&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
  <div class="topnav" id="myTopnav">
    <a href="javascript:void(0);" class="icon" onclick="toggleMenu()">
      <i class="fa fa-bars"></i>
    </a>
    <a href="#about" onclick="openUserInfoModal()"><i class="fa fa-user"></i></a>
    <a href="#" class="active"><i class="fa fa-cog"></i> SET UP</a>
    <a href="admin-products.php"><i class="fa fa-shopping-cart"></i> PRODUCTS</a>
    <a href="admin-orders.php"><i class="fa fa-file-text"></i> ORDERS</a>
    <a href="admin-users.php"><i class="fa fa-users"></i> USERS</a>
    <a href="admin-home.php"><i class="fa fa-home"></i> HOME</a>
</div>
<div id="userInfoModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeUserInfoModal()">&times;</span>
        <!-- User information content goes here -->
        <p>Username: <?php echo $user_data['user_name'];?> </p>
        <p>Email: <?php echo $user_data['email'];?></p>
        <a href="signout.php">
            <button style="background-color: #000; color: #fff; border-radius: 4px; padding: 3px; width: 80px;" type="button">Log Out</button>
        </a>
    </div>
</div>
    <center><br><h1>Dashboard</h1></center>
    <div class="container">
      <div class="card">
        <?php
          $complete_orders = 0;
          $select_complete = $con->prepare("SELECT total FROM placed_orders WHERE status='Complete'");
          $select_complete->execute();
          $select_complete->bind_result($total_price);

          while ($select_complete->fetch()) {
              $complete_orders += $total_price;
          }
          $select_complete->close();
        ?>
        <h1>₱ <?php echo $complete_orders; ?>.00</h1>
        <h3>Complete Orders</h3>
      </div>

      <div class="card">
        <?php
          $pending_orders = 0;

          // Assuming $con is a valid mysqli connection
          $select_pending = $con->prepare("SELECT total FROM placed_orders WHERE status='Pending'");
          $select_pending->execute();
          $select_pending->bind_result($total_price);

          while ($select_pending->fetch()) {
              $pending_orders += $total_price;
          }
          $select_pending->close();
        ?>
        <h1>₱ <?php echo $pending_orders; ?>.00</h1>
        <h3>Pending Orders</h3>
      </div>

      <div class="card">
      <?php
        $count_products = $con->prepare("SELECT COUNT(*) AS total_products FROM `product`");
        $count_products->execute();
        $result = $count_products->get_result();
        $row_products = $result->fetch_assoc();
        $num_of_products = $row_products['total_products'];
        ?>
      <h1><?php echo $num_of_products; ?></p></h1>
        <h3>Product</h3>
      </div>

      <div class="card">
      <?php
        $count_users = $con->prepare("SELECT COUNT(*) AS total_users FROM `users`");
        $count_users->execute();
        $result = $count_users->get_result();

        // Fetch the result as an associative array
        $row_users = $result->fetch_assoc();
        $num_of_users = $row_users['total_users'];
        ?>
        <h1><?php echo $num_of_users; ?></h1>
        <h3>Users</h3>
      </div>
    </div>
        </body>

  <script>
      function toggleMenu() {
          var x = document.getElementById("myTopnav");
          if (x.className === "topnav") {
              x.className += " responsive";
          } else {
              x.className = "topnav";
          }
      }

      function openUserInfoModal() {
          var modal = document.getElementById("userInfoModal");
          modal.style.display = "block";
      }

      function closeUserInfoModal() {
          var modal = document.getElementById("userInfoModal");
          modal.style.display = "none";
      }
  </script>

  <style>
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      background-color: #F2F2F2;
    }

    .topnav {
      overflow: hidden;
      background-color: #fff;
      padding: 20px;
      text-align: center;
      box-shadow: 1px 1px 1px #BFBFBF;
    }

    .topnav a {
      float: right;
      display: block;
      color: #000;
      text-align: center;
      padding: 14px 20px;
      text-decoration: none;
      font-size: 17px;
      font-family: 'Jura', sans-serif;
    }

    .topnav a:hover {
      transform:scale(1.1);
      
    }
    .topnav .icon {
      display: none;
    }

    @media screen and (max-width: 600px) {
      .topnav a:not(:first-child) {display: none;}
      .topnav a.icon {
        float: right;
        display: block;
      }
    }

    @media screen and (max-width: 600px) {
      .topnav.responsive {position: relative;}
      .topnav.responsive .icon {
        position: absolute;
        right: 0;
        top: 0;
      }
      .topnav.responsive a {
        float: none;
        display: block;
        text-align: left;
      }
    }
    /* Dashboard */
    .container {
    padding: 2% 8%;
    display: grid;
    grid-template-columns: repeat(2, 1fr); /* Set the number of columns to 3 */
    column-gap: 1rem;
    
  }

    .container .card {
      background: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.189);
      padding: 2rem;
      text-align: center;
      margin: 1rem;
      transition: transform 0.3s ease-in-out;
      font-family: 'Abel', sans-serif;   
    }
    .container .card:hover {
      transform: translate(0px, -8px);
    }
    /* Modal */
    #userInfoModal {
        display: none;
        position: absolute;
        top: 30px; /* Adjust this value to position it below the user icon */
        right: 10px; /* Adjust this value to position it horizontally */
        background-color: #f4f4f4;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
        z-index: 1;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.189);
        
    }

    .modal-content {
        color: #333;
        font-family: 'Abel', sans-serif;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }
</style>
</html>

