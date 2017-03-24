<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::scope('/', function (RouteBuilder $routes) {
    $routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
    $routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});

Router::plugin('Kareylo/Comments', ['path' => '/comments'], function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Ratings', 'action' => 'index'], ['routeClass' => 'DashedRoute']);
    $routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
    $routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});
