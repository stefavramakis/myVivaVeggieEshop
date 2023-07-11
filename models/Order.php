<?php
require __DIR__ . '\Database.php';

class Order{
    public $id;
    public $order_code;
    public $transaction_id;
    public $products;
    public $state_id;
    public $discount;
    public $amount;
    public $customer_name;
    public $customer_email;

    const ORDER_STATUS_PENDING = 0;
    const ORDER_STATUS_EXPIRED = 1;
    const ORDER_STATUS_CANCELED = 2;
    const ORDER_STATUS_PAID = 3;


    const Pending = 'Pending';

    public function __construct(){
        global $conn;
    }

    public function create(){
        global $conn;
        $insert_order = $conn->prepare("INSERT INTO `orders` (order_code,products, state_id, discount,amount,customer_name,customer_email) VALUES(?,?,?,?,?,?,?)");
        $insert_order->execute([$this->order_code,$this->products,$this::ORDER_STATUS_PENDING, $this->discount, $this->amount,$this->customer_name,$this->customer_email]);
    }

    public function update(){
        global $conn;
        $insert_order = $conn->prepare("UPDATE `orders` SET (order_code, transaction_id) VALUES(?,?)");
        $insert_order->execute([$this->order_code, $this->transaction_id]);
    }

    static function getOrderId($order_code){
        global $conn;
        $order = $conn->prepare("SELECT * FROM orders WHERE order_code=:order_code"); 
        $order->execute(['order_code' => $order_code]);
        $order = $order->fetch();
        return $order['id'];
    }

    static function finalizeOrderPayment($orderCode, $stateId, $transactionId){
        global $conn;
        $statement = $conn->prepare("UPDATE orders SET state_id=:stateId, transaction_id=:transaction_id WHERE order_code=:orderCode");
        $statement->execute(['stateId' => $stateId ,'transaction_id' => $transactionId,'orderCode' => $orderCode]);
    }

    static function cancelOrder($orderId){
        global $conn;
        $statement = $conn->prepare("UPDATE orders SET state_id=:stateId WHERE id=:orderId");
        $statement->execute(['stateId' => self::ORDER_STATUS_CANCELED ,'orderId' => $orderId]);
    }

    static function getPlacedOrders(){
        global $conn;
        $orders = $conn->prepare("SELECT * FROM orders"); 
        $orders->execute();
        $orders = $orders->fetchAll();
        return $orders;
    }

    static function getOrderStatusPrettyName($stateId){
        switch ($stateId) {
            case 0:
                return 'Pending';
                break;
            case 1:
                return 'Expired';
                break;
            case 2:
                return 'Canceled';
                break;
            case 3:
                return 'Paid';
                break;
        }
    }
}