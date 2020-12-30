<?php

declare(strict_types=1);

namespace App\Handler\League;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use App\Service\LeagueService;
use App\Service\UserService;

class CreateLeagueHandler implements RequestHandlerInterface
{
    private $leagueService;
    private $userService;

    public function __construct(LeagueService $leagueService, UserService $userService) {
      $this->leagueService = $leagueService;
      $this->userService = $userService;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $id = $request->getAttribute('id');
        $league = $this->leagueService->findOne($id);

        if(is_null($league)) {
            return new JsonResponse(['error' => 'league does not exist'], 404);
        }

        $session  = $request->getAttribute('session');
        $currentUser = $session->get(UserInterface::class);

        $isAdmin = in_array('admin', $currentUser['roles']);
        $isSelf = $user['email'] == $currentUser['username'];
    }
}
