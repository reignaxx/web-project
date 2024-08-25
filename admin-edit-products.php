<?php
session_start();

include("connection.php");
include("functions.php");

// Ensure the user is logged in
$user_data = check_login($con);
if (!$user_data) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Fetch the product details based on the product ID
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $select = $con->prepare("SELECT product_name, product_price, full_description, direction, material, category, product_image FROM product WHERE id = ?");
    $select->bind_param("i", $productId);
    $select->execute();

    // Bind results to variables
    $select->bind_result($productName, $productPrice, $fullDescription, $direction, $material, $category, $productImage);

    if (!$select->fetch()) {
        // Handle the case where no rows were returned (product not found)
        echo "Product not found.";
        // You might want to redirect or display an error message
        exit();
    }

    $select->close();
} else {
    // Handle the case where no ID is provided
    echo "Product ID not provided.";
    exit();
}

// Update product
if (isset($_POST['update'])) {
    // Get the new values from the form
    $productName = !empty($_POST['product_name']) ? $_POST['product_name'] : $productName;
    $productPrice = !empty($_POST['product_price']) ? $_POST['product_price'] : $productPrice;
    $fullDescription = !empty($_POST['full_description']) ? $_POST['full_description'] : $fullDescription;
    $direction = !empty($_POST['direction']) ? $_POST['direction'] : $direction;
    $material = !empty($_POST['material']) ? $_POST['material'] : $material;
    $category = !empty($_POST['category']) ? $_POST['category'] : $category;

    // Image handling
    $imgFile = $_FILES['product_image']['name'];
    $temp_name = $_FILES['product_image']['tmp_name'];
    $img_size = $_FILES['product_image']['size'];

    $upload_folder = "images/";
    $imgExt = pathinfo($imgFile, PATHINFO_EXTENSION);
    $validExt = array('jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG');
    $newname = rand(1000, 1000000) . "." . $imgExt;

    // Validate and update the image if provided
    if (!empty($imgFile) && in_array($imgExt, $validExt) && $img_size < 5000000) {
        move_uploaded_file($temp_name, $upload_folder . $newname);
    } else {
        $newname = $productImage; // Use the existing image if no new image is provided or if the provided image is invalid
    }

    // Update the product data
    $query = $con->prepare("UPDATE product SET product_name = ?, product_price = ?, full_description = ?, direction = ?, material = ?, category = ?, product_image = ? WHERE id = ?");
    $query->bind_param("sssssssi", $productName, $productPrice, $fullDescription, $direction, $material, $category, $newname, $productId);
    $query->execute();
    $query->close();

    echo "<script>alert('Product Updated Successfully!')</script>";
    echo "<script>window.open('admin-products.php#products','_self')</script>";
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
      <div class="form-container">
      <div class="row justify-content-center">
         <div class="col-md-8"> <!-- Increase the width of the form container -->
               <form action="" enctype="multipart/form-data" method="post">
                  <div class="box">
                     <!-- Product Name and Price in a row -->
                     <div class="input-group row">
                           <div class="col-md-6">
                              <label>Product Name:</label>
                              <input type="text" name="product_name" placeholder="<?php echo $productName;?>">
                           </div>
                           <div class="col-md-6">
                              <label>Product Price:</label>
                              <input type="text" name="product_price" placeholder="<?php echo $productPrice;?>">
                           </div>
                     </div>
                     <!-- Description, Direction, and Material in a row -->
                     <div class="input-group row">
                           <div class="col-md-4">
                              <label>Product Description:</label>
                              <input type="text" name="full_description" placeholder="<?php echo $fullDescription;?>">
                           </div>
                           <div class="col-md-4">
                              <label>User Direction:</label>
                              <input type="text" name="direction" placeholder="<?php echo $direction;?>">
                           </div>
                           <div class="col-md-4">
                              <label>Product made of :</label>
                              <input type="text" name="material" placeholder="<?php echo $material;?>">
                           </div>
                     </div>
                     <!-- Category and Image in a row -->
                     <div class="input-group row">
                           <div class="col-md-6">
                              <label>Product Category:</label>
                              <input type="text" name="category" placeholder="<?php echo $category;?>">
                           </div>
                           <div class="col-md-6">
                              <label>Product Image:</label>
                              <div class="input-group mb-3">
                                 <input type="file" class="form-control" name="product_image">
                              </div>
                           </div>
                     </div>
                     <!-- Add button -->
                     <form method="post" enctype="multipart/form-data" >
                        <div class="input-group">
                           <button type="submit" id="btn" name="update">Update</button>
                        </div>
                     </form>
                  </div>
               </form>
            </div>
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

      @media screen and (max-width: 768px) {
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
         .container {
         grid-template-columns: repeat(1, 1fr);
      }
      }
      
      
      /* Modal */
      #userInfoModal {
         display: none;
         position: absolute;
         top: 30px; 
         right: 10px; 
         background-color: #f4f4f4;
         border: 1px solid #ddd;
         padding: 10px;
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

      .box {
         background: #fff;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.189);
         padding: 2rem;
         text-align: left;
         margin: 1rem auto; /* Center the box horizontally */
         max-width: 400px; /* Set a maximum width */
         width: 100%; /* Ensure it takes 100% width within its container */
         
         transition: transform 0.3s ease-in-out;
         font-family: 'Jura', sans-serif;
         }
         label {
         display: block;
         margin-bottom: 0.5rem;
         font-weight: bold;
         font-family: 'Abel', sans-serif;
   }

      input {
         width: 95%;
         padding: 0.5rem;
         margin-bottom: 1rem;
         border-radius: 5px;
         height: 25px;
         
      }
    

      .input-group {
         margin-bottom: 10px;
      }

      .box:hover {
         transform: translate(0px, -8px);
      }

      /* buttons */
      #btn-edit {
         width: 80px;
         height: 40px;
         background-color: #000;
         color: #fff;
         border-radius: 7px;
         border: none;
      }
      #btn-del {
         width: 80px;
         height: 40px;
         background-color: #E60000;
         border-radius: 7px;
         border: none;
         font-weight: bold;
      }
      #btn-edit:hover {
         background-color: #4A4A4A;
      }
      #btn-del:hover {
         background-color: #CE2525;
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
      /* Add product */
      #btn {
         background-color:#000; 
         color: #fff; 
         width: 75px;
         height: 40px;
         text-align: center;
         border-radius: 5px; 
         border: none;
         display: block;
         margin: auto;
      }
      #add-btn:hover {
         background-color: #444547;
      }
      /* display products */
      .container {
      padding: 2% 8%;
      display: flex;
      flex-direction: column;
      align-items: center;
   }

   .card {
      background: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.189);
      padding: 1.5rem;
      text-align: left;
      transition: transform 0.3s ease-in-out;
      font-family: 'Abel', sans-serif;
      display: flex;
      flex-direction: row; /* Display in a row instead of column */
      margin-bottom: 1rem; /* Add space between cards */
   }

   .card-img-left {
      max-width: 40%; /* Adjust the width of the image */
      margin-right: 1rem; /* Add space between image and text */
   }

   .card-body {
      flex-grow: 1;
   }

   .card-body h3 {
      font-size: 20px;
      font-weight: bold;
   }

 </style>
</html>
