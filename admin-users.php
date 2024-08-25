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
  <center><br><h1>Accounts</h1></center>
  <div class="container">
  <div class="user-cards">
    <?php
    $select_users_query = "SELECT * FROM `users`";
    $select_users_result = mysqli_query($con, $select_users_query);

    if ($select_users_result) {
      if (mysqli_num_rows($select_users_result) > 0) {
        while ($fetch_users = mysqli_fetch_assoc($select_users_result)) {
                ?>
          <div class="box">
            <p><i class="bi bi-person-badge-fill"></i>  User ID: <span><?php echo $fetch_users['id']; ?></span></p>
            <p><i class="bi bi-person-bounding-box"></i>  User Type: <span style="color:<?php echo ($fetch_users['user_type'] === 'admin') ? '#8E06B4' : '#00C9B0'; ?>">
            <?php echo $fetch_users['user_type']; ?>
            </span></p>
            <p><i class="bi bi-person-fill"></i>  Name: <span><?php echo $fetch_users['fname']; ?> <?php echo $fetch_users['lname']; ?></span></p>
            <p><i class="bi bi-envelope-fill"></i>  Email: <span><?php echo $fetch_users['email']; ?></span></p>
            <i class="bi bi-trash-fill"></i><a href="admin-delete-user.php?uid=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Delete this user?');"> Delete</a>
          </div>
          <?php
        }
      } else {
            echo '<div class="empty">
                    <p>No users found</p>
                  </div>';
        }
        mysqli_free_result($select_users_result); // Free the result set
    } else {
        echo "Query failed: " . mysqli_error($con);
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
      justify-content: center; 
      flex-wrap: wrap;
    }
    .box {
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.189);
        padding: 2rem;
        text-align: left; 
        margin: 1rem;
        transition: transform 0.3s ease-in-out;
        font-family: 'Abel', sans-serif;
        font-size: 18px;
        flex: 0 0 calc(25% - 2rem);
    }
    .box:hover {
        transform: translate(0px, -8px);
    }
    .empty {
        width: 100%;
        text-align: center;
        margin-top: 1rem;
    }

</style>
</html>

