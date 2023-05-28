<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:Login.php');
}

if(isset($_POST['add_to_cart'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart';
    }else{

        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($check_wishlist_numbers) > 0){
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
        }

        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart';
    }

}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE id = '$delete_id'") or die('query failed');
    header('location:wishlist.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
    header('location:wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>wishlist</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
 <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="wishlist">
<h2 class="text-center" >your wishlist</h2>
    <h2 class="text-center" > <a href="home.php">home</a> / wishlist </h2>
    <h1 class="title">products added</h1>
    <div class="box-container">

    <?php
        $grand_total = 0;
        $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_wishlist) > 0){
            while($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)){
    ?>
    <form action="" method="POST" class="box">
        <a href="wishlist.php?delete=<?php echo $fetch_wishlist['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from wishlist?');"></a>
        <a href="view_page.php?pid=<?php echo $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
        <img src="Cakes/<?php echo $fetch_wishlist['image']; ?>" alt="" class="image">
        <div class="name"><?php echo $fetch_wishlist['name']; ?></div>
        <div class="price">$<?php echo $fetch_wishlist['price']; ?>/-</div>
        <input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['pid']; ?>">
        <input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['name']; ?>">
        <input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price']; ?>">
        <input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image']; ?>">
        <div class="row">
    <div class="col-sm-5 col-md-6"> <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn"></div>
    <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0">  <input type="submit" value="add to cart" name="add_to_cart" class="btn"></div>
  </div>
        
    </form>
    <?php
    $grand_total += $fetch_wishlist['price'];
        }
    }else{
        echo '<p class="empty">your wishlist is empty</p>';
    }
    ?>
    </div>

    <div class="wishlist-total">
        <p>grand total : <span>$<?php echo $grand_total; ?>/-</span></p>
        <a href="shop.php" class="option-btn">continue shopping</a>
        <a href="wishlist.php?delete_all" class="option-btn" <?php echo ($grand_total > 1)?'':'disabled' ?>" onclick="return confirm('delete all from wishlist?');">delete all</a>
    </div>

</section>






<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>
<style>
    body{
        background: rgb(131,58,180);
background: -moz-linear-gradient(228deg, rgba(131,58,180,1) 0%, rgba(253,29,128,1) 50%, rgba(252,176,69,1) 100%);
background: -webkit-linear-gradient(228deg, rgba(131,58,180,1) 0%, rgba(253,29,128,1) 50%, rgba(252,176,69,1) 100%);
background: linear-gradient(228deg, rgba(131,58,180,1) 0%, rgba(253,29,128,1) 50%, rgba(252,176,69,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#833ab4",endColorstr="#fcb045",GradientType=1);
    }
</style>
</body>
</html>