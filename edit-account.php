<?php
  
  session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

if (!$user_data) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Fetch the user details based on the user ID
$uid = $user_data['id'];

$select = $con->prepare("SELECT fname, lname, email, phone, address, user_name, password, img FROM users WHERE id = ?");
$select->bind_param("i", $uid); 
$select->execute();

// Bind results to variables
$select->bind_result($firstname, $lastname, $eMail, $number, $addrs,  $uname, $pword, $photo);

if ($select->fetch()) {
    // The values are now stored in the variables $firstname, $lastname, etc.
} else {
    // Handle the case where no rows were returned (user not found)
    echo "User not found.";
    // You might want to redirect or display an error message
    exit();
}
$select->close(); 

// Update account 
if (isset($_POST['update'])) {


  // Fetch the existing data
  $select = $con->prepare("SELECT * FROM users WHERE id = ?");
  $select->bind_param("i", $uid);
  $select->execute();
  
  $existingData = $select->get_result()->fetch_assoc();
  $select->close();

  // Get the new values from the form
  $fname = !empty($_POST['fname']) ? $_POST['fname'] : $existingData['fname'];
  $lname = !empty($_POST['lname']) ? $_POST['lname'] : $existingData['lname'];
  $email = !empty($_POST['email']) ? $_POST['email'] : $existingData['email'];
  $phone = !empty($_POST['phone']) ? $_POST['phone'] : $existingData['phone'];
  $address = !empty($_POST['address']) ? $_POST['address'] : $existingData['address'];
  $user_name = !empty($_POST['user_name']) ? $_POST['user_name'] : $existingData['user_name'];
  $password = !empty($_POST['password']) ? sha1($_POST['password']) : $existingData['password'];

  // Image handling
  $imgFile = $_FILES['img']['name'];
  $temp_name = $_FILES['img']['tmp_name'];
  $img_size = $_FILES['img']['size'];

  $upload_folder = "upload/";
  $imgExt = pathinfo($imgFile, PATHINFO_EXTENSION);
  $validExt = array('jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG');
  $newname = rand(1000, 1000000) . "." . $imgExt;

  // Validate and update the image if provided
  if (!empty($imgFile) && in_array($imgExt, $validExt) && $img_size < 5000000) {
      move_uploaded_file($temp_name, $upload_folder . $newname);
  } else {
      $newname = $existingData['img']; // Use the existing image if no new image is provided or if the provided image is invalid
  }

  // Update the user data
  $query = $con->prepare("UPDATE users SET fname = ?, lname = ?, email = ?, phone = ?, address = ?, user_name = ?, password = ?, img = ? WHERE id = ?");
  $query->bind_param("ssssssssi", $fname, $lname, $email, $phone, $address, $user_name, $password, $newname, $uid);
  $query->execute();
  $query->close();

  echo "<script>alert('Updated Successfully!')</script>";
  echo "<script>window.open('user-profile.php','_self')</script>";
}


?>
<!DOCTYPE html>
<html>
  <head>
    <title>Edit Account - Adiv</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arapey&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">

  </head>
  <form method="post" enctype="multipart/form-data">
  <body>
  
    <div id="banner">
      <div class="nav-bar">
        <div class="logo"><img src="images/logo.png" alt="Picture"></div>
          <ul>
            <li><a href="user-home.php">Home</a></li>
            <li><a href="user-home.php#product-header">Shop</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="user-home.php#about-us">About</a></li>
            <li><a href="search.php"><img src="images/search.png" id="search-icon" alt="Search Icon"></a></li>
            <li><a href="user-profile.php"><img src="images/user-iconn.png" id="user-icon" alt="User Icon"></a></li>
            <li><a href="checkout.php"><img src="images/cart-icon.png" id="cart-icon" alt="Cart Icon"></a></li>
          </ul>
      </div>
      
        <center><hr width="70"></center><br><br>
    <!-- Sign in -->
        <div class="container">
          <div class="card mx-auto" style="width: 25rem;">
            <div class="card-body">
              <div class="avatar"><img src="upload/<?php echo $photo?>" alt="Image"><br>
              <form method="post" enctype="multipart/form-data">
                  </div>
               <div class="input-container"><br>
               <h3>Edit your account</h3><br>
               
                <label>First name: </label><input type="text" name="fname" placeholder="<?php echo $firstname?>" ><br>
                <label>Last name: </label><input type="text" name="lname" placeholder="<?php echo $lastname?>"><br>
                <label>Email: </label><input type="email" name="email" placeholder="<?php echo $eMail?>"><br>
                <label>Contact: </label><input type="text" name="phone" placeholder="<?php echo $number?>"><br>

                <label>Address: </label><input type="text" name="address" placeholder="<?php echo $addrs?>"><br>
                <label>Username: </label><input type="text" name="user_name" placeholder="<?php echo $uname?>"><br>
                <div class="mb-3">
                <label>Password: </label><input type="password" name="password"  placeholder="Password" ><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" name="img">
               </div>  
             
                
                <button type="submit" class="btn btn-primary" name="update" value="Signup">Update</button>
              </form>
         
            </div>
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
  </form>

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
      margin: 0 20px;
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
    
    /*Sign-in card */
    .card {
      font-size: 16px;
      font-family: 'Jura', sans-serif;
      margin: 0px auto;
      text-align: center;
      background-color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      
    }
    .container {
      margin: 0 auto;
      justify-content: center;
      
    } 
    .input-container {
    white-space: nowrap; /* Prevent line break between label and input */
}

    label {
      font-size: 12px;
      width: 99px; /* Adjust the width as needed */
      border-radius: 5px;
      padding: 10px;
      margin: 7px;
      font-family: 'Jura', sans-serif;
      display: inline-block;
      vertical-align: top; /* Align the top edges of label and input */
      border: solid 1px #000;
      background-color: #CECECE;
    }
    input {
      width: 350px; /* Adjust the width as needed */
      border-radius: 5px;
      padding: 10px;
      margin: 7px;
      font-family: 'Jura', sans-serif;
      display: inline-block;
      vertical-align: top; /* Align the top edges of label and input */
    }
   
    .btn {
      font-family: 'Jura', sans-serif;
      width: 90px;
      height: 40px;
      border-radius: 5px;
      border: none;
      background-color: #000;
      color: #fff;
      margin: 10px;
    }
    .btn:hover {
      color:#000;
      background-color: #6e6e6e;
    }
    .btn:active {
      color:#000;
      background-color: #1a1919;
    }
    label {
      margin: 5px;

    }
   
    .avatar {
      width: 90px;
      height: 90px;
      overflow: hidden;
      border-radius: 50%;
      border: 1px solid #000;
      margin: auto; /* Center horizontally */
      
      align-items: center;
      justify-content: center; /* Center vertically */
  }
  
    .avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        cursor: pointer;
    }
    /*  FOOTER*/
    footer p {
      font-family: 'Abel', sans-serif;
      background-color:#e7e4e4;
      padding: 30px 30px 0 30px;
      line-height: 1.5;
      text-align: center;
      margin-top: 5%;
    }
      

  </style>
</html>