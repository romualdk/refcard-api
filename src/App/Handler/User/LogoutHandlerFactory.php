<?php

declare(strict_types=1);

namespace App\Handler\User;

use Mezzio\Authentication\Session\PhpSession;
use Psr\Container\ContainerInterface;

class LogoutHandlerFactory
{
    public function __invoke(ContainerInterface $container) : LogoutHandler
    {
        return new LogoutHandler();
    }
}
