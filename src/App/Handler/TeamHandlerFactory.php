<?php

declare(strict_types=1);

namespace App\Handler;

use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

use App\Service\SleekDBService;

class TeamHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        if (!$container->has(SleekDBService::class)) {
            throw new \Laminas\ServiceManager\Exception\ServiceNotFoundException(
                'SleekDB service not found.'
            );
        }
        $sleekDBService = $container->get(SleekDBService::class);

        return new TeamHandler($sleekDBService);
    }
}
