<?php

declare(strict_types=1);

namespace App\Handler\User;

use Mezzio\Router\RouterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

use App\Service\UserService;

class RegisterHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        if (!$container->has(UserService::class)) {
            throw new \Laminas\ServiceManager\Exception\ServiceNotFoundException(
                'User service not found.'
            );
        }

        $config = $container->has('config') ? $container->get('config') : [];

        if (is_null($config) || !array_key_exists('avatars', $config)) {
            throw new InvalidArgumentException('Avatars configuration not able to be retrieved.') ;
        }

        $userService = $container->get(UserService::class);
        $avatarDirectory = $config['avatars']['data_dir'];

        return new RegisterHandler($userService, $avatarDirectory);
    }
}
