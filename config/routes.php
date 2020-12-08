<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {

    $app->route(
        '/api/login',
        [
            Mezzio\Session\SessionMiddleware::class,
            App\Handler\LoginHandler::class,
        ],
        ['GET', 'POST'],
        'login'
    );

    $app->route(
        '/api/logout',
        [
            Mezzio\Session\SessionMiddleware::class,
            App\Handler\LogoutHandler::class,
        ],
        ['GET', 'POST'],
        'logout'
    );

    $app->get('/api/users[/\d+]', [
        Mezzio\Session\SessionMiddleware::class,
        Mezzio\Authentication\AuthenticationMiddleware::class,
        App\Handler\UserHandler::class,
    ], 'users');

    /*
    $app->get('/api/users', [
        Mezzio\Authentication\AuthenticationMiddleware::class,
        App\Handler\UserHandler::class
    ], 'users.get');*/


    /*$app->route('/api/users[/{id:\d+}]', App\Handler\UserHandler::class, ['POST', 'PUT', 'DELETE'], 'users');*/
    $app->route('/api/leagues[/{id:\d+}]', App\Handler\LeagueHandler::class, ['GET', 'POST', 'PUT', 'DELETE'], 'leagues');
    $app->route('/api/teams[/{id:\d+}]', App\Handler\TeamHandler::class, ['GET', 'POST', 'PUT', 'DELETE'], 'teams');
};
