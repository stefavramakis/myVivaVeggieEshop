<?php 
    include 'header.php';

    require  'models\Order.php';

    session_start();
    
    $transactionId = $_GET['t'];
    $orderCode = $_GET['s'];
    Order::finalizeOrderPayment($orderCode, Order::ORDER_STATUS_PAID, $transactionId);
?>

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


<h1>Success Transaction with Viva Wallet</h1>