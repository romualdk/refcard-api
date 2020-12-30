<?php
namespace App\Handler\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\EmptyResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Session\SessionMiddleware;
use Mezzio\Authentication\Session\PhpSession;
use Mezzio\Session\SessionInterface;
use Mezzio\Authentication\UserInterface;
use Mezzio\Template\TemplateRendererInterface;

class LoginHandler implements RequestHandlerInterface
{
    private $adapter;

    public function __construct(PhpSession $adapter)
    {
        $this->adapter = $adapter;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);

        if ('POST' === $request->getMethod()) {
            return $this->handleLoginAttempt($request, $session);
        }

        $user = $session->get(UserInterface::class);

        if($user) {
            return new JsonResponse($user);
        }
        else {
            return new EmptyResponse(404);
        }
    }

    private function handleLoginAttempt(
        ServerRequestInterface $request,
        SessionInterface $session
    ) : ResponseInterface {
        $session->unset(UserInterface::class);

        if ($this->adapter->authenticate($request)) {
            $user = $session->get(UserInterface::class);

            return new JsonResponse($user);
        }

        return new JsonResponse(['error' => 'login failed'], 404);
    }
}