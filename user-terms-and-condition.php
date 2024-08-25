<?php 
  
  session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Terms and Condition - Adiv</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arapey&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">

  </head>

  <body>
    <div id="banner">
    <div class="bar">Hello, <?php echo $user_data['user_name'];?></div>
        <div class="nav-bar">
          <div class="logo"><img src="images/logo.png" alt="Picture"></div>
            <ul>
            <li><a href="user-home.php">Home</a></li>
              <li><a href="#gallery">Shop</a></li>
              <li><a href="#contact">Contact</a></li>
              <li><a href="#about-us">About</a></li>
              <li><a href="user-profile.php"><img src="images/user-iconn.png" id="user-icon" alt="User Icon"></a></li>
              <li><a href="checkout.php"><img src="images/cart-icon.png" id="cart-icon" alt="User Icon"></a></li>
            </ul>
        </div>
    <center><hr width="70"></center>
    <!-- Terms & Condition -->
    <div id="terms-n-condition">
      <h1>Terms and Condition</h1>
      <p>
        <br><br>
        Welcome to Adiv, a natural and organic skin-care company. Please read these terms and conditions carefully before using our website, products, or services. By accessing or using any part of our website, products, or services, you agree to be bound by these terms and conditions. If you do not agree to all the terms and conditions, then you may not access or use our website, products, or services.
        <br><br><br>
        1. Products and Services<br><br>
        We offer a range of skin-care products for different skin types and needs, such as cleansers, moisturizers, serums, and more. You can purchase our products online through our website, or through our authorized retailers and distributors. We also offer various services, such as skin consultations, product recommendations, and customer support. You can access our services online through our website, email, phone, or social media channels.
        <br><br><br>
        2. Orders and Payments<br><br>
        When you place an order on our website, you agree to provide accurate and complete information, such as your name, email, address, phone number. You also agree to pay the total price of your order, including any applicable taxes, shipping fees, and other charges. We only have a cash on delivery payment method. We reserve the right to cancel or reject any order at our sole discretion, for any reason, without liability to you.
        <br><br><br>
        3. Shipping and Delivery<br><br>
        We ship our products nationwide, using reputable and reliable carriers. We offer various shipping options, such as standard, express. The shipping fees and delivery times vary depending on the shipping option, destination, and weight of your order. You can check the shipping fees and delivery times on our website before placing your order. We will provide you with a tracking number and a confirmation email once your order is shipped. We are not responsible for any delays, damages, losses, or errors in the shipping and delivery process, caused by the carrier, customs, or other factors beyond our control.
        <br><br><br>
        4. Returns and Refunds<br><br>
        We want you to be satisfied with our products and services. If you are not happy with your purchase, you can return it to us within 30 days of the delivery date, for a full refund or exchange, subject to the following conditions:
        <br><br>
        - The product must be unused, unopened, and in its original packaging and condition.<br><br>
        - The product must be accompanied by a proof of purchase, such as a receipt, invoice, or order confirmation email.<br><br>
        - The product must be shipped back to us at your own expense, using a trackable and insured method.<br><br>
        - The product must be returned to the address specified on our website or in the confirmation email.
        <br><br><br>
        We will process your refund or exchange within 14 days of receiving your returned product, using the same payment method that you used for your purchase. We will notify you by email once your refund or exchange is processed. We reserve the right to refuse any return or refund that does not meet the above conditions, at our sole discretion.
        <br><br><br>
        5. Intellectual Property Rights<br><br>
        All the content, design, graphics, logos, trademarks, and other intellectual property rights on our website, products, and services are owned by or licensed to us, and are protected by applicable laws and regulations. You may not copy, reproduce, distribute, display, modify, or use any of our intellectual property rights without our prior written consent. You may only use our website, products, and services for your personal and non-commercial purposes, in accordance with these terms and conditions.
        <br><br><br>
        6. Disclaimer of Warranties and Limitation of Liability<br><br>
        Our website, products, and services are provided on an "as is" and "as available" basis, without any warranties of any kind, either express or implied, including but not limited to warranties of merchantability, fitness for a particular purpose, or non-infringement. We do not warrant that our website, products, and services will be uninterrupted, error-free, secure, or free of viruses or other harmful components. We do not warrant that the information, advice, or results obtained from our website, products, and services will be accurate, reliable, or effective. You use our website, products, and services at your own risk and discretion.
        <br><br><br>
        To the fullest extent permitted by law, we will not be liable for any direct, indirect, incidental, special, consequential, or exemplary damages, including but not limited to damages for loss of profits, goodwill, data, or other intangible losses, arising from or relating to your use of or inability to use our website, products, or services, even if we have been advised of the possibility of such damages. In no event will our total liability to you for all claims, damages, losses, and causes of action exceed the amount paid by you for our products or services.
        <br><br><br>
        7. Indemnification<br><br>
        You agree to indemnify, defend, and hold harmless us, our affiliates, partners, officers, directors, employees, agents, licensors, and suppliers from and against any and all claims, liabilities, damages, losses, costs, expenses, and fees, including reasonable attorneys' fees, arising from or relating to your use of or misuse of our website, products, or services, your violation of these terms and conditions, or your violation of any rights of any third party.
        <br><br><br>
        8. Governing Law and Dispute Resolution<br><br>
        These terms and conditions are governed by and construed in accordance with the laws of the Philippines, without regard to its conflict of law principles. Any dispute, controversy, or claim arising from or relating to these terms and conditions, or your use of or inability to use our website, products, or services, shall be submitted to the exclusive jurisdiction of the courts of the Philippines, and you hereby consent to such jurisdiction and venue.
        <br><br><br>
        9. Changes to These Terms and Conditions<br><br>
        We reserve the right to modify or update these terms and conditions at any time, without prior notice, by posting the revised version on our website. The revised version will be effective immediately upon posting, and will supersede any previous versions. Your continued use of our website, products, or services after the posting of the revised version constitutes your acceptance of the changes. We encourage you to review these terms and conditions periodically to stay informed of any changes.
        <br><br><br>
        10. Contact Us<br><br>
        If you have any questions, comments, or concerns about these terms and conditions, or our website, products, or services, please contact us at:
        <br><br>
        Adiv<br>
        77 Don Maria Street<br>
        Aliw Avenue, Nowhere City<br>
        Philippines<br>
        Email: adiv.inc@gmail.com<br>
        Phone: +63 971 1281 611<br>
        Tel: (049) 808-2293<br>
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
        <a href="user-terms-and-condition.php">Terms and Condition<br></a>
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
    .bar {
      background-color:#000;
      color: #fff;
      height: 20px;
      padding: 10px;
      text-align: center;
      font-family: 'Jura', sans-serif;
    }
    .nav-bar { 
      width: 100%;
      height: 90px;
      margin: auto;
      margin-top: -5px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      
    }
    .logo img {
      width: 150px;
      cursor: pointer;
    }
    #cart-icon {
      width: 20px;
    }
    #user-icon{
      width: 20px;
      margin-top: 3px;
      filter: invert(100);
      
    }
    #search-icon {
      filter: invert(100);
    }
    #cart-icon, span {
      width: 20px;
      
    }
    .nav-bar ul li {
      list-style: none;
      display: inline-block;
      margin: 0 15px;
      position:relative;
      font-family: 'Jura', sans-serif;
    }
    .nav-bar ul li a {
      text-decoration: none;
      color: #000;
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
    /* Terms n Condition */
    #terms-n-condition {
      font-family: 'Arapey', serif;
      font-size: 20px;
      justify-content: center;
      padding: 50px 90px 30px 90px;
      line-height: 1.2;
      
    }
    #terms-n-condition h1 {
      font-family: 'Abel', sans-serif;
      text-align: center;
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