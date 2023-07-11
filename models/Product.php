<?php
require __DIR__ . '\Database.php';

class Product{
    public $id;
    public $name;
    public $price;
    public $db;

    public function __construct(){
        global $conn;
    }

    static public function initDemoProducts(){
        global $conn;
        $response = file_get_contents('https://demo0336234.mockable.io/products');
        $products = json_decode($response, true);
        $products = $products['products'];
        
        foreach($products as $product){
            $insert_products = $conn->prepare("INSERT INTO `products` (product_id, name, price) VALUES(?,?,?)");
            $insert_products->execute([$product['id'],$product['name'], $product['price']]);
        }
    }

    static public function getAllProducts(){
        global $conn;
        $products = $conn->prepare("SELECT * FROM `products`"); 
        $products->execute();
        $products = $products->fetchAll();
        return $products;
    }

    static function getProduct($id){
        global $conn;
        $product = $conn->prepare("SELECT * FROM products WHERE id=:id"); 
        $product->execute(['id' => $id]);
        $product = $product->fetch();
        return $product;
    }
}