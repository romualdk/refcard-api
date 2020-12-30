<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Container\ContainerInterface;

use App\Service\LeagueService;
use App\Service\UserService;

class CreateLeagueHandlerFactory
{
    public function __invoke(ContainerInterface $container) : CreateLeagueHandler
    {
        if (!$container->has(LeagueService::class)) {
            throw new \Laminas\ServiceManager\Exception\ServiceNotFoundException(
                'League service not found.'
            );
        }

        if (!$container->has(UserService::class)) {
            throw new \Laminas\ServiceManager\Exception\ServiceNotFoundException(
                'User service not found.'
            );
        }
        
        $leagueService = $container->get(LeagueService::class);
        $userService = $container->get(UserService::class);

        return new CreateLeagueHandler($leagueService, $userService);
    }
}
