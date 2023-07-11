<?php
session_start();
require __DIR__ . '\models\Order.php';
require __DIR__ . '\components\VivaPaymentProvider.php';

if(isset($_POST['order'])){
   $first_name = $_POST['first_name'];
   $first_name = htmlspecialchars($first_name);
   $last_name = $_POST['last_name'];
   $last_name = htmlspecialchars($last_name);
   $email = $_POST['email'];
   $email = htmlspecialchars($email);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   if(isset($_SESSION['discount']))
      $discount = $_SESSION['discount'];

   $data['fullName'] = $first_name . ' ' . $last_name;
   $data['email'] = $email;
   $data['amount'] = round($total_price);
   $paymentRequest = new VivaPaymentProvider;
   $paymentRequest->data = $data;
   $authToken = $paymentRequest->getAuthorization();
   $orderCode = $paymentRequest->getOrderCode($authToken,$data);
   $orderCode = $orderCode['orderCode'];
   $order = new Order;
   $order->order_code  = $orderCode;
   $order->products = $total_products;
   $order->discount = isset($discount) ? round($discount) : 0;
   $order->amount = round($total_price);
   $order->customer_name = $first_name . ' ' . $last_name;
   $order->customer_email = $email;
   $order->create();
   
   $smartCheckoutUrl = 'https://demo.vivapayments.com/web/checkout?ref=' . $orderCode;
   $_SESSION['checkoutUrl'] = $smartCheckoutUrl; 
   header('Location: '. $smartCheckoutUrl);

}