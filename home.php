<!DOCTYPE html>
<html>
<head>
<title>USER | HOME</title>
<script
    src="https://code.jquery.com/jquery-3.3.1.js"
    integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous">
</script>
<!-- function to run header and footer -->
<script> 
$(function(){
  $("#header").load("header.php"); 
});
</script> 
<!-- head remaining section -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/product.css">
<!-- font awesome -->
<script src="https://kit.fontawesome.com/dbed6b6114.js" crossorigin="anonymous"></script>
</head>
<body>
<div id="header"></div>
<!-- remaining section --> 
<!-- reference from https://www.youtube.com/watch?v=ZI41tLLxNak&t=1s -->
<div class = "products">
    <div class = "container"><br><br><br><br>
        <h1 class = "lg-title">WELCOME TO INTIFUDE</h1>
        <div class = "product-items">
            <!-- single product -->
            <!-- retrieve from database -->
            <?php include ("conn.php"); 
            $records=mysqli_query($con,"SELECT * FROM product"); //==+1

            //limit add to cart one time
            $i = 0;

            while($data = mysqli_fetch_array($records))
            {
            ?>

            <!-- update database when user click addcart or checkout -->
            <?php
            if (isset($_POST['addcart']) && $i==0) {
            include("session.php"); ///check if user is a customer
            include("conn.php");
            $i=1;

            //store session[customer id] as a integer
            $customer_id=$_SESSION['customer_id'];

            //read whether got any order id that is ‘unpaid'in order table
            $order_id=mysqli_query($con,"SELECT c_order_id FROM c_order WHERE 
            customer_id = $customer_id AND status = 'unpaid'");

            //check got unpaid order or not, if not then create
            if (mysqli_num_rows($order_id)==0)
            {     
            $sql = "INSERT INTO c_order (customer_id, status)
            VALUES
            ($customer_id,'unpaid')";
            mysqli_query($con, $sql);
            //select again the order id after created[store into an object]
            $order_id=mysqli_query($con,"SELECT c_order_id FROM c_order WHERE 
            customer_id = $customer_id AND status = 'unpaid'");
            //get order id from object
            $getid =mysqli_fetch_row($order_id)[0];
            $message = "New Order Created";
            //display new order created
            echo "<script>alert('$message: $getid'); 
            </script>";
            //end if
            }

            //insert into order detail table about what product and quantity according to same order id
            $getid = mysqli_fetch_row($order_id)[0];
            //validate product id whether exist in order
            $product=mysqli_query($con,"SELECT * FROM order_detail WHERE 
            c_order_id =$getid AND product_id=$_POST[product_id]");
            if (!$product || mysqli_num_rows($product)==0)
            {   
            //insert product into order detail table if no find order id
            $sql = "INSERT INTO order_detail (c_order_id, product_id, quantity)
            VALUES
            ($getid,$_POST[product_id],1)";
            mysqli_query($con, $sql);}
            //add if find order
            else{
                $sql = "UPDATE order_detail SET 
                quantity=quantity+1
                WHERE c_order_id =$getid AND product_id=$_POST[product_id]";
                mysqli_query($con, $sql);

            }
            echo "<script>alert('Product added into cart successfully'); 
            </script>";

            // mysqli_close($con);

            }   
            ?>
            <!-- end update -->

            <!-- single product -->
            <div class = "product">
                <div class = "product-content">
                    <div class = "product-img">
                        <?php echo '<img src="data:image/png;base64,' . base64_encode($data['image']) . '" width="100px" height="250px"/><br>';
                        ?>
                    </div>
                </div>

                <div class = "product-info">
                    <div class = "product-btns">
                        <form method="POST">
                            <!-- get id when user click the product-->
                            <button type = "submit" name="addcart" class = "btn-cart"> add to cart
                                <span><i class = "fas fa-plus"></i></span>
                            </button>
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="product_id" value="<?=$data['product_id']?>">
                        </form>
                    </div>
                    <div class = "product-info-top">
                        <h2 class = "sm-title"><?php echo $data['genre']; ?></h2>
                    </div>
                    <a href = "#" class = "product-name"><?php echo $data['product_name']; ?></a>
                    <p class = "product-price"><?php echo "RM"; ?><?php echo $data['price']; ?></p>
                </div>
            </div>
            <?php
            //end while
            }
            ?>
            <?php mysqli_close($con);?>
            
            <!-- end of single product -->
        </div>
    </div>
</div>
</body>
</html>