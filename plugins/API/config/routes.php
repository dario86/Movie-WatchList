<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'API',
    ['path' => '/API'],
    function (RouteBuilder $routes) {
        $routes->setExtensions(['json']);
        $routes->resources('API');
        $routes->fallbacks(DashedRoute::class);
    }
);
