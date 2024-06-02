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
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"/>

    <link rel="stylesheet" type="text/css" href="main.css"/>

    <title>Document</title>
</head>
<body>
<?php include 'header.php'; ?>
<div class="banner">
         <div class="detail">
             <h1>Contact</h1>
             <p>this section is for information about us ...</p>
             <a href="index.php">home</a><span>/ contact</span>
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
<div class="line5"></div>
<div class="form-container">
<h1 class="title">leave a message</h1>
<form method="post">
    <div class="input-field">
    <label>your name</label>
    <input type="text" name="name">
    </div>
    <div class="input-field">
    <label>your email</label>
    <input type="text" name="email">
    </div>
    <div class="input-field">
    <label>Phone</label>
    <input type="text" name="number">
    </div>
    <div class="input-field">
    <label>your message</label>
    <textarea name="message"></textarea>
    </div>
  <button type="submit" name="submit-btn">send message</button>
</form>
</div>
<div class="line5"></div>
<div class="address">
    <h1 class="title">our contact</h1>
    <div class="row">
        <div class="box">
            <i class="bi bi-map-fill"></i>
            <div class="bx">
                <h4>address</h4>
            <p>8271 Hewlet Dr,
                Indianapolis,<br>
                INDIANA, 46260</p>
            </div>
            
        </div>
        <div class="box">
            <i class="bi bi-telephone-fill"></i>
            <div class="bx">
                <h4>phone number</h4>
            <p>317-999-9999</p>
            </div>
            
        </div>
        <div class="box">
            <i class="bi bi-envelope-fill"></i>
            <div class="bx">
                <h4>email</h4>
            <p>bilal@gmail.com</p>
            </div>
            
        </div>
    </div>
</div>
<div class="line5"></div>
<?php include 'footer.php'; ?>

<script src="script.js" type="text/javascript"></script>
</body>
</html>