<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {

    $app->route('/api/register',
        [
            App\Handler\User\RegisterHandler::class
        ],
        ['POST'],
        'user.register'
    );

    $app->route('/api/login',
        [
            Mezzio\Session\SessionMiddleware::class,
            App\Handler\User\LoginHandler::class,
        ],
        ['GET', 'POST'],
        'user.login'
    );

    $app->route('/api/logout',
        [
            Mezzio\Session\SessionMiddleware::class,
            App\Handler\User\LogoutHandler::class,
        ],
        ['GET', 'POST'],
        'user.logout'
    );

    $app->route('/api/user/{id:\d+}',
        [
            Mezzio\Session\SessionMiddleware::class,
            Mezzio\Authentication\AuthenticationMiddleware::class,
            App\Handler\User\GetUserHandler::class,
        ],
        ['GET'],
        'user.get'
    );

    $app->route('/api/league',
        [
            Mezzio\Session\SessionMiddleware::class,
            Mezzio\Authentication\AuthenticationMiddleware::class,
            App\Handler\League\CreateLeagueHandler::class,
        ],
        ['POST'],
        'league.create'
    );

    $app->route('/api/league/join/{id:\d+}',
        [
            Mezzio\Session\SessionMiddleware::class,
            Mezzio\Authentication\AuthenticationMiddleware::class,
            App\Handler\League\JoinLeagueHandler::class,
        ],
        ['POST'],
        'league.join'
    );

    $app->route('/api/league/{id:\d+}',
        [
            App\Handler\League\GetLeagueHandler::class,
        ],
        ['GET'],
        'league.get'
    );

    $app->route('/api/league',
        [
            App\Handler\League\ListLeaguesHandler::class,
        ],
        ['GET'],
        'league.list'
    );
};
