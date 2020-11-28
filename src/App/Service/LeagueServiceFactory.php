<?php

declare(strict_types=1);

namespace App\Service;

use Interop\Container\ContainerInterface;
use Mezzio\Exception\InvalidArgumentException;

use App\Service\SleekDBService;

class LeagueServiceFactory
{
    public function __invoke(ContainerInterface $container): LeagueService
    {
        if (!$container->has(SleekDBService::class)) {
            throw new \Laminas\ServiceManager\Exception\ServiceNotFoundException(
                'SleekDB service not found.'
            );
        }
        $sleekDBService = $container->get(SleekDBService::class);

        return new LeagueService($sleekDBService);
    }
}
