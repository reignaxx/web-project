<?php


session_start();

include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
   
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    if (!empty($user_name) && !empty($email) && !is_numeric($user_name)) {
        $query = "SELECT id, user_type FROM users WHERE user_name = '$user_name' AND email = '$email' AND password = '$password' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            // Set session name based on user type
            if ($user_data['user_type'] == 'user') {
                session_name('user_session');
            } elseif ($user_data['user_type'] == 'admin') {
                session_name('admin_session');
            }

            // Start the session
            session_start();

            // Store user information in session
            $_SESSION['id'] = $user_data['id'];
            $_SESSION['user_type'] = $user_data['user_type'];

            // Redirect based on user type
            if ($user_data['user_type'] == 'user') {
                header("Location: user-home.php");
                exit();
            } elseif ($user_data['user_type'] == 'admin') {
                header("Location: admin-home.php");
                exit();
            }
        }
    }
    
    echo "<script>alert('Invalid credentials!')</script>";
    echo "<script>window.open('signin-page.php','_self')</script>";
}
?>



<!DOCTYPE html>
<html>
  <head>
    <title>Sign in - Adiv</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arapey&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">

  </head>
  <form method="post">
  <body>
    <div id="banner">
      <div class="bar">Guest Mode</div>
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
    <!-- Sign in -->

        <div class="container">
          <div class="card mx-auto" style="width: 25rem;">
            <div class="card-body">
              <div class="avatar"><img src="images/avatar.jpg" alt="Image"><br></div>
              <form>
                <div class="mb-3">
                  <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="mb-3">
                  <input type="text" name="user_name" placeholder="Username" required>
                  <input type="password" name="password" placeholder="Password" required>
                </div>
                
                <button type="submit" value="login" class="btn btn-primary">Log in</button><br>
                <label>Don't have an account?</label><a href="signup-page.php">Sign up</a>
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
        77 Don Maria St., Aliw Avenue, Nowhere City
      </p>
    </footer>
    </div>
    


    

    
  </body>
  </form>

  <style>
    @media only screen and (max-width: 768px) {
    [class*="box-"] {
      width: 100%;

  }
}
    *{
      margin:0;
      padding: 0;
      font-family: 'Jura', sans-serif;
    }
    #banner {
      width: 100%;
      height:100vh;
      background-image: url(bg-image.jpg);
      background-size: cover;
      background-position: center;   
    }
    /* searh bar */
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

    /* navigation bar */
    .bar {
      background-color:#000;
      color: #fff;
      height: 20px;
      padding: 10px;
      text-align: center;
    }
    .nav-bar { 
      width: 95%;
      margin: auto;
      margin-top: -20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .logo img {
      width: 150px;
      cursor: pointer;
      filter: brightness(10);
    }
    .nav-bar ul li {
      list-style: none;
      display: inline-block;
      margin: 0 20px;
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
    
    /*Sign-in card */
    .card {
      font-size: 16px;
      height: 350px;
      box-shadow: 0 4px 8px 0 #000;
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
      
      margin: 0 auto;
      justify-content: center;
      
    } 
    input {
      width: 250px;
      border-radius: 5px;
      padding: 10px;
      margin: 7px;
      
    }
    .btn {
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
    }
    
  </style>
</html>