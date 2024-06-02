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
if (isset($_POST['order-btn'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'flat no. '.$_POST['flate'].','.$_POST['street'].','.$_POST['city'].','.$_POST['state'].','.$_POST['country'].','.$_POST['pin']);
    $palced_on = date('d-M-Y');
    $cart_total=0;
    $cart_product[]='';
     

     $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
    if (mysqli_num_rows($cart_query)>0){
             while($cart_item=mysqli_fetch_assoc($cart_query)){
                $cart_product[] = $cart_item['name'].' ('.$cart_item['quantity'].')';
                $sub_total = ($cart_item['price'] * $cart_item['quantity']);
                $cart_total+=$sub_total;

             }
    } 
    $total_products = implode(', ', $cart_product);
    mysqli_query($conn, "INSERT INTO `order`(`user_id`, `name`, `number`, `email`, `method`, `address`,`total_products`,`total_price`,`placed_on`) VALUES('$user_id', '$name', '$number', '$email', '$method','$address', '$total_product', '$cart_total','$placed_on')");
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id ='$user_id'");
    $message[]='order placed successfully';
    header('location:checkout.php');
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
            <h1>checkout page</h1>
            <p>this section is for information about us ...</p>
            <a href="index.php">home</a><span>/ checkout</span>
        </div>
    </div>
    <!--------------------about us---------------------------->

    <div class="line"></div>
    <div class="checkout-form">
        <h1 class="title">payment process</h1>
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
        <div class="display-order">
            <div>
                <?php 
           $select_cart= mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id='$user_id'") or die('query failed');
           $total=0;
           $grand_total =0;
           if(mysqli_num_rows($select_cart)>0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
              $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
              $grand_total=$total+=$total_price;
           
           ?>

                <div class="box">
                    <img src="image/<?php echo $fetch_cart['image']?>">
                    <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity'];?>)</span>
                </div>

                <?php 
            }
        }
           ?>
            </div>
            <span class="grand-total">Total Amount Payable : $ <?= $grand_total ?></span>
        </div>
        <form method="post">
            <div class="input-field">
                <label>your name</label>
                <input type="text" name="name" placeholder="enter your name">
            </div>
            <div class="input-field">
                <label>your number</label>
                <input type="text" name="number" placeholder="enter your number">
            </div>
            <div class="input-field">
                <label>your email</label>
                <input type="text" name="email" placeholder="enter your email">
            </div>

            <div class="input-field">
                <label>select payment method</label>
                <select id="paymentMethod" name="method">
                    <option selected disabled>select payment method</option>
                    <option value="cash on delivery"> cash on delivery</option>
                    <option value="paytm">paytm</option>
                    <option value="credit card">credit card</option>
                    <option value="paypal">paypal</option>
                </select>
                <div id="creditCardFields" style="display: none;">
                    <div class="input-field">
                        <label>Cardholder's Name</label>
                        <input type="text" name="cardholder_name" placeholder="Enter cardholder's name">
                    </div>
                    <div class="input-field">
                        <label>Card Number</label>
                        <input type="text" name="card_number" placeholder="Enter card number">
                    </div>
                    <div class="input-field">
                        <label>Expiration Date</label>
                        <input type="text" name="expiration_date" placeholder="MM/YYYY">
                    </div>
                    <div class="input-field">
                        <label>Security Code (CVV)</label>
                        <input type="text" name="security_code" placeholder="Enter CVV">
                    </div>
                   

                </div>
                <div id="paypalFields" style="display: none;">
                        <div class="input-field">
                            <label>PayPal Email</label>
                            <input type="email" name="paypal_email" placeholder="Enter PayPal email">
                        </div>
                        <div class="input-field">
                            <label>Password</label>
                            <input type="password" name="paypal_password" placeholder="Enter PayPal password">
                        </div>
                        <button type="button" onclick="processPayPalPayment()">Proceed with PayPal Payment</button>
                    </div>
            </div>
            <div class="input-field">
                <label>address line 1</label>
                <input type="text" name="flate" placeholder="e.g street name">
            </div>
            <div class="input-field">
                <label>address line 2</label>
                <input type="text" name="flate" placeholder="e.g apt">
            </div>
            <div class="input-field">
                <label>city</label>
                <input type="text" name="city" placeholder="e.g indianapolis">
            </div>
            <div class="input-field">
                <label>state</label>
                <input type="text" name="state" placeholder="e.g INDIANA">
            </div>
            <div class="input-field">
                <label>zip code </label>
                <input type="text" name="flate" placeholder="e.g 46260">
            </div>
            <div class="input-field">
                <label>country</label>
                <input type="text" name="country" placeholder="e.g USA">
            </div>
            <input type="submit" name="order-btn" class="btn" value="order now">
        </form>
    </div>

    <div class="line5"></div>
    <?php include 'footer.php'; ?>

    <script src="script.js" type="text/javascript"></script>
    <script>
    document.getElementById('paymentMethod').addEventListener('change', function() {
        var paymentMethod = this.value;
        if (paymentMethod === 'paypal') {
            document.getElementById('paypalFields').style.display = 'block';
            document.getElementById('creditCardFields').style.display = 'none';
        } else if (paymentMethod === 'credit card') {
            document.getElementById('creditCardFields').style.display = 'block';
            document.getElementById('paypalFields').style.display = 'none';
        } else {
            document.getElementById('creditCardFields').style.display = 'none';
            document.getElementById('paypalFields').style.display = 'none';
        }
    });




    function processPayPalPayment() {
        // Fetch PayPal email and password from the form
        var paypalEmail = document.getElementsByName('paypal_email')[0].value;
        var paypalPassword = document.getElementsByName('paypal_password')[0].value;

        // You can perform further validation here if required

        // Send PayPal email and password to the server for payment processing
        // Example AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'process_paypal_payment.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from the server
                var response = xhr.responseText;
                // Display success or error message to the user
                alert(response);
            }
        };
        xhr.send('paypal_email=' + encodeURIComponent(paypalEmail) + '&paypal_password=' + encodeURIComponent(
            paypalPassword));
    }
    </script>
</body>

</html>