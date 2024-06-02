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
             <h1>about us</h1>
             <p>this section is for information about us ...</p>
             <a href="index.php">home</a><span>/ about us</span>
         </div>
    </div>
    <!--------------------about us---------------------------->
    <div class="line5"></div>
    <div class="about-us">
        <div class="row">
            <div class="box">
                <div class="title">
                    <span>ABOUT OUR ONLINE STORE</span>
                    <h1>Hello, With 25 year experiances</h1>
                    <p>Perform basic care and maintenance, including changing oil,                 checking fluid levels, and rotating tires. 
                         Repair or replace worn parts, such as brake pads,
                          wheel bearings, and sensors. Perform repairs to manufacturer 
                          and customer specifications. 
                          Explain automotive problems and repairs to clients.</p>
                </div>
                <div class="img-box">
                    <img src="img/about.jpg">
                </div>
            </div>
        </div>
    
    <div class="line5"></div>
    <!---------------------features------------------------>
    <div class="line5"></div>
    <div  class="features">
        <div class="title">
            <h1>Complete Custmer Ideas</h1>
            <span>best features</span>
        </div>
        <div class="row">
            <div class="box">
                <img src="img/i1.png">
                <h4>24/7</h4>
                <p>Online Support 27/7</p>
            </div>
            <div class="box">
                <img src="img/i2.png">
                <h4>money back</h4>
                <p>100% secure payment</p>
            </div>
            <div class="box">
                <img src="img/i3.png">
                <h4>special gift card</h4>
                <p>give the perfect gift</p>
            </div>
            <div class="box">
                <img src="img/i4.png">
                <h4>worldwide shipping</h4>
                <p>On order Over $99/p>
            </div>

        </div>
    </div>
    <div class="line5"></div>
    <!---------------------team section------------------------>
    <div class="line"></div>
    <div class="team">
        <div class="title">
            <h1>Our Workable Team</h1>
            <span>best team</span>
        </div>
        <div class="row">
            <div class="box">
                <div class="box-img">
                <img src="img/team3.png">
                </div>
                <div class="detail">
                    <span> Finace Manager</span>
                    <h4>Bilal Boultif</h4>
                    <div class="icons">
               <i class="bi bi-instagram"></i>
               <i class="bi bi-youtube"></i>
               <i class="bi bi-twitter"></i>
               <i class="bi bi-facebook"></i>
               <i class="bi bi-whatsapp"></i>
               </div>
                </div>
            </div>
            <div class="box">
                <div class="box-img">
                <img src="img/team2.jpg">
                </div>
                <div class="detail">
                    <span> Finace Manager</span>
                    <h4>Bilal Boultif</h4>
                    <div class="icons">
               <i class="bi bi-instagram"></i>
               <i class="bi bi-youtube"></i>
               <i class="bi bi-twitter"></i>
               <i class="bi bi-facebook"></i>
               <i class="bi bi-whatsapp"></i>
               </div>
                </div>
            </div>
            <div class="box">
                <div class="box-img">
                <img src="img/team3.jpg">
                </div>
                <div class="detail">
                    <span> Finace Manager</span>
                    <h4>Bilal Boultif</h4>
                    <div class="icons">
               <i class="bi bi-instagram"></i>
               <i class="bi bi-youtube"></i>
               <i class="bi bi-twitter"></i>
               <i class="bi bi-facebook"></i>
               <i class="bi bi-whatsapp"></i>
               </div>
                </div>
            </div>
            <div class="box">
                <div class="box-img">
                <img src="img/team4.jpg">
                </div>
                <div class="detail">
                    <span> Finace Manager</span>
                    <h4>Bilal Boultif</h4>
                    <div class="icons">
               <i class="bi bi-instagram"></i>
               <i class="bi bi-youtube"></i>
               <i class="bi bi-twitter"></i>
               <i class="bi bi-facebook"></i>
               <i class="bi bi-whatsapp"></i>
               </div>
                </div>
            </div>
        </div>
    </div>
    <div class="line"></div>
    <div class="line5"></div>
    <div class="project">
        <h1> Our best Project</h1>
        <span>how it works</span>
    
    <div class="row">
        <div class="box">
        <img src="img/about1.webp">
        </div>
        <div class="box">
        <img src="img/about1.jpg">
        </div>
    </div>
    </div>
    <div class="line5"></div>
    <div calss="line"></div>
    <div class="ideas">
        <div class="title">
            <h1>We and Our Clients are Happy to Cooperate with Our Company </h1>
            <span>our features</span>
        </div>
        <div class="row">
            <div class="box">
                <i class="bi bi-stack"></i>
                <div class="detail">
                    <h2>What We Really Do </h2>
                    <p>Experience unparalleled customer service at each vehicle service visit.
                         to basic maintenance needs on every make and model car or truck.</p>
                </div>
            </div>
            <div class="box">
                <i class="bi bi-grid-1x2-fill"></i>
                <div class="detail">
                    <h2>What We Really Do </h2>
                    <p>Experience unparalleled customer service at each vehicle service visit.
                         to basic maintenance needs on every make and model car or truck.</p>
                </div>
            </div>
            <div class="box">
                <i class="bi bi-tropical-storm"></i>
                <div class="detail">
                    <h2>What We Really Do </h2>
                    <p>Experience unparalleled customer service at each vehicle service visit.
                         to basic maintenance needs on every make and model car or truck.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="line5"></div>
<?php include 'footer.php'; ?>

<script src="script.js" type="text/javascript"></script>
</body>
</html>