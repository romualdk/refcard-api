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
        ['POST'],
        'user.login'
    );

    $app->route('/api/logout',
        [
            Mezzio\Session\SessionMiddleware::class,
            App\Handler\User\LogoutHandler::class,
        ],
        ['POST'],
        'user.logout'
    );

    $app->route('/api/user[/{id:\d+}]',
        [
            Mezzio\Session\SessionMiddleware::class,
            Mezzio\Authentication\AuthenticationMiddleware::class,
            App\Handler\User\GetUserHandler::class,
        ],
        ['GET'],
        'user.get'
    );

    $app->route('/api/user/{id:\d+}',
        [
            Mezzio\Session\SessionMiddleware::class,
            Mezzio\Authentication\AuthenticationMiddleware::class,
            App\Handler\User\UpdateUserHandler::class,
        ],
        ['POST'],
        'user.update'
    );
};
