<?php
session_start();
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require 'home.php';
        break;
    case '/login':
        require 'login.php';
        break;
    case '/register':
        require 'register.php';
        break;
    case '/products':
        require 'products.php';
        break;
    case '/logout':
        require 'logout.php';
        break;
   case '/team.php':
        require 'team.php';
        break;
    case '/orders.php':
        require 'orders.php';
        break;
    case '/deleteOrder.php':
        require 'deleteOrder.php';
        break;
    case '/payment.php':
        require 'payment.php';
        break;
    default:
        http_response_code(404);
        exit('Not Found');
}
