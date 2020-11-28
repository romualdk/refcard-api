<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;


return static function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $basePath = '/mezzio/public';

    $app->route($basePath . '/api/leagues[/{id:\d+}]', App\Handler\LeagueHandler::class, ['GET', 'POST', 'PUT', 'DELETE'], 'leagues');
    $app->route($basePath . '/api/teams[/{id:\d+}]', App\Handler\TeamHandler::class, ['GET', 'POST', 'PUT', 'DELETE'], 'teams');
};
