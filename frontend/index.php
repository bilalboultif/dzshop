<?php
session_start(); // Start the session

include 'connection.php';
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location: login.php');
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location: login.php');
}
if (isset($_POST['add_to_wishlist'])){
    $product_id = (int)$_POST['product_id'];

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];

   $wishlist_number = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
   $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
   if (mysqli_num_rows($wishlist_number) > 0) {
    $message[] = 'Product already exists in wishlist';
} else if (mysqli_num_rows($cart_num) > 0) {
    $message[] = 'Product already exists in cart';
} else {
    mysqli_query($conn, "INSERT INTO `wishlist`(`user_id`,`pid`,`name`,`price`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_image')");
    $message[] = 'Product successfully added to your wishlist';
}
}

// addidnig product to cart
if (isset($_POST['add_to_cart'])){
    $product_id = (int)$_POST['product_id'];

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_quantity = $_POST['product_quantity'];
   $product_image = $_POST['product_image'];

   $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
   if (mysqli_num_rows($cart_num) > 0) {
    $message[] = 'Product already exists in cart';
} else {
    mysqli_query($conn, "INSERT INTO `cart`(`user_id`,`pid`,`name`,`price`,`quantity`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_quantity','$product_image')");
    $message[] = 'Product successfully added to your cart';
}
}
?>
<style type="text/css">
    <?php 
    include 'main.css';
    ?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"/>
    <title>Document</title>
</head>
<body>
<?php include 'header.php'; ?>
<!--------------------home slider ---------------->
<div class="container-fluid">
   <div class="hero-slider">
    <div class="slider-item">
        <img src="img/x2.png">
        <div class="slider-caption">
            <span>test the quality</span>
            <h1>Premium <br> oil</h1>
            <p>Synthetic and synthetic blend motor oils are designed to be the highest quality motor oil available for your vehicle, for when you want the best protection and performance possible.</p>
            <a href="shop.php" class="btn">shop now</a>
        </div>
    </div>
    <div class="slider-item">
        <img src="img/x1.png">
        <div class="slider-caption">
            <span>test the quality</span>
            <h1>Premium <br> oil</h1>
            <p>Synthetic and synthetic blend motor oils are designed to be the highest quality motor oil available for your vehicle, for when you want the best protection and performance possible.</p>
            <a href="shop.php" class="btn">shop now</a>
        </div>
    </div>
    <div class="slider-item">
        <img src="img/x3.png">
        <div class="slider-caption">
            <span>test the quality</span>
            <h1>Premium <br> oil</h1>
            <p>Synthetic and synthetic blend motor oils are designed to be the highest quality motor oil available for your vehicle, for when you want the best protection and performance possible.</p>
            <a href="shop.php" class="btn">shop now</a>
        </div>
    </div>
   </div>
   <div class="controls">
    <i class="bi bi-chevron-left prev"></i>
    <i class="bi bi-chevron-right next"></i>
   </div>
</div>
<div class="line"></div>
<div class="service">
   <div class="row">
    <div class="box">
        <img src="img/i1.png">
        <div>
            <h1>Free Shipping Fast</h1>
            <p>Get Free 2-Day Shipping from Target at great low prices. Choose from Same Day Delivery, </p>
                <p> Drive Up or Order Pickup. Free shipping with $35 orders.</p>
        </div>
    </div>
    <div class="box">
        <img src="img/i2.png">
        <div>
            <h1>Money Back & Guarantee</h1>
            <p>Orange Money Back Guarantee covers most transactions on Orange. </p>
                <p>  It means buyers can get their money back if an item didn't arrive, is faulty or damaged, or doesn't ...</p>
        </div>
    </div>
    <div class="box">
        <img src="img/i3.png">
        <div>
            <h1>Online Support 24/7</h1>
            <p>Live Remote Support: Your Support, Your Way! We make it easy! </p>
                <p> Choose the way you would like to initiate support. Over the years we have listened to our </p>
        </div>
    </div>
   </div>
