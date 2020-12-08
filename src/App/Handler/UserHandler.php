<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\Response\EmptyResponse;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Laminas\Validator\EmailAddress;
use Laminas\Validator\StringLength;

use Mezzio\Authentication\UserInterface;

use App\Service\UserService;

class UserHandler implements RequestHandlerInterface
{
    const MIN_PASSWORD_LENGTH = 6;
    const MAX_PASSWORD_LENGTH = 64;

    private $userService;

    public function __construct(UserService $userService) {
      $this->userService = $userService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
      $method = $request->getMethod();

      if(method_exists($this, $method)) {
        return $this->$method($request);
      }
      else {
        return new JsonResponse(null);
      }
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
      $id = $request->getAttribute('id');

      $session  = $request->getAttribute('session');
      $info = $session->get(UserInterface::class);

      var_dump($info);

      if (is_null($id)) {
        $result = $this->userService->findAll();
      }
      else {
        $result = $this->userService->findOne($id);
      }

      return $result ? new JsonResponse($result) : new EmptyResponse(404);
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
      $data = $request->getParsedBody();

      if (!$data['email']) {
        return new JsonResponse(['error' => 'no email'], 404);
      }

      if (!$data['password']) {
        return new JsonResponse(['error' => 'no password'], 404);
      }

      $emailValidator = new EmailAddress();

      if (!$emailValidator->isValid($data['email'])) {
        return new JsonResponse(['error' => 'invalid email'], 404);
      }

      $passwordValidator = new StringLength(
        [
          'min'=> UserHandler::MIN_PASSWORD_LENGTH,
          'max' => UserHandler::MAX_PASSWORD_LENGTH
        ]);
      $passwordValidator->setMessage('password too short', StringLength::TOO_SHORT);
      $passwordValidator->setMessage('password too long', StringLength::TOO_LONG);

      if (!$passwordValidator->isValid($data['password'])) {
        $messages = $passwordValidator->getMessages();
        $first_key = key($messages);
        
        return new JsonResponse(['error' => $messages[$first_key]], 404);
      }

      if ($this->userService->exists($data['email'])) {
        return new JsonResponse(['error' => 'user already exists'], 404);
      }

      $user = [
        'email' => $data['email'],
        'password' => password_hash($data['password'], PASSWORD_DEFAULT)
      ];

      $result = $this->userService->create($user);

      return $result ? new JsonResponse($result) : new EmptyResponse(404);
    }

    public function put(ServerRequestInterface $request): ResponseInterface
    {
      $id = $request->getAttribute('id');
      $user = $request->getParsedBody();
      $result = $this->userService->update($id, $user);

      return $result ? new JsonResponse($result) : new EmptyResponse(404);
    }

    public function delete(ServerRequestInterface $request): ResponseInterface
    {
     
    }
}
