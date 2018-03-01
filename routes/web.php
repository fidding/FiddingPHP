<?php

$app['router']->get('/', function () {
    return '路由成功';
});

$app['router']->get('/test', function () {
    return 'test';
});

$app['router']->get('/welcome', 'App\Controllers\WelcomeController@index');