<?php
namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\EmptyResponse;

use Mezzio\Session\SessionMiddleware;
use Mezzio\Authentication\UserInterface;

class LogoutHandler implements RequestHandlerInterface
{
  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);

    if ($session->has(UserInterface::class)) {
        $session->clear();
        
        return new EmptyResponse(200);
    }

    return new EmptyResponse(404);
  }
}
