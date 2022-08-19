<?php

namespace Tuan\Fixably\Http;

use Bramus\Router\Router;

$router = new Router();

$router->get('/', function() {
    echo 'Main Page';
});

$router->get('/orders/statistics', function() {
    echo 'Order Page';
});

$router->get('/orders/iphone', function() {
    echo 'Order Iphone Page';
});

$router->get('/invoices', function() {
    echo 'Invoices Page';
});

$router->post('/orders/create', function() {
    echo 'New order';
});
 
$router->run();