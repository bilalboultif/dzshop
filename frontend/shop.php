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
// addidnig product to wishlist
if (isset($_POST['add_to_wishlist'])){
    $product_id = (int)$_POST['product_id'];

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];

   $wishlist_number = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
   $cart_num = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
   if (mysqli_num_rows($wishlist_number) > 0) {
    $message[] = 'Product already exists in wishlist';

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"/>

    <link rel="stylesheet" type="text/css" href="main.css"/>

    <title>Document</title>
</head>
<body>
<?php include 'header.php'; ?>
<div class="banner">
         <div class="detail">
             <h1>our shop</h1>
             <p>this section is for information about us ...</p>
             <a href="index.php">home</a><span>/ about us</span>
         </div>
    </div>
    <!--------------------about us---------------------------->
    <section class="shop">
        <h1 class="title">Shop best sellers</h1>
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
   <div class="box-container">
    <?php 
    $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
    if (mysqli_num_rows($select_products) > 0) {
       while ($fetch_products = mysqli_fetch_assoc($select_products)){

  
    ?>
    <form method="post" class="box">
        <div class="price"><?php echo $fetch_products['price']; ?>$</div>
       <img src="image/<?php echo $fetch_products['image']; ?>">
       
       <div class="name"><?php echo $fetch_products['name']; ?></div>
       <input type="hidden" name="product_id" class="" value="<?php echo $fetch_products['id']; ?>">
       <input type="hidden" name="product_name" class="" value="<?php echo $fetch_products['name']; ?>">
       <input type="hidden" name="product_price" class="" value="<?php echo $fetch_products['price']; ?>">
       <input type="hidden" name="product_quantity" class="" value="1" min="1">
       <input type="hidden" name="product_image" class="" value="<?php echo $fetch_products['image']; ?>">
       <div class="icon">
        <a href="view.php?pid=<?php echo $fetch_products['id']; ?>" class="bi bi-eye-fill"></a>
        <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
        <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
       </div>
    </form>
   
    <?php 
         }
        } else { 
            echo '<p class="empty">no products added yet!</p>';
        }
    ?>
   </div>
    </section>
 
<?php include 'footer.php'; ?>

<script src="script.js" type="text/javascript"></script>
</body>
</html>