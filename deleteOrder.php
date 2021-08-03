<?php 
session_start();
require 'vendor/autoload.php';
date_default_timezone_set('UTC');

    $url = "https://h6dj8ltf6l.execute-api.us-east-1.amazonaws.com/delete/deleteorder";    
    $data = json_encode([
        "user_email" => $_SESSION['useremail'],
        "product_id" => $_GET['id']
    ]);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_exec($curl);
    curl_close($curl);
    header('Location: /orders.php');
    exit();
?>