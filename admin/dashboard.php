<?php
   require(__DIR__.'/../models/Order.php');

   if(isset($_POST['cancelOrder'])){
      Order::cancelOrder($_POST['cancelOrder']);
   }

   include '../header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>


<section class="dashboard">

   <h1 class="heading">orders dashboard</h1>

   <div class="box-container">

      <div class="box" style="display: flex; flex-wrap: wrap; justify-content:space-between">
            <?php
            $placedOrders = Order::getPlacedOrders();
            if(count($placedOrders) > 0){
               foreach($placedOrders as $order){
            ?>
                  <div style="width: 40%;padding: 10px;">
                     <form action="" method="post">
                        <div>
                           <div style="display: flex; align-items:center;">
                              <div style="width: 50%;font-size: 16px; border: 1px solid;">Order Code</div>
                              <div style="width: 50%;font-size: 16px; border: 1px solid;"><?=$order['order_code'] ?></div>
                           </div>
                           <div style="display: flex; align-items:center;">
                              <div style="width: 50%;font-size: 16px; border: 1px solid;">Transaction Id</div>
                              <div style="width: 50%;font-size: 16px; border: 1px solid;"><?=$order['transaction_id'] ?></div>
                           </div>
                           <div style="display: flex; align-items:center;">
                              <div style="width: 50%;font-size: 16px; border: 1px solid;">Products</div>
                              <div style="width: 50%;font-size: 16px; border: 1px solid;"><?=$order['products'] ?></div>
                           </div>
                           <div style="display: flex; align-items:center;">
                              <div style="width: 50%;font-size: 16px; border: 1px solid;">Amount</div>
                              <div style="width: 50%;font-size: 16px; border: 1px solid;"><?=$order['amount']/100 ?> €</div>
                           </div>
                           <div style="display: flex; align-items:center;">
                              <div style="width: 50%;font-size: 16px; border: 1px solid;">Order’s state</div>
                              <div style="width: 50%;font-size: 16px; border: 1px solid;"><?=Order::getOrderStatusPrettyName($order['state_id']) ?></div>
                           </div>
                           <div style="display: flex; align-items:center;">
                              <div style="width: 50%;font-size: 16px; border: 1px solid;">Customer Name</div>
                              <div style="width: 50%;font-size: 16px; border: 1px solid;"><?=$order['customer_name'] ?></div>
                           </div>
                           <div style="display: flex; align-items:center;">
                              <div style="width: 50%;font-size: 16px; border: 1px solid;">Customer Email</div>
                              <div style="width: 50%;font-size: 16px; border: 1px solid;"><?=$order['customer_email'] ?></div>
                           </div>
                        </div>
                        <?php
                           if($order['state_id'] != Order::ORDER_STATUS_CANCELED){
                        ?>
                        <input type="hidden" name="cancelOrder" value="<?=$order['id'] ?>">
                        <input class="delete-btn" type="submit" value="Cancel Order">
                        <?php
                           }
                        ?>
                        </form>
                  </div>
               <?php
               }
            }else{
               echo '<p class="empty">no orders placed yet!</p>';
            }
      ?>
      </div>

   </div>

</section>

   
</body>
</html>