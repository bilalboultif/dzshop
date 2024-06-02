




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="style.css">
 
    <title>DZ-shop Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
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
</head>
<body>
     <!-- Navigation bar with login and sign-up links -->
   
    <section class="form-container">
  
            <h1>Home page  </h1>         
            <p style="text-align: center;"><a href="login.php">Log in</a> or <a href="register.php">sign up</a></p>            <h1>Welcome to Car Dealer</h1>
            <p style="text-align: center;color: #fff;">Find the best deals on cars and car parts!</p>
            <img style="width: 100%;" src="./img/b12.png">
       
    </section>

    <!-- Footer section -->
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