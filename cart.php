<!-- reference from https://www.youtube.com/watch?v=6JCyMPfRxoM -->
<!DOCTYPE html>
    <html>
    <head>
        <title>USER | CART</title>
        <link rel="stylesheet" type="text/css" href="css/cart.css">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
    <br><br><br><br><br>
    <div class="container">
        <h1>Cart</h1>
        <div class="cart">
            <!-- product view -->
            <div class="products">
                <!-- retrieve data from database -->
                <?php
                include("conn.php");
                session_start();

                //store session[customer id] as a integer
                $customer_id=$_SESSION['customer_id'];
                //select again the order id after created[store into an object]
                ////        display product (1): SELECT order id with status "unpaid"
                $order_id=mysqli_query($con,"SELECT c_order_id FROM c_order WHERE 
                customer_id = $customer_id AND status = 'unpaid'");
                //get order id from object
                $getid =mysqli_fetch_row($order_id)[0];  

                ////        display product (2): SELECT which item and quantity from order detail according to order id
                //validate product id whether exist in order
                $product=mysqli_query($con,"SELECT * FROM order_detail WHERE 
                c_order_id =$getid GROUP BY NOT NULL");
                ////        display product (3): IF empty, cannot view cart
                if (mysqli_num_rows($product)==0)
                {
                    echo "<script>alert('Your cart is empty! Please add product into cart.'); 
                    window.location.href= 'home.php';
                    </script>";
                }
                ////        display product (4): ELSE, use while loop to display every single item
                //get item where order id = getid
                $orderItem=mysqli_query($con,
                "SELECT od.product_id, od.quantity, p.image, p.product_name, p.price
                FROM order_detail AS od
                INNER JOIN product AS p
                ON od.product_id = p.product_id
                WHERE od.c_order_id = $getid");       

                $sum = 0;
                $numItem = 0;
                while($item = mysqli_fetch_array($orderItem))
                //start while
                {
                ?>
                <?php

                ////        update product quantity (1): check from form, if button activated, then read input and UPDATE to order details
                if(isset($_POST["updateBtn"])){
                    include("conn.php");
                    $sql = "UPDATE order_detail SET 
                    quantity='$_POST[quantity]' 

                    WHERE c_order_id = $getid AND product_id=$_POST[product_id];";
                    mysqli_query($con, $sql);
                    if (mysqli_query($con, $sql)) {
                    mysqli_close($con);
                    echo "<script>alert('Record updated!'); window.location.href='cart.php';</script>";
                    }
                }

                ?>
                <!-- single product -->
                <form method="post">
                <div class="product">
                <?php echo '<img src="data:image/png;base64,' . base64_encode($item['image']) . '" width="100px" height="250px"/><br>'?> 
                    <div class="product-info">
                        <h3 class="product-name"><?php echo $item['product_name']; ?></h3>
                        <h4 class="product-price"><?php echo "RM"; ?><?php echo $item['price']; ?></h4>
                        <p class="product-quantity">Qnt: <input value="<?php echo $item['quantity'] ?>" name="quantity">
                        <input type="hidden" name="product_id" value="<?php echo $item['product_id'] ?>">
                        <input type="hidden" name="customer_id" value="<?php echo $customer_id ?>">
                        <button type="submit" class="updateBtn" name="updateBtn">Update</button>
                        
                        <p class="product-remove">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            <span class="remove"><?php 
                            //pass product id and order id into the link when user clicks remove
                            ////        delete (1):store in link, pass the product id and order id to delete.php
                            $message = "<a href='delete.php?pid={$item['product_id']}&oid=$getid' style='text-decoration: none; color: #505d61';>Remove</a>";
                            echo $message; ?></span>
                        </p>                      
                       
                    </div>
                </div>
                <?php $sum = $sum + $item['price']*$item['quantity'] ?>
                <?php $numItem = $numItem + $item['quantity'] ?>
                </form>
                <!-- end of single product -->
                <?php
                }
                ?>
                <!-- end while -->
            </div>
            <!-- end of all products -->
            
            <!-- count total field -->
            <div class="cart-total">
                <p>
                    <span></span>
                    <span></span>
                </p>
                <p>
                    <span>Total Price (RM)</span>
                    <span><?php echo $sum ?></span>
                </p>
                <p>
                    <span>Number of Item(s)</span>
                    <span><?php echo $numItem ?></span>
                </p>

                <a href="checkout.php">Proceed to Checkout</a>
            </div>
            <!-- close database -->
            <?php mysqli_close($con);?>
        </div>
    </div>
    <br><br><br><br><br>
    </body>
    </html>