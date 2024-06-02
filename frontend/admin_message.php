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

    mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'")or die('query field');

    header('location:admin_message.php');

}
// Update product

?>
<style type="text/css">
   <?php 
      include 'style.css';
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
   <section class="message-container">
    <h1 class="title">unread message</h1>
    <div class="box-container">
        <?php 
        $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query field');
        
        if (mysqli_num_rows($select_message) > 0){
            while($fetch_message = mysqli_fetch_assoc($select_message)){

        
        ?>
        <div class="box">
        <p>name: <span><?php echo $fetch_message['name'];?></span></p>

            <details><p>user id: <span><?php echo $fetch_message['id'];?></span></p>
            <p>email: <span><?php echo $fetch_message['email'];?></span></p></details>
            
            <p><?php echo $fetch_message['message'];?></p>
            <a class="delete" href="admin_message.php?delete=<?php echo $fetch_message['id']; ?>;" onclick="return confirm('deletet his message');">delete</a>
        </div>
        <?php 
              }
            } else {
                echo '
                    <div class="empty">
                        <p>No message yet!</p>
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