</div>
<div class="line2"></div>
<div class="story">
    <div class="row">
        <div class="box">
            <span>our story</span>
            <h1>Production of parts and motors since 2018</h1>
            <p>A compound annual growth rate of 2.39% is expected (CAGR 2024–2028). </p>
                <p>Output in the Automotive Products market is projected to amount to US$1.15tn in 2024.</p>
                 <p>A compound annual growth rate of 3.51% is expected (CAGR 2024–2028).</p>
                 <a href="shop.php" class="btn">Shop Now</a>
        </div>
        <div class="box">
            <img src="img/b9.png">
        </div>
    </div>
</div>
<div class="line5"></div>
<!-- testimonial -->
<div class="line6"></div>
<div class="testimonial-fluid">
    <h1 class="title"> What Our Customers Say's </h1>
    <div class="testimonial-slider">
        <div class="testimonial-item">
            <img src="img/bra.webp">
            <div class="testimonial-caption">
                <span>Test The Quality</span>
                <h1>Premium Oil </h1>
                <p>Apr 29, 2021
Great oil and a fair price
The pour spout and cap are very convenient and easy to use. I get this oil for my Toyota Tundra it works great. I wish it came in a 8 quart container
by </p>
            </div>
        </div>
        <div class="testimonial-item">
            <img src="img/bilal.jpeg">
            <div class="testimonial-caption">
                <span>Test The Quality</span>
                <h1>Premium Oil </h1>
                <p>Apr 29, 2021
Great oil and a fair price
The pour spout and cap are very convenient and easy to use. I get this oil for my Toyota Tundra it works great. I wish it came in a 8 quart container
by </p>
            </div>
        </div>
        <div class="testimonial-item">
            <img src="img/med.jpg">
            <div class="testimonial-caption">
                <span>Test The Quality</span>
                <h1>Premium Oil </h1>
                <p>Apr 29, 2021
Great oil and a fair price
The pour spout and cap are very convenient and easy to use. I get this oil for my Toyota Tundra it works great. I wish it came in a 8 quart container
by </p>
            </div>
        </div>
    </div>
    <div class="controls">
    <i class="bi bi-chevron-left prev1"></i>
    <i class="bi bi-chevron-right next1"></i>
   </div>
</div>
<div class="line5"></div>
<!-----------discover section------------->
<div class="line2"></div>
<div class="discover">
    <div class="detail">
        <h1 class="title">Aftermarket Wheels | Cheap Rims</h1>
        <span>Buy Now And Save 30% Off!</span>
        <p>Do you sell rims online?

Yes, at Discount Tire, we sell a full array of rims available online and in-store. Our massive inventory includes rims from all the best wheel manufacturers, including Fuel Wheels, MB Wheels, Method Wheels, HRE Wheels, American Racing Wheels, Bravado, Drag, Black Rhino Wheels and many more.
</p>
<a href="shop.php" class="btn">discover now</a>
    </div>
    <div class="img-box">
        <img src="img/b11.png">

    </div>
</div>
<div class="line5"></div>
<?php
        if (isset($message)) {
            foreach($message as $message) {
              echo '
              <div class="message">
              <span>'.$message.'</span>
              <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
      
          </div>
              ';
            }
        }
   ?>
<?php include 'homeshop.php'; ?>
<div class="newslatter">
    <h1 class="title">Join Our To NewsLatter</h1>
    <p>Get off your next order. Be the first to learn about promotions special events, new arrivals and more.</p>
    <input type="text" name="email" placeholder="your email address ..'">
    <button>subscribe now</button>
</div>
<div class="line5"></div>
<div class="client">
    <div class="box">
        <img src="img/client0.png">
        <p>Old Cars</p>
    </div>
    <div class="box">
        <img src="img/client1.png">
        <p>New Cars</p>
    </div>
    <div class="box">
        <img src="img/client2.png">
        <p>Motor Cars</p>
    </div>
    <div class="box">
        <img src="img/client3.png">
        <p>Parts Cars</p>
    </div>
    <div class="box">
        <img src="img/client4.png">
        <p>Custom Cars</p>
    </div>
</div>
<?php include 'footer.php'; ?>

<!-----------slick slider link------------>
<script src="jquery.js"></script>
<script src="slick.js"></script>
<script src="script2.js" type="text/javascript"></script>
</body>
</html>