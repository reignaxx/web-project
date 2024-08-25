<?php 
   
   session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Profile - Adiv</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arapey&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">

  </head>

  <body>
    <div id="banner">
        <div class="nav-bar">
          <div class="logo"><img src="images/logo.png" alt="Picture"></div>
            <ul>
              <li><a href="user-home.php">Home</a></li>
              <li><a href="user-home.php#categories">Shop</a></li>
              <li><a href="#contact">Contact</a></li>
              <li><a href="user-home.php#about-us">About</a></li>
              <li>
               <form action="user-search.php" method="GET" class="navbar-form search-form" role="search">
                  <input type="text" class="form-control" placeholder="Search" name="search">
                  <button type="submit"></button>
               </form>
              </li>
              <li><a href="user-profile.php"><img src="images/user-iconn.png" id="user-icon" alt="User Icon"></a></li>
              <li><a href="checkout.php"><img src="images/cart-icon.png" id="cart-icon" alt="Cart Icon"></a></li>
            </ul>
        </div>
    <center><hr width="70"></center>
    <!-- User Profile -->
    <div class="container">
      <div class="side">
        <div class="left">
          <center><img src="upload/<?php echo $user_data['img'];?>" width="100" alt="User Image" id="user-img"></center>
          <h2><?php echo $user_data['fname'];?> <?php echo $user_data['lname'];?></h2>
          <h3>@<?php echo $user_data['user_name'];?></h3><br><br>
          <a href="#"><button>My Orders</button><br></a>
          <a href="user-home.php#product-header"><button>Browse Products</button></a><br>
          <a href="edit-account.php?uid=<?php echo $user_data['id']; ?>"><button>Edit Account</button></a>
          <a href="delete-account.php?uid=<?php echo $user_data['id'];?>" onclick="return confirm('Are you sure you want to delete your account?')"><button>Delete Account</button><br></a>
          <a href="signout.php"><button>Log out</button></a>
        </div>
        
      </div>
  
      <div class="side">
        <div class="content"><br>
        <h1>Profile</h1>
        <table>
          <tr>
            <td><b>Email: </b><?php echo $user_data['email']; ?></td>
            <td><b>Contact No: </b><?php echo $user_data['phone']; ?></td>
            <td><b>Address: </b><?php echo $user_data['address']; ?></td>
          </tr><br>
        </table><br><br>
          <h1>My Orders</h1><br>
          <table>
            <tr>
              <th>Date</th>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Amount Due</th>
              <th>Status</th>
            </tr>
            <?php
             
              // Assuming $user_id contains the ID of the current user
              $user_id = $user_data['id']; // Adjust this according to your user ID retrieval logic
          
              $select_query = mysqli_prepare($con, 'SELECT placed_orders.*, product.product_name, product.product_price
               FROM placed_orders
               JOIN product ON placed_orders.product_ID = product.id
               JOIN users ON placed_orders.customer_ID = users.id
               WHERE placed_orders.customer_ID = ?
               ORDER BY placed_orders.order_date DESC'); 

               mysqli_stmt_bind_param($select_query, "i", $user_id);
               mysqli_stmt_execute($select_query);
               $result = mysqli_stmt_get_result($select_query);

               $sum = 0;
               while ($row = mysqli_fetch_assoc($result)) {
                  $productName = $row['product_name'];
                  $productPrice = $row['product_price'];
                  $quantity = $row['qty'];
                  $date = $row['order_date'];
                  $status = $row['status'];

                                 // Rest of your code...
                           
          ?>
          
            <tr>
              <td><?php echo $date; ?></td>
              <td><?php echo $productName; ?></td>
              <td><?php echo $quantity; ?></td>
              <td>₱ <?php echo number_format($productPrice,2); ?></td>
              <td>₱ <?php echo number_format($productPrice*$quantity,2 );?></td>
              <td><?php echo $status;?></td>
              <?php } ?>
          </table>
          
        </div>
        
      </div>
    </div>
    
    
       

    
    <!--Footer-->
    <footer id="contact">
      <p> 
        CONTACT US<br>
        (049) 808-2293<br>
        +63 9711281611<br>
        adiv.inc@gmail.com<br>
        IG: @adiv.inc<br><br>
        Return Policy<br>
        <a href="terms-and-condition.php">Terms and Condition<br></a>
        77 Don Maria St., Aliw Avenue, Nowhere City<br>
        All rights reserve.
      </p>
    </footer>
    </div>
    
  </body>


  <style>
    @media only screen and (max-width: 768px) {
    [class*="box-"] {
      width: 100%;

      .products {
        width: 90%;
        height: auto;
      }
      .product-img {
        height: auto;
      }
  
      .product-desc {
        height: auto;
      }
  }
}
    *{
      margin:0;
      padding: 0;
      
    }
    #banner {
      width: 100%;
      height:100vh;
      
      background-size: cover;
      background-position: center;
    }
    .nav-bar { 
      width: 100%;
      height: 90px;
      margin: auto;
      margin-top: -5px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #F2F2F2;
    }
    .logo img {
      width: 150px;
      cursor: pointer;
    }
    #user-icon{
      width: 20px;
      margin-top: 3px;
      filter:invert(100)
    }
    /* Search bar */
    .nav-bar form {
      display: flex;
      align-items: center;
   }

   .nav-bar .form-control {
      border-radius: 5px;
      height: 30px;
      width: 110px;
      background-color: rgba(122, 122, 122,  0.2); 
      border: 1px solid #D7D7D7; 
      color: #000;
      padding: 3px;
   }
  
   .nav-bar .btn-default {
      border-radius: 0 5px 5px 0;
   }
    #cart-icon {
      width: 20px;
    }
    .nav-bar ul li {
      list-style: none;
      display: inline-block;
      margin: 0 20px ;
      position:relative; 
    }
    .nav-bar ul li a {
      text-decoration: none;
      color: #000;
      text-transform: uppercase;
      font-family: 'Jura', sans-serif;
    }
    .nav-bar ul li::after {
      content:'';
      height: 2px;
      width: 0;
      background: #000;
      position: absolute;
      left: 0;
      bottom: -10px;
      transition: 0.5s;
    }
    .nav-bar ul li:hover::after {
      width: 100%;
    }
    a {
      text-decoration: none;
    }
    /* -------------Content------------- */
    .container {
      display: flex;
      flex-wrap: wrap;
      margin-bottom: 10%;
      font-family: 'Abel', sans-serif;
      position: relative;
      
    }
    
    .side {
      /* float:left; */
      justify-content: left;
      
    }
    .side .left {
      
      justify-content: left;
      overflow-wrap: break-word;
      width:200px;
      padding:40px;
      position: relative;
      text-align: center;
      
    }
    /* .side .content {
      padding: 20px;
      width:300px;
    } */
    table {
      padding: 15 10px 15px 10px;
      
    }
    th {
      background-color:#e7e4e4;
      padding: 15px 40px 15px 40px;
      
    }
    .side td {
      padding: 15px 40px 15px 40px;
      background-color:#e7e4e4;
      text-align: center;

    }
    #user-img img{
      width: 100%;
        height: 100%;
        object-fit: cover;
        cursor: pointer;
    }
    #user-img {
      width: 90px;
      height: 90px;
      overflow: hidden;
      border-radius: 50%;
      border: 1px solid #000;
    }
    button {
      width: 100%;
      height: 50px;
      color: #000000;
      background-color: #e7e4e4;
      border: none;
      margin: 5px;
      font-family: 'Jura', sans-serif;
      
    }
    button:hover {
      box-shadow: 3px 3px 3px #b6b6b6;
      transform:scale(1.02);
      cursor: pointer;
    }
    
   
    /*  FOOTER*/
    footer p{
      font-family: 'Abel', sans-serif;
      background-color:#e7e4e4;
      padding: 30px 30px 0 30px;
      line-height: 1.5;
      text-align: center;
      text-decoration:none;
      
      
      

    }
      

  </style>
</html>