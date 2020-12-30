<?php

declare(strict_types=1);

namespace App\Handler\League;

use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

use App\Service\LeagueService;

class LeagueHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        if (!$container->has(LeagueService::class)) {
            throw new \Laminas\ServiceManager\Exception\ServiceNotFoundException(
                'League service not found.'
            );
        }
        $leagueService = $container->get(LeagueService::class);

        return new LeagueHandler($leagueService);
    }
}
