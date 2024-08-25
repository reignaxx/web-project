<?php

include("connection.php"); 

$sql = "SELECT * FROM product";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Adiv</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arapey&display=swap" rel="stylesheet">
    <link href="https://api.fontshare.com/v2/css?f[]=melodrama@500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    

  </head>

  <body>
    <div id="banner">
      <div class="bar">Guest Mode</div>
      <div class="nav-bar" id="navi">
         <div class="logo"><img src="images/logo.png" alt="Picture"></div>
            <ul>
               <li><a href="home.php">Home</a></li>
               <li><a href="#categories">Shop</a></li>
               <li><a href="signin-page.php">Sign in</a></li>
               <li><a href="#contact">Contact</a></li>
               <li><a href="#about-us">About</a></li>
               <li><form action="search.php" method="GET" class="navbar-form search-form" role="search">
                  <input type="text" class="form-control" placeholder="Search" name="search-non">
                  <button class="btn btn-default" type="submit"></button>
                  </form>
               </li>
            </ul>
         </div>
      </div>
      <div class="content">
         <h3>SKIN CARE THAT CARES</h3>
         <h1>Our skin care products are gentle <br>on your skin, but tough <br>on your problems.</h1>
         <a href="#categories"><button class="shop-btn" type="button">SHOP NOW</button></a><br>
      </div>
    
    
    
    <div id="about">
      <div id="about1"><h2>Nourish, protect, and glow.</h2></div>.
      <div id="about2">Adiv products are made with natural and organic ingredients that nourish and protect your skin that are developed by expert dermatologists<br> who understand the needs of your skin. We deliver gentle yet effective results for all skin types. We strive to bring out your <br>confidence to show your natural beauty.<br><br></div>
    </div>
  <!-- Category selection -->
  <?php  
$categoryQuery = "SELECT DISTINCT category FROM product";
$categoryResult = mysqli_query($con, $categoryQuery); 

