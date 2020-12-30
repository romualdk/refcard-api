<?php

declare(strict_types=1);

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'authentication' => [
                'redirect' => '/login',
            ],
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                
            ],
            'factories'  => [
                UserInterface::class => DefaultUserFactory::class,
                
                Service\SleekDBService::class => Service\SleekDBServiceFactory::class,
                Service\UserService::class => Service\UserServiceFactory::class,
                Service\LeagueService::class => Service\LeagueServiceFactory::class,

                Handler\User\RegisterHandler::class => Handler\User\RegisterHandlerFactory::class,
                Handler\User\LoginHandler::class => Handler\User\LoginHandlerFactory::class,
                Handler\User\LogoutHandler::class => Handler\User\LogoutHandlerFactory::class,
                Handler\User\UserHandler::class => Handler\User\UserHandlerFactory::class,

                Handler\League\JoinLeagueHandler::class => Handler\League\JoinLeagueHandlerFactory::class,
                Handler\League\LeagueHandler::class => Handler\League\LeagueHandlerFactory::class,

                Handler\Team\TeamHandler::class => Handler\Team\TeamHandlerFactory::class
            ]
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => ['templates/app'],
                'error'  => ['templates/error'],
                'layout' => ['templates/layout'],
            ],
        ];
    }
}
