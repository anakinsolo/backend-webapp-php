<?php

namespace Tuan\Fixably\Http;

use Bramus\Router\Router;

$router = new Router();

$router->get('/', '\Tuan\Fixably\Controller\Index@execute');


$router->get('/statistics', '\Tuan\Fixably\Controller\Order\Statistics@execute');

$router->get('/iphones', '\Tuan\Fixably\Controller\Order\Iphone@execute');

$router->get('/invoices', '\Tuan\Fixably\Controller\Invoice@execute');

$router->get('/new', '\Tuan\Fixably\Controller\Order\Edit@execute');

$router->post('/save', '\Tuan\Fixably\Controller\Order\Save@execute');
 
$router->run();