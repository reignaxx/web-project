<?php 
session_start();

	include("connection.php");
	include("functions.php");

	 
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
    $user_type = $_POST['user_type'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$user_name = $_POST['user_name'];
		$password = sha1($_POST['password']);
		//image file handling
    $imgFile = $_FILES['img']['name'];
    $temp_name = $_FILES['img']['tmp_name'];
    $img_size = $_FILES['img']['size'];

    $upload_folder = "upload/";  //folder

    //file extension
    $imgExt = pathinfo($imgFile, PATHINFO_EXTENSION);
    
    //validating
    $validExt = array('jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG');

		//renaming image file
    $newname = rand(1000, 1000000).".".$imgExt;


		if (in_array($imgExt, $validExt)){
			//validating file size
			if ($img_size < 5000000){
				move_uploaded_file($temp_name,$upload_folder.$newname );

				if(!empty($user_name) && !empty($password) && !is_numeric($user_name)) {

					$query = "select user_name from users where user_name = '$user_name' limit 1"; 
					$result = mysqli_query($con, $query);
		
					if($result && mysqli_num_rows($result) > 0) {
					
						//username already exists, display an error message
						echo "<script>alert('Username $user_name is already taken!')</script>";
						echo "<script>window.open('signup-page.php','_self')</script>";  
					}
					else {
						//save to database
						//$user_id = random_num(20);
						$query = "insert into users ( user_type, fname, lname, email, phone, address,  user_name, password, img) values ( '$user_type','$fname', '$lname', '$email', '$phone', '$address','$user_name','$password', '$newname')";
			
						mysqli_query($con, $query);
			
						header("Location: signin-page.php");
						die;
						}
						
				}else {
					echo "Please enter some valid information!";
				}
		
			}
			else {
				echo "<script>alert('Your file is too large!')</script>";
				echo "<script>window.open('signup-page.php','_self')</script>";  
			} 
		} 
		else {
			echo "<script>alert('Only jpg, jpeg, and png file is allowed!')</script>";
			echo "<script>window.open('signup-page.php','_self')</script>";
		}

	}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Sign-up - Adiv</title>
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
              <li><a href="home.php">Home</a></li>
              <li><a href="home.php#categories">Shop</a></li>
              <li><a href="signin-page.php">Sign in</a></li>
              <li><a href="#contact">Contact</a></li>
              <li><a href="home.php#about-us">About</a></li>
            </ul>
        </div>
      
        <center><hr width="70"></center><br><br><br>
    <!-- Sign in -->
        <div class="container">
          <div class="card mx-auto" style="width: 25rem;">
            <div id="card-body">
              <div class="avatar"><img src="images/avatar.jpg" alt="Image"><br>
                Create Account<input type="file" name="img" required>
              </div>
              
                <input type="text" name="fname" placeholder="First name" required>
                <input type="text" name="lname" placeholder="Last name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="phone" placeholder="Contact number" required>
                <input type="text" name="address" placeholder="Address" required>
                <input type="text" name="user_name" placeholder="Username" required>
                <input type="hidden" name="user_type" value="user">
                <div class="mb-3">
                  <input type="password" name="password"  placeholder="Password" required>
                </div>
                
                <button type="submit" class="btn btn-primary" value="Signup">Register</button><br>
                <label>Already have an account?</label><a href="signin-page.php">Log in</a>
         
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
      width: 120px;
      cursor: pointer;
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
      height: 500px;
      font-family: 'Jura', sans-serif;
      width: 40%;
      margin: 0px auto;
      text-align: center;
      background-color: white;
      padding: 15px;
      border-radius: 5px; 
      display: flex;
      align-items: center;
      justify-content: center;
      
    }
    .container {
      padding: 10px;
      margin: 0 auto;
      justify-content: center;
      
    } 
    input {
      width: 330px;
      border-radius: 5px;
      padding: 10px;
      margin: 7px;
      font-family: 'Jura', sans-serif;
    }
    .btn {
      font-family: 'Jura', sans-serif;
      width: 80px;
      height: 30px;
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
    .avatar img {
      width: 90px;
      border-radius: 50%;
      border:1px solid #000;
      cursor: pointer;
      margin-bottom: 10px;
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