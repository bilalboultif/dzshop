<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootsrtap-icons.css">
    <link rel="stylesheet" type="text/css" href="slick.css"/>
    <link rel="stylesheet" href="main.css">
    <title>Home Page</title>
</head>
<body>
    <section class="popular-brands">
        <h2>POPULAR BRANDS</h2>
        <div class="controls">
    <i class="bi bi-chevron-left left"></i>
    <i class="bi bi-chevron-right right"></i>
   </div>
   <div class="popular-brands-content">
    <?php 
    $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
    if (mysqli_num_rows($select_products) > 0) {
       while ($fetch_products = mysqli_fetch_assoc($select_products)){

  
    ?>
    <form method="post" class="card">
        <div class="price"><?php echo $fetch_products['price']; ?>$</div>
       <img src="image/<?php echo $fetch_products['image']; ?>">
       
       <div class="name"><?php echo $fetch_products['name']; ?></div>
       <input type="hidden" name="product_id" class="" value="<?php echo $fetch_products['id']; ?>">
       <input type="hidden" name="product_name" class="" value="<?php echo $fetch_products['name']; ?>">
       <input type="hidden" name="product_price" class="" value="<?php echo $fetch_products['price']; ?>">
       <input type="hidden" name="product_quantity" class="" value="1" min="1">
       <input type="hidden" name="product_id" class="" value="<?php echo $fetch_products['image']; ?>">
       <div class="icon">
        <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="bi bi-eye-fill"></a>
        <button type="submit" name="add_to_wishlist" class="bi bi-heart"></button>
        <button type="submit" name="add_to_cart" class="bi bi-cart"></button>
       </div>
    </form>
   
    <?php 
         }
        } else { 
            echo '<p class="empty">no products added yet!</p>';
        }
    ?>
   </div>
    </section>
    <script src="jquery.js"></script>
<script src="slick.js"></script>
    <script type="text/javascript">

$('.popular-brands-content').slick({
    lazyLoad: 'ondemand',
  slidesToShow: 4,
  slidesToScroll: 1,
  nextArrow:$('.left'),
    prevArrow:$('.right'),
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});
    </script>

</body>
</html>