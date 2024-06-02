<?php
include 'connection.php';
if (isset($_POST['submit-btn'])) {
    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($conn, $filter_name);

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);

    $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
    $password = mysqli_real_escape_string($conn, $filter_password);

    $filter_cpassword = filter_var($_POST['cpassword'], FILTER_SANITIZE_STRING);
    $cpassword = mysqli_real_escape_string($conn, $filter_cpassword);

    $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_user) > 0) {
        $message[] = 'user already exist';
    } else {
        if ($password != $cpassword) {
            $message[] = 'wrong password';
        } else {
            mysqli_query($conn, "INSERT INTO `users`(`name`, `email`, `password`) VALUES ('$name', '$email', '$password')") or die('query failed');
            $message[] = 'registered successfully';
            header('location:login.php');
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
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
    <title>Register page</title>
</head>
<body>
 
    <section class="form-container">
  
        <form method="post">
            <h1>register now</h1>
            <input type="text" name="name" placeholder="enter your name" required>
<input type="email" name="email" placeholder="enter your email" required>
<input type="password" name="password" placeholder="enter your password" required>
<input type="password" name="cpassword" placeholder="confirm your password" required>

            <input type="submit" name="submit-btn" value="register now" class="btn">
            <p>already have an account ? <a href="login.php">login now</a></p>

        </form> 
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
    </section>
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

</body>
</html>