<?php 
    
    session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

    if ($user_data['user_type'] !== 'admin') {
        header("Location: user-home.php");
        exit();
    }

  //update order status: pending|complete
  if (isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];

    try {
        $update_query = "UPDATE `placed_orders` SET `status` = ? WHERE `placeOrderID` = ?";
        $update_stmt = mysqli_prepare($con, $update_query);

        if ($update_stmt) {
            mysqli_stmt_bind_param($update_stmt, "ss", $update_payment, $order_id);
            
            if (mysqli_stmt_execute($update_stmt)) {
                // Status updated successfully
                echo '<script>alert("Status updated successfully.");</script>';
            } else {
                // Error updating status
                echo '<script>alert("Error updating status: ' . mysqli_error($con) . '");</script>';
            }

            mysqli_stmt_close($update_stmt);
        } else {
            // Error in preparing the statement
            echo '<script>alert("Error preparing statement: ' . mysqli_error($con) . '");</script>';
        }
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Users - Admin</title>
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
        <i class="fa fa-bars"></i></a>
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
    <center><h1>Orders</h1></center>
    <div class="container">
    <div class="row user-cards">
        <?php
        try {
            $select_orders_query = "SELECT placed_orders.*, product.*, users.* FROM placed_orders
            JOIN product ON placed_orders.product_ID = product.id
            JOIN users ON placed_orders.customer_ID = users.id
            LEFT JOIN sales ON placed_orders.customer_ID = sales.customer_ID
            ORDER BY placed_orders.customer_ID, placed_orders.order_date DESC";

            $select_orders_result = mysqli_query($con, $select_orders_query);

            if ($select_orders_result && mysqli_num_rows($select_orders_result) > 0) {
                $currentDate = null;  // Initialize currentDate variable

                while ($fetch_orders = mysqli_fetch_assoc($select_orders_result)) {
                    $orderDate = date('F j, Y', strtotime($fetch_orders['order_date']));

                    // Check if the date has changed
                    if ($orderDate != $currentDate) {
                        // Display sub-header for the new date
                        //echo '<div class="col-md-12 sub-header"><strong>' . $orderDate . '</strong></div>';
                        $currentDate = $orderDate;
                    }
        ?>
                    <div class="col-md-6">
                        <div class="box">
                           <p><i class="bi bi-clock-fill"></i></i><span> <?php echo $orderDate; ?></span></p>
                                <p><i class="bi bi-person-badge"></i> ID: <span><?php echo $fetch_orders['customer_ID']; ?></span></p>
                                <p><i class="bi bi-person-square"></i> @ <span><?php echo $fetch_orders['user_name']; ?></span></p>
                                <p><i class="bi bi-person-fill"></i> <span><?php echo $fetch_orders['fname']; ?> <?php echo $fetch_orders['lname']; ?></span></p>
                                <p><i class="bi bi-phone-fill"></i> <span><?php echo $fetch_orders['phone']; ?></span></p>
                                <p><i class="bi bi-envelope-fill"></i> <span><?php echo $fetch_orders['email']; ?></span></p>
                                <p><i class="bi bi-house-fill"></i> <span><?php echo $fetch_orders['address']; ?></span></p>
                                <p><i class="bi bi-box-fill"></i> <span><?php echo $fetch_orders['product_name']; ?></span></p>
                                <p><i class="bi bi-tag-fill"></i> <span><?php echo $fetch_orders['qty']; ?></span></p>
                                <p>Total: ₱ <span><?php echo $fetch_orders['total']; ?>.00</span></p>

                                <div class="order-actions">
                                    <form method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $fetch_orders['placeOrderID']; ?>">
                                        <select name="update_payment">
                                            <option value="Pending" <?php echo ($fetch_orders['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="Complete" <?php echo ($fetch_orders['status'] == 'Complete') ? 'selected' : ''; ?>>Complete</option>
                                        </select>
                                        <input type="submit" name="update_order" value="Update status" class="btn">
                                    </form>
                                    <a href="delete-sales.php?Oid=<?php echo $fetch_orders['placeOrderID']; ?>" onclick="return confirm('delete this order');" class="delete">
                                        <i class="bi bi-trash-fill"></i> Delete
                                    </a>
                                </div>
                        </div>
                    </div>
        <?php
                }
            } else {
                echo '<div class="col-md-12">
                        <p>No orders found</p>
                    </div>';
            }
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage();
        }
        ?>
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

      //Button
      document.addEventListener("DOMContentLoaded", function () {
         var buttons = document.querySelectorAll(".your-button-class"); /* Replace "your-button-class" with your actual button class */

         buttons.forEach(function (button) {
               button.addEventListener("click", function () {
                  buttons.forEach(function (btn) {
                     btn.classList.remove("button-active");
                  });

                  this.classList.add("button-active");
               });
         });
      });

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
    
    /* Modal */
    #userInfoModal {
        display: none;
        position: absolute;
        top: 30px; /* Adjust this value to position it below the user icon */
        right: 10px; /* Adjust this value to position it horizontally */
        background-color: #f4f4f4;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
        z-index: 1;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.189);
    }

    .modal-content {
        color: #333;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }
    /* User cards */
    .user-cards {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    
}

    .box {
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.189);
        padding: 2rem;
        text-align: left;
        margin: 1rem;
        transition: transform 0.3s ease-in-out;
        font-family: 'Abel', sans-serif;
    }


        .box:hover {
            transform: translate(0px, -8px);
        }
        
        /* button */
    .button-active {
        background-color: #YourActiveColor; /* Change this to the color you want */
        color: #fff; /* Change this to the text color you want */
    }

    /* buttons/selection */
    select[name="update_payment"] {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-right: 10px;
    }

    input[name="update_order"] {
        padding: 8px 16px;
        font-size: 14px;
        background-color: #A7A7A7;
        color: #000; /* Text color */
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .order-actions {
        margin-top: 10px;
    }

 </style>
</html>

