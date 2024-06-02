<?php
session_start(); // Start the session

include 'connection.php';
$admin_id = $_SESSION['admin_name'];

if (!isset($admin_id)) {
    header('location: login.php');
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location: login.php');
}


// delete products from databade
if (isset($_GET['delete'])){
    $delete_id = (int)$_GET['delete'];

    mysqli_query($conn, "DELETE FROM `order` WHERE id = '$delete_id'")or die('query field');
    $message[]= 'order removed successfully';
    header('location:admin_order.php');

}
// Update payment
if(isset($_POST['update_order'])){
    $order_id =$_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    mysqli_query($conn, "UPDATE `order` SET payment_status = '$update_payment' WHERE id = '$order_id'") or die('query field');

}

?>
<style type="text/css">
<?php include 'style.css';
?>
</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #8b300fb8;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        .car-image {
            width: 100%;
            max-width: 600px;
            display: block;
            margin: 20px auto;
        }
        footer {
        background-color: #8b300fb8;
        color: #fff;
        text-align: center;
        padding: 10px 20px;
        position: fixed;
        bottom: 0;
        width: 100%;
        display: none; /* Initially hide the footer */
    }
    footer a {
        font-weight: 600;
        color: black;
    }
    </style>
    <title>Admin Panel</title>
</head>

<body>
    <?php 
    include 'admin_header.php';
    ?>
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
    <div class="line4"></div>
    <section class="order-container">
        <h1 class="title">total order account</h1>
        <div class="box-container">
            <?php 
        $select_orders = mysqli_query($conn, "SELECT * FROM `order`") or die('query field');
        
        if (mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){

        
        ?>
            <div class="box">
                
                <p>Order for: <span><?php echo $fetch_orders['name'];?></span></p>
          <details>
                <p>uers id: <span><?php echo $fetch_orders['user_id'];?></span></p>
                <p>placed on: <span><?php echo $fetch_orders['placed_on'];?></span></p>
                <p>number: <span><?php echo $fetch_orders['number'];?></span></p> 
                <p>email: <span><?php echo $fetch_orders['email'];?></span></p> 
                <p>total price: <span><?php echo $fetch_orders['total_price'];?></span></p> 
                <p>method: <span><?php echo $fetch_orders['method'];?></span></p> 
                <p>address: <span><?php echo $fetch_orders['address'];?></span></p> 
                <p>total product: <span><?php echo $fetch_orders['total_products'];?></span></p> 
   
           </details>
           <form method="post">
                    <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id'];?>">
                    <select name="update_payment">
                        <option disabled selected><?php echo $fetch_orders['payment_status'];?></option>
                        <option value="pending">pending</option>
                        <option value="complete">complete</option>
                    </select>
                    <input type="submit" name="update_order" value="update payment" class="btn">
                    <a class=" delete" href="admin_order.php?delete=<?php echo $fetch_orders['id']; ?>;"
                onclick="return confirm('deletet this order');">delete</a>
                </form>
              
               
            </div>
            <?php 
              }
            } else {
                echo '
                    <div class="empty">
                        <p>No order placed yet!</p>
                    </div>
                ';
            }
        ?>

        </div>
    </section>

    <div class="line"></div>
    <footer>
    <div class="contact-info">
        <h2>Contact Us</h2>
        <p>123 Main Street, Cityville, State, ZIP</p>
        <p>Email: info@cardealer.com</p>
        <p>Phone: 123-456-7890</p>
    </div>
    <div class="social-media">
        <h2>Follow Us</h2>
        <a href="https://facebook.com/cardealer" target="_blank"><img src="facebook-icon.png" alt="Facebook"></a>
        <a href="https://twitter.com/cardealer" target="_blank"><img src="twitter-icon.png" alt="Twitter"></a>
        <a href="https://instagram.com/cardealer" target="_blank"><img src="instagram-icon.png" alt="Instagram"></a>
        <!-- Add more social media icons and links as needed -->
    </div>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to show the footer when user scrolls to the bottom
        function showFooterOnScroll() {
            var footer = document.querySelector('footer');
            var windowHeight = window.innerHeight;
            var bodyHeight = document.body.scrollHeight;
            var scrollPosition = window.scrollY || window.pageYOffset;

            if (scrollPosition + windowHeight >= bodyHeight) {
                footer.style.display = 'block'; // Show the footer when scrolled to bottom
            } else {
                footer.style.display = 'none'; // Hide the footer if not at the bottom
            }
        }

        // Show footer on scroll
        window.addEventListener('scroll', showFooterOnScroll);

        // Function to show footer when mouse is within 300px from the bottom
        function showFooterOnMouse() {
            var footer = document.querySelector('footer');
            var windowHeight = window.innerHeight;
            var mouseY = event.clientY;
            var distanceFromBottom = windowHeight - mouseY;

            if (distanceFromBottom <= 300) {
                footer.style.display = 'block'; // Show the footer if mouse is within 300px from bottom
            } else {
                footer.style.display = 'none'; // Hide the footer if mouse is not within 300px from bottom
            }
        }

        // Show footer on mouse move
        window.addEventListener('mousemove', showFooterOnMouse);
    });
</script>
    <script src="script.js" type="text/javascript"></script>
</body>

</html>