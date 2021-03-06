<?php

use Illuminate\Http\Request;

$router->group(array(
    'prefix' => config('graphql.prefix'),
    'middleware' => config('graphql.middleware', [])
), function ($router) {
    
    //Get routes from config
    $routes = config('graphql.routes');
    $queryRoute = null;
    $mutationRoute = null;
    if (is_array($routes)) {
        $queryRoute = array_get($routes, 'query', null);
        $mutationRoute = array_get($routes, 'mutation', null);
    } else {
        $queryRoute = $routes;
        $mutationRoute = $routes;
    }
    
    //Get controllers from config
    $controllers = config('graphql.controllers', '\Folklore\GraphQL\GraphQLController@query');
    $queryController = null;
    $mutationController = null;
    if (is_array($controllers)) {
        $queryController = array_get($controllers, 'query', null);
        $mutationController = array_get($controllers, 'mutation', null);
    } else {
        $queryController = $controllers;
        $mutationController = $controllers;
    }
    
    //Query
    if ($queryRoute) {
        $router->get($queryRoute, array(
            'as' => 'graphql.query',
            'uses' => $queryController
        ));
    }
    
    //Mutation
    if ($mutationRoute) {
        $router->post($mutationRoute, array(
            'as' => 'graphql.mutation',
            'uses' => $mutationController
        ));
    }
});
