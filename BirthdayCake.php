<?php @include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Scrolling Nav - Start Bootstrap Template</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body id="page-top">
    <!-- Navigation-->
    <?php @include 'header.php'; ?>
    <!-- Header-->
    <header class="ny text-white" style="height:500px">
        <div class="container px-4 text-center">
            <h1 class="fw-bolder">Welcome to Scrolling Nav</h1>
            <p class="lead">A functional Bootstrap 5 boilerplate for one page scrolling websites</p>
            <a class="btn btn-lg btn-light" href="about.php">Learn more</a>
        </div>
    </header>
    <div class="offer">
        <h2>HOT SPECIAL OFFER</h2>
        <p class="text-center">Buy products within 24 hours and get 20% off</p>
        <button onclick="showCode()">Show vouchers</button>
        <div class="code" id="code" style="display:none">
            <p>Vouchers: <span>20OFF</span></p>
            <small>*Only applicable when buying online from the website</small>
        </div>
    </div>
    <!-- About section-->
    <div class="products">
        <div class="container px-4">
            <h1 class="title">latest products</h1>

            <div class="box-container">

                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE n = 'bt' LIMIT 6") or die('query failed');
                if (mysqli_num_rows($select_products) > 0) {
                    while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                        ?>
                        <form action="" method="POST" class="box">
                            <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fa fa-eye"></a>
                            <div class="price">$
                                <?php echo $fetch_products['price']; ?>/-
                            </div>
                            <img src="Cakes/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                            <div class="name">
                                <?php echo $fetch_products['name']; ?>
                            </div>
                            <input type="number" name="product_quantity" value="1" min="0" class="qty">
                            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                            <div class="row">
    <div class="col-sm-5 col-md-6"> <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn"></div>
    <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0">  <input type="submit" value="add to cart" name="add_to_cart" class="btn"></div>
  </div>
                        </form>
                        <?php
                    }
                } else {
                    echo '<p class="empty">no products added yet!</p>';
                }
                ?>

            </div>

            <div class="more-btn">
                <a href="shop.php" c </div>
    </section>
    <!-- Footer-->

    <?php @include 'footer.php'; ?>
                <style>
                      .ny{
            background-image: url('https://img.freepik.com/free-vector/hand-drawn-birthday-wallpaper-theme_23-2148467663.jpg?size=626&ext=jpg&ga=GA1.1.1694761013.1683961309&semt=ais');
       background-repeat: no-repeat;
       max-height: 500px;
       background-size: cover
        }
                   
                </style>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>