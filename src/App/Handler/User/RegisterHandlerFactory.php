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
        $userService = $container->get(UserService::class);

        return new RegisterHandler($userService);
    }
}
