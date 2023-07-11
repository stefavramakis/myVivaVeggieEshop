<?php

session_start();
session_unset();
session_destroy();

require __DIR__ . '\models\Database.php';
require __DIR__ . '\models\Product.php';

$allproducts = Product::getAllProducts();
if(count($allproducts) == 0){
   Product::initDemoProducts();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Viva Eshop</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php include 'header.php'; ?>
<section class="products">

   <h1 class="heading">Best Fruits in town</h1>

   <div class="box-container">
   <form action="checkout.php" method="post">
    <table id="productList">
      <tr>
        <th>Product</th>
        <th>Quantity</th>
      </tr>
      <?php
         $allproducts = Product::getAllProducts();
         foreach($allproducts as $product){
      ?>
         <tr>
            <td><?=$product['name'] ?></td>
            <td><input sty type="number" id="quantity" name="selectedProducts[<?=$product['id']?>][quantity]" value="0" min=0></td>
         </tr>
      <?php
         }
      ?>
    </table>
    <input class="btn" type="submit" value="Submit">
  </form>
   


  
   </div>

</section>

</body>
</html>
