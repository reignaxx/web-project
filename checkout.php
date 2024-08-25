<?php 
  
  session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);
    
?>
<!DOCTYPE html>
<html?>
  <head>
    <title>Check out - Adiv</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Arapey&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abel&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  </head>
  
  <body>
    <section class="h-100 h-custom" style="background-color: #f2f2f2; font-family: 'Abel', sans-serif;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12">
          <div class="card card-registration card-registration-2" style="border-radius: 15px;">
            <div class="card-body p-0">
              <div class="row g-0">
                <div class="col-lg-8">
                  <div class="p-5">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                      <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                    </div>
                    <?php
                      $select_query = mysqli_prepare($con, 'SELECT orders.*, product.*
                      FROM orders
                      JOIN product ON orders.productID = product.id
                      JOIN users ON orders.customerID = users.id
                      WHERE orders.customerID = users.id;
                      ');
                      
                      mysqli_stmt_execute($select_query); // Execute the query
                      $result = mysqli_stmt_get_result($select_query); //store

                      $sum = 0;
                      while ($row = mysqli_fetch_assoc($result)) {
                        $productImage = $row['product_image'];
                        $productName = $row['product_name'];
                        $productPrice = $row['product_price'];
                        $orderID = $row['order_id'];
                        $customerID = $row['customerID'];
                        $productID = $row['productID'];
                        $quantity = $row['quantity']; 
                        $value = $productPrice*$quantity;
                        //Add the value to the sum
                        $sum += $value;
                        // Print the data in a table row
                    ?>
                    <hr class="my-4">

                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                      <div class="col-md-2 col-lg-2 col-xl-2">
                        <img
                          src="images/<?php echo $productImage;?>"
                          class="img-fluid rounded-3" alt="Cotton T-shirt">
                      </div>
                      <div class="col-md-3 col-lg-3 col-xl-3">
                        <h6 class="text-muted" id="price<?php echo $productID;?>"><?php echo number_format($productPrice,2);?></h6>
                        <h6 class="text-black mb-0"><?php echo $productName;?></h6>
                      </div>
                      <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                        <button class="btn btn-link px-2"
                          onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                          <i class="fas fa-minus"></i>
                        </button>
                        <!-- update quantity -->
                        <form action="update-cart.php" method="post">
                        <input id="form1" min="1" value="<?php echo $quantity?>" type="number" name="quantity" class="form-control form-control-sm"/>
                        <input type="hidden" name="pid" value="<?php echo $productID;?>"/> 
                          
                        <button class="btn btn-link px-2"
                          onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                          <i class="fas fa-plus"></i>
                        </button>
                        <button class="btn btn-dark btn-block btn-lg"style="width:75px; margin: 0px; font-size: 12px;" type='submit' name="update">Update</button>  
                      </div>
                      <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                      <h6 class="mb-0" id="subtotal">₱ <?php echo number_format($value,2);?></h6>
                      
                        </form>
                        
                      </div>
                       <!--------------------- -->
                      <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                        <a href="remove-cart-item.php?pid=<?php echo $productID;?>"><img src="images/bin-icon.png" width="20"></a>
                      </div>
                    </div>
                    
                    <hr class="my-4">
                    <?php
                    } ?>
                    <div class="pt-5">
                      <h6 class="mb-0"><a href="user-home.php#categories" class="text-body"><i
                      class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a></h6>
                    </div>
                    </div>
                  </div>
                  
                  <div class="col-lg-4 bg-grey">
                    <div class="p-5">
                      <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                      <hr class="my-4">
                      <div class="d-flex justify-content-between mb-5">
                        <h5 class="text-uppercase">Total price</h5>
                        
                          <h5 id="total<?php echo $productID;?>">₱ <?php echo number_format($sum,2 );?></h5> 
                          
                  </div>
                  <form action="place-order.php" method="post">
                      <button type="submit" name="place"  class="btn btn-dark btn-block btn-lg"
                          data-mdb-ripple-color="dark">Place Order</button>
                          <input type="hidden" name="total_price" value="<?php echo $sum;?>"/>
                          <input type="hidden" name="customer_ID" value="<?php echo $customerID;?>"/>
                          <input type="hidden" name="total" value="<?php echo $value;?>"/>
                          <input type="hidden" name="status" value="Pending"/>
                           
                  </form >
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
    
</html>