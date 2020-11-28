<?php

declare(strict_types=1);

namespace App\Service;

use Interop\Container\ContainerInterface;
use Mezzio\Exception\InvalidArgumentException;

class SleekDBServiceFactory
{
    public function __invoke(ContainerInterface $container): SleekDBService
    {
        $config = $container->has('config') ? $container->get('config') : [];

        if (is_null($config) || !array_key_exists('sleekdb', $config)) {
            throw new InvalidArgumentException('SleekDB configuration not able to be retrieved.') ;
        }
        return new SleekDBService($config['sleekdb']['data_dir']);
    }
}
