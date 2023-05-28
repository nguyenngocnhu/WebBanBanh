<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_wishlist'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   
   $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_wishlist_numbers) > 0){
       $message[] = 'already added to wishlist';
   }elseif(mysqli_num_rows($check_cart_numbers) > 0){
       $message[] = 'already added to cart';
   }else{
       mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
       $message[] = 'product added to wishlist';
   }

}

if(isset($_POST['add_to_cart'])){

   $product_id = $_POST['product_id'];
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="styles.css">

   <!-- custom admin css file link  -->
</head>
<body>
<?php @include 'header.php'; ?>
   <div class="comeo  ">
   <div class="container px-5 py-24 mx-auto flex flex-wrap">
    <div class="flex w-full mb-20 flex-wrap">
      <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900 lg:w-1/3 lg:mb-0 mb-4">About</h1>
      <p class="lg:pl-6 lg:w-2/3 mx-auto leading-relaxed text-base">Cake Nhu Y started as a small family-owned bakery in the early 2002s.
                        After nearly 20 years of construction and development, Cake Nhu Y has built a chain of stores with
                        30 large and small bread and pastry shops spread across Hanoi city.
                        As a brand known for its quality products and
                        delicious from bread, cakes, ice cream cakes to other products such as Hamburger, Sandwich, Moon cake, savory cake, etc. Along with the spirit of inquisitiveness and responsibility, Nhu Y Bakery 
                        has been and will always bring. offering customers hot and crispy loaves, delicious, nutritious and hygienic cakes at affordable prices.</p>
    </div>
    <div class="flex flex-wrap md:-m-2 -m-1">
      <div class="flex flex-wrap w-1/2">
        <div class="md:p-2 p-1 w-1/2">
          <img alt="gallery" class="w-full object-cover h-full object-center block" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQxdXx8LRHu2G8nBBjWwPHOO3v_nXpl4UYJSQ&usqp=CAU">
        </div>
        <div class="md:p-2 p-1 w-1/2">
          <img alt="gallery" class="w-full object-cover h-full object-center block" src="https://t3.ftcdn.net/jpg/02/56/20/36/240_F_256203641_oEl56isLMgFmDv5TsVOHQtp8dIclS0f7.jpg">
        </div>
        <div class="md:p-2 p-1 w-full">
          <img alt="gallery" class="w-full h-full object-cover object-center block" src="data:image/jpeg;base64,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">
        </div>
      </div>
      <div class="flex flex-wrap w-1/2">
        <div class="md:p-2 p-1 w-full">
          <img alt="gallery" class="w-full h-full object-cover object-center block" src="https://i.makeagif.com/media/10-06-2016/h-N-PL.gif">
        </div>
        <div class="md:p-2 p-1 w-1/2">
          <img alt="gallery" class="w-full object-cover h-full object-center block" src="https://img.freepik.com/free-photo/vertical-shot-chocolate-cake-with-raspberry-decorations-served-white-plate_181624-60111.jpg?size=626&ext=jpg&ga=GA1.2.1694761013.1683961309&semt=sph">
        </div>
        <div class="md:p-2 p-1 w-1/2">
          <img alt="gallery" class="w-full object-cover h-full object-center block" src="https://gifdb.com/images/high/funny-girl-birthday-pa3gb8mxqz2yx3b3.gif">
        </div>
      </div>
    </div>
  </div>
   </div>
    <div class="offer">
        <h2>HOT SPECIAL OFFER</h2>
        <p class="text-center">Buy products within 24 hours and get 20% off</p>
        <button onclick="showCode()">Show vouchers</button>
        <div class="code" id="code" style="display:none">
            <p>Vouchers: <span>20OFF</span></p>
            <small>*Only applicable when buying online from the website</small>
        </div>
    </div>
<div class="products bg-dark">
   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 10") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <form action="" method="POST" class="box">
         <a href="view.php?pid=<?php echo $fetch_products['id']; ?>" class="fa fa-eye"></a>
         <div class="price">$<?php echo $fetch_products['price']; ?>/-</div>
         <img src="Cakes/<?php echo $fetch_products['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <input type="number" name="product_quantity" value="1" min="0" class="qty">
         <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <input  class="image-fluid"type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
         <input type="hidden" name="product_details" value="<?php echo $fetch_products['details']; ?>">
         <div class="row">
    <div class="col-sm-5 col-md-6"> <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn"></div>
    <div class="col-sm-5 offset-sm-2 col-md-6 offset-md-0"></div>
  </div>
         
       
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>

   </div>

</div>





<?php @include 'footer.php'; ?>
<style>
   .comeo,.products{
      background: rgb(131,58,180);
background: -moz-linear-gradient(228deg, rgba(131,58,180,1) 0%, rgba(253,29,128,1) 50%, rgba(252,176,69,1) 100%);
background: -webkit-linear-gradient(228deg, rgba(131,58,180,1) 0%, rgba(253,29,128,1) 50%, rgba(252,176,69,1) 100%);
background: linear-gradient(228deg, rgba(131,58,180,1) 0%, rgba(253,29,128,1) 50%, rgba(252,176,69,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#833ab4",endColorstr="#fcb045",GradientType=1);
   }
     .more-btn{
   text-align: center;
   margin-bottom: 10px;
     }
</style>
<script src="js/scripts.js"></script>
<!-- Start quảng cáo góc trái màn hình by Code Pro -->
<style>#codepro-ads-bottom-left-corner{position:fixed;bottom:0;left:0;z-index:9999}.exit-codepro-ads-bottom-left-corner{position:fixed;display:flex;align-items:center;justify-content:center;background:linear-gradient(179.83deg,rgb(255,75,91) 0.15%,rgb(255,148,158) 92.02%);height:30px;width:30px;z-index:100;border-radius:100%;bottom:230px;left:230px}.exit-codepro-ads-bottom-left-corner i{font-size:15px;margin:0;color:#fff}@media(max-width:1024px){#codepro-ads-bottom-left-corner{display:none!important}}.codepro-ads-bottom-left-corner-hover:hover{opacity:.9}#codepro-setAds-left{width:250px;height:250px;border-radius:10px;background-position:center center;background-size:cover;background-repeat:no-repeat}</style>
<div id='codepro-ads-bottom-left-corner'>
    <div class='exit-codepro-ads-bottom-left-corner'>
        <a href='javascript:;' onclick='hideitem()'><i aria-hidden='true' class='fa fa-times'/></a>
    </div>
    <a href='https://www.code.pro.vn/' target='_blank' title='Chia sẻ kiến thức, tư duy sáng tạo!'>
        <div class='codepro-ads-bottom-left-corner-hover' id='codepro-setAds-left'/>
    </a>
</div>
<script language='JavaScript'>
    function hideitem() {
        document.getElementById("codepro-ads-bottom-left-corner").style.display = "none";
    }
</script>
<script>
    //<![CDATA[
        var random = Math.floor(Math.random() * 4) + 0;
        var imagearray = [
            "url('data:image/jpeg;base64,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')",
            "url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTyf0qnSykHDgnzVNRuXJD71PWb_OVOtbINGDiHelbz2g&s')",
            "url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3_AAvqoIQO_BzwZ4rXYhGEVPySL5rAUvAIp-qdnkI&s')",
            "url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJ7mFD3FPQaubp8GTqASDphVpJ_ZCmpptUQ7-WEtxnhg&s')"
        ];
        document.getElementById("codepro-setAds-left").style.backgroundImage = imagearray[random];
    //]]>
</script>
<!-- End quảng cáo góc trái màn hình by Code Pro -->
</body>