<?php
     
    $db_name = 'mysql:host=localhost;dbname=myVivaDb';
    $user_name = 'root';
    $user_password = '';
    
    try{
        $conn = new PDO($db_name, $user_name, $user_password);
    }catch(PDOException $e){
        $error = "Database Connection Error: " . $e->getMessage();
        include('views/error.php');
        exit();
    }