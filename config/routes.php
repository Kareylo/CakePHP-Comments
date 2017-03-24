<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin('Kareylo/Comments', ['path' => '/comments'], function (RouteBuilder $routes) {
    $routes->connect('/', ['action' => 'index', 'controller' => 'Comments']);
    $routes->fallbacks(DashedRoute::class);
});
