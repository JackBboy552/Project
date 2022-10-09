<?php
//post record into payment and change 'unpaid'status into 'pending' when user click confirm 
if (isset($_POST['confirm'])){
    session_start();

    ////      UPDATE quantity (1): SELECT ORDER ID with unpaid status
    //update quantity in produdct table
    $customer_id=$_SESSION['customer_id'];
    //get order with unpaid "status" and get product quantity
    include ("conn.php");
    $coid=mysqli_query($con,"SELECT c_order_id FROM c_order WHERE 
    customer_id = $customer_id AND status = 'unpaid'");
    //get order id from object
    $oid =mysqli_fetch_row($coid)[0];  
    ///      UPDATE quantity (2): use order id to identiy which product and quantity
    //get quantity od.product_id, 
    $queryresult=mysqli_query($con,
    "SELECT *
    FROM order_detail AS od
    INNER JOIN c_order AS c
    ON od.c_order_id = c.c_order_id
    WHERE od.c_order_id =$oid
    ");
    ///      UPDATE quantity (3): while loop to substitute the quantity in product table
    while($data=mysqli_fetch_array($queryresult)){
      $sqll = "UPDATE product SET 
      p_quantity=p_quantity-$data[quantity]
      WHERE product_id =$data[product_id]";
      mysqli_query($con, $sqll);
    }  
    mysqli_close($con);
    //end update product quantity
   
    include("conn.php");
    //store session[customer id] as a integer
    $customer_id=$_SESSION['customer_id'];
    //get current date
    $date = date('Y-m-d');
    //get total
    //select order id
    $order_id=mysqli_query($con,"SELECT c_order_id FROM c_order WHERE 
    customer_id = $customer_id AND status = 'unpaid'");
    //get order id from object
    $getid =mysqli_fetch_row($order_id)[0];  
    
    $cart=mysqli_query($con,
    "SELECT od.product_id, od.quantity, p.image, p.product_name, p.price
    FROM order_detail AS od
    INNER JOIN product AS p
    ON od.product_id = p.product_id
    WHERE od.c_order_id = $getid
    ");            

    $sum = 0;
    $numItem = 0;
    while($item = mysqli_fetch_array($cart))
    {
        $sum = $sum + $item['price']*$item['quantity']; 
        $numItem = $numItem + $item['quantity'];
    }
    $total=$sum;


    ////      add payment(2):  INSERT payment details into payment table
    //insert payment details into payment data
    $cardnum=$_POST["cardnum"];
    $sql1 = "INSERT INTO payment (card_num,c_order_id, customer_id, date,total)
    VALUES
    ($cardnum,$getid,$customer_id,'$date',$total)";
    mysqli_query($con, $sql1);
    mysqli_close($con);


    ///      UPDATE order status (1): from unpaid to pending
    include("conn.php");
    $sql = "UPDATE c_order SET 
    status='pending'
    WHERE c_order_id =$getid";
    mysqli_query($con, $sql);
    mysqli_close($con);

    echo "<script>
    alert('Payment added successfully!'); 
    window.location.href= 'home.php';
    </script>";

  }
?>

<!DOCTYPE html>
<html>
<head>
<title>USER | CHECKOUT</title>
<link rel="stylesheet" type="text/css" href="css/checkout.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous">
</script>
<!-- function to run header -->
<script> 
$(function(){
  $("#header").load("header.php"); 
});
</script> 
</head>
<body>
<div id="header"></div>
<!-- remaining section -->
<!-- reference design from https://www.w3schools.com/howto/howto_css_checkout_form.asp -->
<br><br><br><br><br><br>
<div class="row">
  <div class="col-75">
    <div class="container">
      <form action="" method="post">

        <div class="row">
          <div class="col-50">
            <center><h2>INFORMATION</h2></center><br><br>
            <!-- get data from database -->
            <?php include ("conn.php"); 
            session_start();
            //store session[customer id] as a integer
            $customer_id=$_SESSION['customer_id'];
            $records=mysqli_query($con,"SELECT * FROM customer
            WHERE customer_id = $customer_id"); //==+1
            //limit add to cart one time
            while($data = mysqli_fetch_array($records))
            {
            ?>
            <!-- end get data from database -->

            <label for="fname"><i class="fa fa-user"></i>  Full Name</label><br>
            <?php echo $data['c_name']; ?><br><br><br>
            <label for="email"><i class="fa fa-envelope"></i>  Email</label><br>
            <?php echo $data['email']; ?><br><br><br>

            <div class="row">
            </div>
          </div>
          <?php } ?>  
          <?php mysqli_close($con); ?>  
          <!--add payment (1): accept from form and do validation  -->
          <div class="col-50">
            <center><h2>PAYMENT</h2></center>
            <label for="fname">Accepted Cards</label>
            <div class="icon-container">
            <img src="images/checkout.png" alt="Girl in a jacket">
            </div>
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="Raihanah binti Bakri" required>
            <label for="ccnum">Credit card number</label>
            <input type="text" id="ccnum" name="cardnum" pattern="{0-9]{16}" placeholder="1111222233334444" required>
            <label for="expmonth">Exp Month</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="September" required>

            <div class="row">
              <div class="col-50">
                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" pattern="[0-9]{4}" placeholder="2026" required>
              </div>
              <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" pattern="[0-9]{3}" name="cvv" placeholder="352" required>
              </div>
            </div>
          </div>

        </div>
        <input type="submit" name="confirm" value="Confirm Payment" class="btn">
      </form>
    </div>
  </div>
    <!-- retrieve data from database -->
    <?php
    include("conn.php");

    //store session[customer id] as a integer
    $customer_id=$_SESSION['customer_id'];
    //select order id
    $order_id=mysqli_query($con,"SELECT c_order_id FROM c_order WHERE 
    customer_id = $customer_id AND status = 'unpaid'");
    //get order id from object
    $getid =mysqli_fetch_row($order_id)[0];  
    $cart=mysqli_query($con,
    "SELECT od.product_id, od.quantity, p.image, p.product_name, p.price
    FROM order_detail AS od
    INNER JOIN product AS p
    ON od.product_id = p.product_id
    WHERE od.c_order_id = $getid
    ");            

    $sum = 0;
    $numItem = 0;
    $shipingfee = 5;
    //get current date
    $date = date('Y-m-d');
    while($item = mysqli_fetch_array($cart))
    {
        $sum = $sum + $item['price']*$item['quantity']; 
        $numItem = $numItem + $item['quantity'];
    }
    mysqli_close($con);
    ?>
  <div class="col-25">
    <div class="container">
      <p>Date <span class="price" style="color:black"><b><?php echo $date ?></b></span></p><br>
      <h4>Item(s) in Cart
        <span class="price" style="color:black">
          <i class="fa fa-shopping-cart"></i>
          <b><?php echo $numItem ?></b><br>
        </span>
      </h4>
      <br>
      <hr>
      <br>
      <?php $total=$sum?>
      <p>Total (RM) <span class="price" style="color:black"><b><?php echo $total ?></b></span></p>
    </div>
  </div>
</div>
<br><br><br><br><br><br><br><br><br><br>
</body>
</html>