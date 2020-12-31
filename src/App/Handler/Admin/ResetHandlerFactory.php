<?php

declare(strict_types=1);

namespace App\Handler\Admin;

use Mezzio\Authentication\Session\PhpSession;
use Psr\Container\ContainerInterface;

use App\Service\UserService;

class ResetHandlerFactory
{
    public function __invoke(ContainerInterface $container) : ResetHandler
    {
      $debug = false;
      $services = [];

      $config = $container->has('config') ? $container->get('config') : [];

      if (!is_null($config) && array_key_exists('debug', $config)) {
        $debug = $config['debug'];
      }

      if ($container->has(UserService::class)) {
        $services['user'] = $container->get(UserService::class);
      }

      return new ResetHandler($debug, $services);
    }
}
