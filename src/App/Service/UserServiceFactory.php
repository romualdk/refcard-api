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
        
        $config = $container->has('config') ? $container->get('config') : [];

        if (is_null($config) || !array_key_exists('avatars', $config)) {
            throw new InvalidArgumentException('Avatars configuration not able to be retrieved.') ;
        }

        $sleekDBService = $container->get(SleekDBService::class);
        $avatarDirectory = $config['avatars']['data_dir'];

        return new UserService($sleekDBService, $avatarDirectory);
    }
}
