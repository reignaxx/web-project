<?php



include("connection.php");

// Check if the search query is provided
if (isset($_GET['search-non'])) {
    $searchTerm = $_GET['search-non'];

    // Perform a search query in the database
    $searchQuery = "SELECT * FROM product WHERE product_name LIKE ?";
    $stmt = $con->prepare($searchQuery);
    
    // Add wildcard '%' to search for partial matches
    $searchTerm = '%' . $searchTerm . '%';
    $stmt->bind_param("s", $searchTerm);
    
    $stmt->execute();
    $result = $stmt->get_result();

   
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Search - Adiv</title>
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
              <li><a href="home.php">Home</a></li>
              <li><a href="home.php#categories">Shop</a></li>
              <li><a href="signin-page.php">Sign in</a></li>
              <li><a href="#contact">Contact</a></li>
              <li><a href="home.php#about-us">About</a></li>
              <li>
               <form action="search.php" method="GET" class="navbar-form search-form" role="search">
                  <input type="text" class="form-control" placeholder="Search" name="search-non">
                  <button type="submit"></button>
               </form>
              </li>
            </ul>
        </div>
    <center><hr width="70"></center>
    <?php 
     // Display search results
     if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc())  {
        $id = $row['id'];
        $name = $row['product_name'];
        $img = $row['product_image'];
        $direction = $row['direction'];
        $price = $row['product_price'];
        $category = $row['category'];
        $fulldesc = $row['full_description'];
        $material = $row['material']; ?>
        <!-- Product cards -->
    <div class="products">
         <img src="images/<?php echo $img;?>" alt="Image" class="product-img">
         <div class="product-name" id="myBtn<?php echo $id; ?>">
            <?php echo $name;?>
         </div>
         <form action="action.php" method="post" enctype="multipart/form-data">
            <div class="price">₱<?php echo  $price;?>.00</div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="number" id="quantity<?php echo $id; ?>" name="quantity" value="1" min="1"> 
            <button class="cart-btn" type="submit" name="add">Add to cart</button>
         </form>
      </div>

    <!-- Modal for product details -->
    <div id="myModal<?php echo $id?>" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <span class="close<?php echo $id; ?>" id="close-btn">&times;</span>
          <h2>Product Details</h2>
        </div>
        <div class="modal-body">
          <div id="product-detail">
              <div class="row">
                <div class="col-2">
                  <img src="images/<?php echo $img;?>" width="50%">
                </div>
                <div class="col-2">
                  <p><?php echo $category;?></p>
                  <h1><?php echo $name;?></h1>
                  <h4>₱<?php echo $price;?>.00</h4>
                  <h3>Description</h3>
                  <p><?php echo $fulldesc; ?></p>
                  <h3>Direction</h3>
                  <p><?php echo $direction?></p>
                  <h3>Caution</h3>
                  <p>See product label.</p>
                  <h3>Made of the following:</h3>
                  <p><?php echo $material;?></p>
                  
                   
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
    <script>
      var modal<?php echo  $id?> = document.getElementById("myModal<?php echo  $id?>"); // Get the modal 
      var btn<?php echo  $id?> = document.getElementById("myBtn<?php echo  $id;?>"); // Get the button that opens the modal
      var span<?php echo  $id?> = document.getElementsByClassName("close<?php echo $id?>")[0]; // Get the <span> element that closes the modal
      
      btn<?php echo  $id?>.onclick = function() {
      modal<?php echo  $id?>.style.display = "block";  // opens when clicked
      
      }
      span<?php echo  $id?>.onclick = function() {   // opens the modal when clicked
      modal<?php echo  $id?>.style.display = "none";
      }
      window.onclick = function(event) {   // Close when clicks anywhere outside of the modal
      if (event.target == modal<?php echo  $id?>) {
        modal<?php echo  $id?>.style.display = "none";
      }
      }


    </script>
        
    <?php  } 
  } else {
      echo "<h1>No products found.</h1>";
  }

  $stmt->close();
} else {
  // Handle the case where no search query is provided
  echo "No search query provided.";
}
  ?>
    
    </div>
    
  </body>


  <style>
    @media only screen and (max-width: 768px) {
      .products {
        width: 100%;
        margin: 5px;
      }
    [class*="box-"] {
      width: 100%;

      
     
  }
}
    *{
      margin:0;
      padding: 0;
      
    }
    body {
      justify-content: center;
      text-align: center;
      justify-content: center;
      align-items: center;
      align-content: center;
    }
    /* Product cards */
    .product-name {
      text-align: center;
      font-size: 22px;
      font-weight: bold;
      color: #000;
      padding: 5px;
      margin-left: 15px;
      margin-right: 20px;
      font-family: 'Abel', sans-serif;
      object-fit: scale-down;
      align-items: center;
      align-content: center;
    }

    .product-name:hover {
      color: #0046D1;
      transform:scale(1.02);
    }

    .products {
      width: 25%; /* Reduced width */
      margin: 15px;
      box-sizing: border-box;
      text-align: center;
      justify-content: center;
      align-items: center;
      align-content: center;
      cursor: pointer;
      padding-bottom: 8px;
      height: 15%;
      box-shadow: #000;
      transition: .4s;
      background: #f2f2f2;
      box-shadow: 3px 3px 3px #b6b6b6;
      display: inline-block;
    }

    .products:hover {
      transform: translate(0px, -8px);
    }

    .product-img {
      width: 100%;
      object-fit: cover;
      margin-bottom: 3%;
      text-align: center;
      margin: auto;
      display: block;
    }

    .price {
      font-size: 20px;
      text-align: center;
      color: #000;
      margin: 0;
      padding: 10px; /* Reduced padding */
      font-family: 'Abel', sans-serif;
    }
    input {
      width: 10%; /* Adjust the width as needed */
      height: 33px;
      padding-left: 12px;
      font-size: 15px;
      margin-right: 7px;
      border: 1px solid #777777;
      border-radius: 10px;
      display: inline-block;
         
   }

    .cart-btn {
      text-align: center;
      font-size: 14px;
      font-family: 'Abel', sans-serif;
      object-fit: scale-down;
      border-radius: 10px;
      margin: 5px;
      border: none;
      display: inline-block;
   }

   .cart-btn {
      color: #fff;
      background-color: #000;
      width: 30%; 
      padding: 10px;
   }

   .view-btn {
      color: #000;
      background-color: #f2f2f2;
      width: 19%;
      padding: 10px;
      border: 1px solid #000;
      font-size: 13px;
      border-radius: 10px;
   }
      
    .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 1; /* Sit on top */
      padding-top: 30px; /* Location of the box */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
      
      
    }

    /* Modal Content */
    .modal-content {
      display: flex;
      flex-wrap: wrap;
      position: relative;
      background-color: #fefefe;
      margin: auto;
      padding-bottom: 20px;
      border: 1px solid #888;
      width: 80%;
      font-family: 'Arapey', serif;
      text-align: left;
      box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
      -webkit-animation-name: animatetop;
      -webkit-animation-duration: 0.4s;
      animation-name: animatetop;
      animation-duration: 0.7s
    }

    /* Add Animation */
    @-webkit-keyframes animatetop {
      from {top:-300px; opacity:0} 
      to {top:0; opacity:1}
    }

    @keyframes animatetop {
      from {top:-300px; opacity:0}
      to {top:0; opacity:1}
    }

    /* The Close Button */
    #close-btn {
      color: #fff;
      float: right;
      font-size: 30px;
      font-weight: bold;
      filter: brightness(100);
      margin-right: 7px;
    }

    #close-btn:hover, #close-btn:focus {
      cursor: pointer;
      transform: scale(1.2);
    }

    .modal-header {
      padding: 1px 0 1px 0;
      background-color: #000;
      color: #fff;
      font-family: 'Abel', sans-serif;
      text-align: center;
      font-size: 10px;
      width:100%;
      height: 30px; /* add a height value */
      line-height: 30px; 
      
    }

    .modal-body {padding: 2px 10px;}

    
    /* Single product detail */
    #product-detail {
      margin-top: 1%;
      margin-bottom: 2%;
      font-family: 'Abel', sans-serif;
      font-size: 18px;
      
    }
    #product-detail .col-2 {
      padding:10px;
      padding-right: 40px;
      
    }
    #product-detail .col-2 {
      padding:15px;
      justify-content: left;
      word-wrap: break-word;
      padding-right: 40px;
      font-family: 'Arapey', serif;
      
    }
    #product-detail h1, h3{
      font-family: 'Abel', sans-serif;
      
    }
    #product-detail h4 {
      margin: 10px;
      font-size: 18px;
      font-weight: bold;
      font-family: 'Abel', sans-serif;
    }
    .col-2 img {
      width: 49%;
      height: auto;
      float: left;
      margin-right: 20px;
      object-fit: scale-down;
      display: block;
    }
    
    .btns {
      margin: 20px;
      text-align: center;
    }
   
    button:hover {
      background-color: #cacaca;
      color: #000
    }
    button:active {
      background-color: #000;
      color: #fff;
    }
   
    
    /* Search bar */
    .nav-bar form {
      display: flex;
      align-items: center;
   }

   .nav-bar .form-control {
      border-radius: 5px;
      width: 110px;
      background-color: rgba(122, 122, 122,  0.2); 
      border: 1px solid #D7D7D7; 
      color: #000;
   }

   .nav-bar .btn-default {
      border-radius: 0 5px 5px 0;
   }
    
   
    /*Navigation bar  */
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
    #search-icon {
      width: 20px;
    }
    #cart-icon {
      width: 20px;
    }
    .nav-bar ul li {
      list-style: none;
      display: inline-block;
      margin: 0 15px ;
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