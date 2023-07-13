<?php
session_start();

$orderInfo = $_GET;
if(isset($orderInfo["eventId"]))
    $eventId = $orderInfo["eventId"];
if(isset($_SESSION["checkoutUrl"]))
    $checkoutUrl = $_SESSION["checkoutUrl"];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<h1>Transaction Failed</h1>
<div style="display:flex; align-items:center">
    <h3>Event Id: </h3><?=$eventId ?? '' ?>
</div>

<a href="<?=$checkoutUrl ?>">Retry Payment</a>