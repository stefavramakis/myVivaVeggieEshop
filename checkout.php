<?php

require __DIR__ . '\models\Product.php';
require __DIR__ . '\models\Order.php';
require __DIR__ . '\components\GetVoucherDiscount.php';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<section class="checkout-orders">

      <div class="display-orders">
      <?php
         session_start();
         $selectedProducts = [];
         
         if(isset($_POST['selectedProducts'])){
            foreach($_POST['selectedProducts'] as $productId => $productInfo){
               if(  isset($productInfo['quantity']) && $productInfo['quantity'] > 0){
                  $product = Product::getProduct($productId);
                  $selectedProducts[$product['product_id']] = $product;
                  $selectedProducts[$product['product_id']]['quantity'] = $productInfo['quantity'];
               }
            }
            $_SESSION['selectedProducts'] = $selectedProducts;
         }
         elseif(isset($_SESSION['selectedProducts']))
            $selectedProducts = $_SESSION['selectedProducts'];


         $grand_total = 0;
         $cart_items[] = '';
         if(count($selectedProducts) > 0){
            foreach($selectedProducts as $product){
               $cart_items[] = $product['name'];
               $total_products = implode(',',$cart_items);
               $grand_total += ($product['price'] * (int)$product['quantity']);
            }
            if(isset($_POST['voucher'])){
               
               $discountResult = GetVoucherDiscount::getDiscount($_POST['voucher'], $selectedProducts, $grand_total);
               $selectedProducts = $discountResult["selectedItems"];
               $discount = $discountResult["discount"];
               $_SESSION['discount'] = $discount;
               if($grand_total != $discountResult["grandTotal"]){
                  $grand_total = $discountResult["grandTotal"];
                  $_SESSION['voucher'] = $_POST['voucher'];
               }
            }
            foreach($selectedProducts as $product){
         ?>
               <p> <?= $product['name']; ?> <span><?= '€'.$product['price'] / 100 .' ('. $product['quantity'] .')'; ?></span> </p>
         <?php
            }
         }else{
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>
         <div class="grand-total">grand total : <span>€<?= $grand_total / 100; ?></span></div>
      </div>
      <form action="order_placement.php" method="POST">
      <div class="flex">
         <div class="inputBox">
            <input type="text" name="first_name" placeholder="First Name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <input type="text" name="last_name" placeholder="Last name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required>
         </div>
      </div>
      <input type="hidden" name="total_products" value="<?= $total_products; ?>">
      <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">

      </form>
      <form action="" method="POST">
         <div class="flex">
            <div class="inputBox">
               <input type="text" name="voucher" placeholder="<?= isset($_SESSION['voucher'])?$_SESSION['voucher']:'APPLY VOUCHER'; ?>" class="box" maxlength="50">
               <input type="submit" class="btn <?= isset($_SESSION['voucher'])?'disabled':''; ?>">
            </div>
         </div>
      </form>

   

</section>

</body>
</html>