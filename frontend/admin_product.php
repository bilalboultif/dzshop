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
if (isset($_POST['add_product'])) {
    $product_name = mysqli_real_escape_string($conn, $_POST['name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['price']);
    $product_detail = mysqli_real_escape_string($conn, $_POST['detail']);

    // File Upload
    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_folder = 'image/' . $image_name;
    $image_file_type = strtolower(pathinfo($image_folder, PATHINFO_EXTENSION));

    // Check if product name already exists
    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name ='$product_name'");
    if (mysqli_num_rows($select_product_name) > 0) {
        $message[] = 'Product name already exists';
    } else {
        // Check file type and size
        if ($image_file_type != 'jpg' && $image_file_type != 'jpeg' && $image_file_type != 'png' && $image_file_type != 'gif') {
            $message[] = 'Only JPG, JPEG, PNG, and GIF files are allowed';
        } elseif ($image_size > 2000000) {
            $message[] = 'Image size is too large';
        } else {
            // Move uploaded file to destination folder
            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                // Insert product data into database
                $insert_product = mysqli_query($conn, "INSERT INTO `products`(`name`, `price`, `product_detail`, `image`)
                VALUES ('$product_name','$product_price','$product_detail','$image_name')");
                if ($insert_product) {
                    $message[] = 'Product added successfully';
                } else {
                    $message[] = 'Failed to add product to database';
                }
            } else {
                $message[] = 'Failed to upload image';
            }
        }
    }
}

// delete products from databade
if (isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $select_delete_image = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query field');
    $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
    unlink('image/'.$fetch_delete_image['image']);

    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'")or die('query field');
    mysqli_query($conn, "DELETE FROM `cart` WHERE pid = '$delete_id'")or die('query field');
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$delete_id'")or die('query field');

    header('location:admin_product.php');

}
// Update product
if(isset($_POST['update_product'])){
    $update_id = $_POST['update_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];
    $update_detail = $_POST['update_detail'];

    // Check if a new image is uploaded
    if(!empty($_FILES['update_image']['name'])) {
        $update_image = $_FILES['update_image']['name'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_folder = 'image/'.$update_image;


        // Update with new image
        $update_query = mysqli_query($conn, "UPDATE `products` SET `name`='$update_name',`price`='$update_price', `product_detail`='$update_detail', `image`='$update_image' WHERE id = '$update_id'") or die('query field');
        if ($update_query) {
            move_uploaded_file($update_image_tmp_name,$update_image_folder);
            header('location:admin_product.php');
        }
    } else {
        // Update without changing the image
        $update_query = mysqli_query($conn, "UPDATE `products` SET `name`='$update_name',`price`='$update_price', `product_detail`='$update_detail' WHERE id = '$update_id'") or die('query field');
        if ($update_query) {
            header('location:admin_product.php');
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
    <script>
         window.addEventListener('scroll', function() {
    var navbar = document.querySelector('.dashboard');
    var scrollPosition = window.scrollY;
    if (scrollPosition > 100) { // Adjust as needed
      navbar.style.background = "linear-gradient(to top, rgba(234, 81, 26, 0), rgba(234, 81, 26, 1))";
    } else {
      navbar.style.background = "linear-gradient(to top, rgba(234, 81, 26, 0), rgba(234, 81, 26, " + (scrollPosition / 100) + "))";
    }
  });
    </script>
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
   <div class="line2"></div>
   <section class="add-products form-container">
      <form method="POST" action="" enctype="multipart/form-data">
          <div class="input-field">
            <label>product name</label>
            <input type="text" name="name" required>
          </div>
          <div class="input-field">
            <label>product price</label>
            <input type="text" name="price" required>
          </div>
          <div class="input-field">
            <label>product detail</label>
            <textarea name="detail" required></textarea>
          </div>
          <div class="input-field">
            <label>product image</label>
            <input type="file" name="image" accept="image/jpg, image/png, image/png, imge/webp" required>
          </div>
          <input type="submit" name="add_product" value="add product" class="btn">
      </form>
   </section>
   <div class="line3"></div>
    <div class="line4"></div>
    <section class="show-products">
        <div class="box-container">
            <?php 
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query field');
            if (mysqli_num_rows($select_products)>0){
                while($fetch_products = mysqli_fetch_assoc($select_products)) {
                  
             
            ?>
            <div class="box">
               <img src="image/<?php echo $fetch_products['image']; ?>">
               <p>price : $<?php echo $fetch_products['price']; ?> </p>
               <h4><?php echo $fetch_products['name']; ?>  </h4>
               <details>$<?php echo $fetch_products['product_detail']; ?> </details>
               <a href="admin_product.php?edit=<?php echo $fetch_products['id']; ?>" class="edit">edit</a>
               <a href="admin_product.php?delete=<?php echo $fetch_products['id']; ?>" class="delete" onclick="
               return confirm('want to delete thid product');">delete</a>

            </div>
            <?php
                } 
            }else{
                echo '
                <div class="empty">
                <p>noroducts added yet!</p>
            </div>
                ';
               }
            ?>
          
        </div>
    </section>
    <div class="line"></div>
    <section class="update-container">
        <?php 
        if (isset($_GET['edit'])){
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$edit_id'") or die('query field');
            if (mysqli_num_rows($edit_query)>0) {
              while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
                
              

         
        ?>
        <form method="POST" enctype="multipart/form-data" class="">
          <img src="image/<?php echo $fetch_edit['image']; ?>" >
          <input type="hidden" name="update_id" value="<?php echo $fetch_edit['id']; ?>">
          <input type="text" name="update_name" value="<?php echo $fetch_edit['name']; ?>">
          <input type="number" name="update_price" min="0" value="<?php echo $fetch_edit['price']; ?>">
        <textarea name="update_detail"><?php echo $fetch_edit['product_detail']; ?></textarea>
        <input type="file" name="update_image" accept="image/jpg, image/png, image/png, imge/webp" >
        <input type="submit" id="updateButton" name="update_product" value="update" class="edit" onclick="closeForm()">
        <input type="reset" name="" value="Cancel" class="option-btn btn" onclick="closeForm()">

        </form>
        <?php 
             }
            }
            echo "
            <script>
            function closeForm() {
                document.querySelector('.update-container').style.display = 'none';
            }
            document.querySelector('.update-container').style.display='block'</script>
            ";
        }
        ?>
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

       <script src="script.js" type="text/javascript"></script>
</body>
</html>
