<?php

declare(strict_types=1);

namespace App\Handler\User;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\EmptyResponse;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Laminas\Validator\EmailAddress;
use Laminas\Validator\StringLength;

use Mezzio\Authentication\UserInterface;

use App\Service\UserService;

class GetUserHandler implements RequestHandlerInterface
{
    private $userService;

    public function __construct(UserService $userService) {
      $this->userService = $userService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
      $id = $request->getAttribute('id');

      if (!is_null($id)) {
        $result = $this->userService->findOne($id);
      }
      else {
        $currentUser = $request->getAttribute('session')
          ->get(UserInterface::class);

        $username = $currentUser['username'];
        
        $result = $this->userService->findOneByUsername($username);
      }
      
      return $result ? new JsonResponse($result) : new EmptyResponse(404);
    }
}
