<?php

declare(strict_types=1);

namespace App\Handler\User;

use Mezzio\Authentication\Session\PhpSession;
use Psr\Container\ContainerInterface;

class LoginHandlerFactory
{
    public function __invoke(ContainerInterface $container) : LoginHandler
    {
        return new LoginHandler($container->get(PhpSession::class));
    }
}
