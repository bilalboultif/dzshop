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
} else if (mysqli_num_rows($cart_num) > 0) {
    $message[] = 'Product already exists in cart';
} else {
    mysqli_query($conn, "INSERT INTO `wishlist`(`user_id`,`pid`,`name`,`price`,`image`) VALUES('$user_id','$product_id','$product_name','$product_price','$product_image')");
    $message[] = 'Product successfully added to your wishlist';
}


}
// updtate the quantity in the cart
if (isset($_POST['update_qty_btn'])) {
    $update_qty_id = $_POST['update_qty_id'];
    $update_value = $_POST['update_qty'];

    $update_query = mysqli_query($conn, "UPDATE `cart` SET quantity ='$update_value' WHERE id='$update_qty_id'") or die('query failed');
    if ($update_query){
        header('location:cart.php');
    }
}




//delete product from cart

if (isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'")or die('query field');

    header('location:cart.php');

}
// delete all product from cart
if (isset($_GET['delete_all'])){
    
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'")or die('query field');

    header('location:cart.php');

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
             <h1>My Cart</h1>
             <p>this section is for information about us ...</p>
             <a href="index.php">home</a><span>/ cart</span>
         </div>
    </div>
    <!--------------------about us---------------------------->
    <section class="shop">
        <h1 class="title">Products added to Your cart </h1>
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
  
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
    if (mysqli_num_rows($select_cart) > 0) {
       while ($fetch_cart = mysqli_fetch_assoc($select_cart)){

  
    ?>
    <div class="box">
        <form method="post">
           <div class="icon">
        <a href="view.php?pid=<?php echo $fetch_cart['pid']; ?>" class="bi bi-eye-fill"></a>
        <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>" class="bi bi-x" onclick="return confirm('do you want to delete this item from your cart')"></a>
        <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>       
       </div> 
        </form>
        
        
       <img src="image/<?php echo $fetch_cart['image']; ?>">
       <div class="price"><?php echo $fetch_cart['price']; ?>$</div>
       <div class="name"><?php echo $fetch_cart['name']; ?></div>
       <form method="post">
          <input type="hidden" name="update_qty_id" value="<?php echo $fetch_cart['id']; ?>">
             <div class="qty">
               <input type="number" min="1" name="update_qty" value="<?php echo $fetch_cart['quantity']; ?>">
               <input type="submit" name="update_qty_btn" value="update">
             </div>
       </form>
       <div class="cart_amt">
      <p>total amount : <span>$<?php echo $total_amt = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span></p>
   </div>
    </div>
    <?php 
    $grand_total += $total_amt;
         }
        } else { 
            echo '<p class="empty">no products added yet!</p>';
        }
    ?>
   </div>
   <div class="dlt">
   <a href="cart.php?delete_all" class="btn2" onclick="return confirm('do you want to delete all items in you cart')">delete all</a>

   </div>
   <div class="cart_total">
      <p>total amount paybale: <span>$<?php echo $grand_total; ?></span></p>
      <a href="shop.php" class="btn">continue shopping</a>
      <a href="checkout.php" class="btn <?php echo ($grand_total>1)?'':'disabled'?>">proceed to checkout</a>
   </div>
    </section>
 
<?php include 'footer.php'; ?>

<script src="script.js" type="text/javascript"></script>
</body>
</html>