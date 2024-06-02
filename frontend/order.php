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
if (isset($_POST['submit-btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name='$name' AND email='$email' AND number = '$number' AND message = '$message'") or die('query failed');
    if (mysqli_num_rows($select_message)>0){
             $msg[] = 'message already send';
    } else {
        mysqli_query($conn, "INSERT INTO `message` (`user_id`,`name`,`email`,`number`, `message`) VALUES('$user_id','$name', '$email', '$number','$message')") or die('query failed');
        $msg[] = 'Message successfully sent to us';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css"
        href="//cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />

    <link rel="stylesheet" type="text/css" href="main.css" />

    <title>Document</title>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>Your Order</h1>
            <p>this section is for information about us ...</p>
            <a href="index.php">home</a><span>/ order</span>
        </div>
    </div>
    <!--------------------about us---------------------------->
    <?php
        if (isset($msg)) {
            foreach($msg as $msg) {
              echo '
              <div class="message">
              <span>'.$msg.'</span>
              <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
      
          </div>
              ';
            }
        }
   ?>
    <div class="line"></div>
    <div class="order-section">
        <div class="box-container">
            <?php  
              $select_orders = mysqli_query($conn, "SELECT * FROM `order` WHERE user_id='$user_id'") or die('query failed');
              if (mysqli_num_rows($select_orders)>0){
                while($fetch_orders = mysqli_fetch_assoc($select_orders)) {

               
            ?>
            <div class="box">
                <p>placed on: <span><?php echo $fetch_orders['placed_on'];?></span></p>
                <p>namer: <span><?php echo $fetch_orders['name'];?></span></p>
                <p>number: <span><?php echo $fetch_orders['number'];?></span></p>
                <p>email: <span><?php echo $fetch_orders['email'];?></span></p>
                <p>address: <span><?php echo $fetch_orders['address'];?></span></p>
                <p>payment method: <span><?php echo $fetch_orders['method'];?></span></p>
                <p>your order: <span><?php echo $fetch_orders['total_products'];?></span></p>
                <p>total price: <span><?php echo $fetch_orders['total_price'];?></span></p>
                <p>payment status: <span><?php echo $fetch_orders['payment_status'];?></span></p>






            </div>
            <?php 
             }
            }  else {
                echo '
                    <div class="empty">
                        <p>No order placed yet!</p>
                    </div>
                ';
            }
            ?>
        </div>
    </div>

    <div class="line5"></div>
    <?php include 'footer.php'; ?>

    <script src="script.js" type="text/javascript"></script>
</body>

</html>