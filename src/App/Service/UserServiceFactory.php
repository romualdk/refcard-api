<?php

declare(strict_types=1);

namespace App\Service;

use Interop\Container\ContainerInterface;
use Mezzio\Exception\InvalidArgumentException;

use App\Service\SleekDBService;

class UserServiceFactory
{
    public function __invoke(ContainerInterface $container): UserService
    {
        if (!$container->has(SleekDBService::class)) {
            throw new \Laminas\ServiceManager\Exception\ServiceNotFoundException(
                'SleekDB service not found.'
            );
        }
        $sleekDBService = $container->get(SleekDBService::class);

        return new UserService($sleekDBService);
    }
}
