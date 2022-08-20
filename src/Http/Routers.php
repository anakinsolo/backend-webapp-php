<?php

namespace Tuan\Fixably\Http;

use Bramus\Router\Router;

$router = new Router();

$router->get('/', function() {
    echo 'Main Page';
});

//@TODO: Remove
$router->get('/login', function() {
    echo 'Get API token';
});


$router->get('/statistics', '\Tuan\Fixably\Controller\Order\Statistics@execute');

$router->get('/iphones', function() {
    echo 'Order Iphone Page';
});

$router->get('/invoices', function() {
    echo 'Invoices Page';
});

$router->get('/new', function() {
    echo 'New Order Page';
});

$router->post('/save', function() {
    echo 'New Order Save';
});
 
$router->run();