<?php 
 
  session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

  if ($user_data['user_type'] !== 'admin') {
    header("Location: user-home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $productName = $_POST["product_name"];
    $productPrice = $_POST["product_price"];
    $fullDescription = $_POST["full_description"];
    $category = $_POST["category"];
    $direction = $_POST["direction"];
    $material = $_POST["material"];

    // Process the image file
    $productImage = $_FILES["product_image"]["name"];
    $targetDirectory = "images/"; // Set the directory where you want to store images
    $targetFile = $targetDirectory . basename($productImage);

    // Move the uploaded file to the specified directory
    move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile);

    // SQL query to insert data into the product table
    $sql = "INSERT INTO product (product_name, product_price, full_description, category, product_image, direction, material)
            VALUES ('$productName', '$productPrice', '$fullDescription', '$category', '$productImage', '$direction', '$material')";

    // Execute the query
    if (mysqli_query($con, $sql)) {
        echo "Product added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
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
    <center><h1>Add Products</h1></center>
    

    <div class="form-container">
    <div class="row justify-content-center">
        <div class="col-md-8"> <!-- Increase the width of the form container -->
            <form action="" enctype="multipart/form-data" method="post">
                <div class="box">
                    <!-- Product Name and Price in a row -->
                    <div class="input-group row">
                        <div class="col-md-6">
                            <label>Product Name:</label>
                            <input type="text" name="product_name" required>
                        </div>
                        <div class="col-md-6">
                            <label>Product Price:</label>
                            <input type="text" name="product_price" required>
                        </div>
                    </div>
                    <!-- Description, Direction, and Material in a row -->
                    <div class="input-group row">
                        <div class="col-md-4">
                            <label>Product Description:</label>
                            <input type="text" name="full_description" required>
                        </div>
                        <div class="col-md-4">
                            <label>User Direction:</label>
                            <input type="text" name="direction" required>
                        </div>
                        <div class="col-md-4">
                            <label>Product made of :</label>
                            <input type="text" name="material" required>
                        </div>
                    </div>
                    <!-- Category and Image in a row -->
                    <div class="input-group row">
                        <div class="col-md-6">
                            <label>Product Category:</label>
                            <input type="text" name="category" required>
                        </div>
                        <div class="col-md-6">
                            <label>Product Image:</label>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" name="product_image" required>
                            </div>
                        </div>
                    </div>
                    <!-- Add button -->
                    <div class="input-group">
                        <button type="submit" id="btn" name="add-product">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><br>
<center><h1 id="products">Existing Products</h1></center>
<?php
      $sql = "SELECT * FROM product";
      $result = mysqli_query($con, $sql);
      if ($result) {
      ?>
<div class="container">
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        // Extract product details
        $productId = $row['id'];
        $productName = $row['product_name'];
        $productPrice = $row['product_price'];
        $productImage = $row['product_image'];
        $fullDescription = $row['full_description'];
        $direction = $row['direction'];
        $material = $row['material'];
    ?>

    <div class="card-container">
        <div class="card">
            <img src="images/<?php echo $productImage; ?>" class="card-img-left" alt="Product Image">
            <div class="card-body">
                <div class="card-title"><h3><?php echo $productName; ?></h3></div>
                <h3>Description</h3>
                <p class="card-text"><?php echo $fullDescription; ?></p>
                <h3 class="card-text">₱<?php echo $productPrice; ?>.00</h3>
                <div class="two-columns">
                    <div class="column">
                        <h3>Direction</h3>
                        <p class="card-text"><?php echo $direction; ?></p>
                    </div>
                    <div class="column">
                        <h3>Material</h3>
                        <p class="card-text"><?php echo $material; ?></p>
                    </div>
                </div>
                <div class="card-buttons">
                  <a href="admin-edit-products.php?id=<?php echo $productId; ?>"><button id="btn-edit">Edit</button></a>
                  <a href="admin-delete-products.php?id=<?php echo $productId; ?>"><button id="btn-del">Delete</button></a>
               </div>
            </div>
        </div>
    </div>

    <?php
    }
    ?>
</div>

<?php
}
?>

   
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
    font-family: 'Abel', sans-serif;
   }
   label {
    display: block;
    margin-bottom: 0.5rem;
    font-family: 'Abel', sans-serif;
    font-weight: bold;
}

   input {
      width: 95%;
      padding: 0.5rem;
      margin-bottom: 1rem;
      border-radius: 5px;
      
   }
   #desc input {
      width: 95%;
      padding: 0.5rem;
      margin-bottom: 1rem;
      height: 45px;
      word-wrap: break-word;
      
   }

   .input-group {
      margin-bottom: 15px;
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
        font-family: 'Abel', sans-serif;
    }

    input[name="update_order"] {
        padding: 8px 16px;
        font-size: 14px;
        background-color: #A7A7A7;
        color: #000; /* Text color */
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-family: 'Abel', sans-serif;
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

 h3 {
    font-size: 20px;
    font-weight: bold;
}

 </style>
</html>