if ($categoryResult) {
    ?>
    <div id="categories">
        <center>
            <h1><br>CATEGORIES</h1>
            <form action="category.php" method="post">
                <select name="selected_category" class="category-dropdown">
                    <option value="all">All Categories</option>
                    <?php 
                    while ($row = mysqli_fetch_assoc($categoryResult)) { 
                        $category = $row['category']; 
                        ?>
                        <option value="<?php echo $category;?>" ><?php echo $category; ?></option>
                    <?php } ?>
                </select>  
                <button type="submit" class="filter-button">Filter</button>
            </form>
        </center>
    </div>
    <?php 
} else {
    
    echo "Error retrieving categories.";
}
?>

   <!--Product Gallery-->
    <div id="product-header"><br>ALL PRODUCTS</div>
    <?php 
    while ($row = mysqli_fetch_assoc($result)) {
      // Get product fields
      $id = $row['id'];
      $name = $row['product_name'];
      $img = $row['product_image'];
      $price = $row['product_price'];
      $category = $row['category'];
      $fulldesc = $row['full_description'];
    
      ?>
      
    
      <!-- product modals -->
      <div class="products">
         <img src="images/<?php echo $img?>" alt="Image" class="product-img">
         <div class="product-name" id="myBtn<?php echo $id; ?>">
            <?php echo $name;?>
         </div>
         <form action="action.php" method="post" enctype="multipart/form-data">
            <div class="price">₱<?php echo $price;?>.00</div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="number" id="quantity<?php echo $id; ?>" name="quantity" value="1" min="1"> 
            <button class="cart-btn" type="submit" name="add">Add to cart</button>
         </form>
      </div>
    
  <!----------Modals------ -->
    <div id="myModal<?php echo $id?>" class="modal">
      <div class="modal-content">
        <div class="modal-header">
          <span class="close<?php echo $id?>" id="close-btn">&times;</span>
          <h2>Product Details</h2>
        </div>
        <div class="modal-body">
          <div id="product-detail">
              <div class="row">
                <div class="col-2">
                  <img src="images/<?php echo $row['product_image'];?>" width="50%">
                </div>
                <div class="col-2">
                  <p><?php echo $row['category'];?></p>
                  <h1><?php echo $row['product_name'];?></h1>
                  <h4>₱<?php echo $row['product_price'];?>.00</h4>
                  <h3>Description</h3>
                  <p><?php echo $row['full_description']; ?></p>
                  <h3>Direction</h3>
                  <p><?php echo $row['direction'];?></p>
                  <h3>Caution</h3>
                  <p>See product label.</p>
                  <h3>Made of the following:</h3>
                  <p><?php echo $row['material'];?></p>
                 
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
    <?php 
  } ?>
    <div id="about-us">
      <h1>About us</h1>
      <p>Adiv is a company that specializes in natural and organic skin-care products. Adiv believes that beauty comes from within, and that the best way to nourish your skin is to use ingredients that are gentle, effective, and environmentally friendly. Adiv offers a range of products for different skin types and needs, such as cleansers, moisturizers, serums, and more. Adiv's products are made with high-quality botanical extracts, essential oils, and vitamins that provide hydration, protection, and rejuvenation for your skin. Adiv's products are also cruelty-free, vegan, and free of parabens, sulfates, and artificial fragrances. Adiv's mission is to help you achieve healthy, radiant, and beautiful skin with natural and organic solutions.
      </p>
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
        77 Don Maria St., Aliw Avenue, Nowhere City
      </p>
    </footer>
    </div>
  </body>


  <style>
 
    @media screen and (max-width: 600x) {
      .products {
        width: 100%;
        margin: 5px;
      }
    }

    *{
      margin:0;
      padding: 0;
      
      
      /* font-family: 'Jura', sans-serif; */
    }

    html {
      scroll-behavior: smooth;
    }
    body {
      justify-content: center;
      text-align: center;
      justify-content: center;
      align-items: center;
      align-content: center;
    }
    #blckcart-icon {
      width: 27px;
      margin-top: 4px;
      display: inline;
    }
    #blckcart-icon:hover {
      cursor: pointer;
      transform: scale(1.2); 
    }
    .product-name:hover {
      color: #0046D1;
      transform:scale(1.02);
    }
    /* Modal function */
      
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
      font-size: 100%;
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
    input {
      width: 40px;
      height: 36px;
      padding-left: 12px;
      font-size: 15px;
      margin-right:7px;
      border: 1px solid #777777;
      border-radius: 10px;
      display: inline-block;
      float: left;
    }
    .btns {
      margin: 20px;
      text-align: center;
    }
      
    .buy-cart-btn {
      color:#fff;
      font-family: 'Abel', sans-serif;
      width: 100px;
      height: 40px;
      font-size: 15px;
      text-align: center;
      background-color:#000;
      border: none;
      border-radius: 10px;
      display: inline-block;
      float: left;
    }
    button:hover {
      background-color: #cacaca;
      color: #000
    }
    button:active {
      background-color: #000;
      color: #fff;
    }
    #banner {
      width: 100%;
      height:100vh;
      background-image: url(bg-image.jpg);
      background-size: cover;
      background-position: center;
      
    
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
        color: #fff;
    }

    .nav-bar .btn-default {
        border-radius: 0 5px 5px 0;
    }
   /*Navigation bar  */
    .bar {
      background-color:#000;
      color: #fff;
      height: 20px;
      padding: 10px;
      text-align: center;
      font-family: 'Jura', sans-serif;
      /* position: fixed; */
      
    }
    
    .nav-bar { 
      width: 95%;
      margin: auto;
      margin-top: -20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-family: 'Jura', sans-serif;
    }
    
    
    .logo img {
      width: 150px;
      cursor: pointer;
      filter: brightness(10);
      
      
    }
    #user-icon{
      width: 20px;
      margin-top: 3px;
      
    }
    #cart-icon, span {
      width: 20px;
      filter:invert(100);
    }
    .nav-bar ul li {
      list-style: none;
      display: inline-block;
      margin: 0 15px;
      position:relative;
      
    }
    .nav-bar ul li a {
      text-decoration: none;
      color: #fff;
      text-transform: uppercase;
      
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
    /* -------------------------- */
    .content {
      font-family: 'Jura', sans-serif;    
      color: #fff;
      text-align: center;
      font-size:25px;
      width: 100%;
      position: absolute;
      top: 35%;
      
      
    }
    .content h1{
      font-size: 45px;
      
    }
    
    .shop-btn {
      width: 150px;
      padding: 15px 0;
      text-align: center;
      margin: 20px 10px 0px;
      font-size: 15px;
      font-weight:100px;
      color:#fff;
      background-color:#000;
      border: none;
      cursor:pointer;
    }
    
    .shop-btn:hover {
      background-color: #fff;
      color: #000
    }
    .shop-btn:active {
      background-color: #000;
      color: #fff;
    }
    #about #about1 {
      font-size: 30px;
      text-align: center;
      justify-content: center;
      padding: 20px;
      font-family: 'Arapey', serif;
      margin-top: 30px;
    }
    #about #about2 {
      font-size: 20px;
      text-align: center;
      justify-content: center;
      line-height: 1.2;
      font-family: 'Arapey', serif;
    }
    #categories h1 {
      font-family: 'Jura', sans-serif;
    }
     /* Category */
    .category-dropdown {
      width: 230px;
      padding: 10px;
      font-size: 16px;
      border: 2px solid #000; /* Border color */
      border-radius: 5px; /* Rounded corners */
      margin-right: 10px;
}

   .filter-button {
      width: 70px;
      height: 40px;
      padding: 10px;
      font-size: 16px;
      background-color: #000; 
      color: #fff;
      border: none; 
      border-radius: 5px; 
      cursor: pointer;
   }

   .filter-button:hover {
      background-color: #505050; 
   }
    /* Product Gallery */

    #product-header{
      font-size: 35px;
      text-align: center;
      margin-bottom: 20px;
      font-family: 'Jura', sans-serif;
    }
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

    .product-name a:hover {
      color: #4400b1;
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
      
      border: 1px solid #777777;
      border-radius: 10px;
      margin-left: 7%;
      display: inline-block;
      
         
   }

    .cart-btn {
      text-align: center;
      font-size: 14px;
      font-family: 'Abel', sans-serif;
      object-fit: scale-down;
      border-radius: 10px;
      
      border: none;
      display: inline-block;
   }

   .cart-btn {
      color: #fff;
      background-color: #000;
      width: 30%; /* Adjust the width as needed */
      padding: 10px;
   }

   

    .buy-btn:hover, .cart-btn:hover {
      transform:scale(1.02);
      filter: invert(30%);
      
    }
    #about-us h1 {
      text-align: center;
      font-size: 50px;
      margin-top: 50px;
    }
    #about-us p{
      font-family: 'Arapey', serif;
      font-size: 20px;
      justify-content: center;
      padding: 50px 90px 30px 90px;
      line-height: 1.2;
    }

    /*  FOOTER*/
    footer p {
      font-family: 'Abel', sans-serif;
      background-color:#e7e4e4;
      padding: 30px 30px 0 30px;
      line-height: 1.5;
      text-align: center;
    }
      
    
    
    
    

  </style>
</html>