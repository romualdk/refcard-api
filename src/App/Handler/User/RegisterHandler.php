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

class RegisterHandler implements RequestHandlerInterface
{
    const MIN_PASSWORD_LENGTH = 6;
    const MAX_PASSWORD_LENGTH = 64;

    const MIN_STRING_LENGTH = 1;
    const MAX_STRING_LENGTH = 64;

    const MAX_IMAGE_SIZE = 1*1024*1024;

    private $userService;

    public function __construct(UserService $userService) {
      $this->userService = $userService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
      $data = $request->getParsedBody();

      if (!array_key_exists('username', $data)) {
        return new JsonResponse(['error' => 'no username'], 404);
      }

      if (!array_key_exists('password', $data)) {
        return new JsonResponse(['error' => 'no password'], 404);
      }

      $emailValidator = new EmailAddress();

      if (!$emailValidator->isValid($data['username'])) {
        return new JsonResponse(['error' => 'username must be email'], 404);
      }

      $passwordValidator = new StringLength(
        [
          'min'=> RegisterHandler::MIN_PASSWORD_LENGTH,
          'max' => RegisterHandler::MAX_PASSWORD_LENGTH
        ]);
      $passwordValidator->setMessage('password too short', StringLength::TOO_SHORT);
      $passwordValidator->setMessage('password too long', StringLength::TOO_LONG);

      if (!$passwordValidator->isValid($data['password'])) {
        $messages = $passwordValidator->getMessages();
        $first_key = key($messages);
        
        return new JsonResponse(['error' => $messages[$first_key]], 404);
      }

      if ($this->userService->exists($data['username'])) {
        return new JsonResponse(['error' => 'user already exists'], 404);
      }

      $user = [
        'username' => $data['username'],
        'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        'name' => null,
        'surname' => null,
        'avatar' => null
      ];

      if (array_key_exists('name', $data)
        && strlen($data['name']) >= RegisterHandler::MIN_STRING_LENGTH
        && strlen($data['name']) <= RegisterHandler::MAX_STRING_LENGTH) {
        $user['name'] = $data['name'];
      }

      if (array_key_exists('surname', $data)
        && strlen($data['surname']) >= RegisterHandler::MIN_STRING_LENGTH
        && strlen($data['surname']) <= RegisterHandler::MAX_STRING_LENGTH) {
        $user['surname'] = $data['surname'];
      }

      $files = $request->getUploadedFiles();

      if (array_key_exists('avatar', $files)) {
        $avatar = $files['avatar'];

        $validMediaTypes = array(
          'image/png' => 'png',
          'image/gif' => 'gif',
          'image/jpeg' => 'jpg'
        );

        $mediaType = $avatar->getClientMediaType();

        if (!array_key_exists($mediaType, $validMediaTypes)) {
          return new JsonResponse(['error' => 'invalid avatar media type'], 404);
        }

        $size = $avatar->getSize();

        if ($size > RegisterHandler::MAX_IMAGE_SIZE) {
          return new JsonResponse(['error' => 'avatar exceeds max size'], 404);
        }

        $filename = preg_replace('/[^a-zA-Z0-9]+/', '', $user['username']);
        $filename .= '.' . $validMediaTypes[$mediaType];

        $result = $this->userService->create($user);

        $id = $result['id'];
        $filename = $id . '_' . $filename;

        $this->userService->update($id, ['avatar' => $filename]);
        $result['avatar'] = $filename;

        $targetPath = 'data/avatar/' . $filename;
        $avatar->moveTo($targetPath);
       
      }
      else {
        $result = $this->userService->create($user);
      }

      return $result ? new JsonResponse($result) : new EmptyResponse(404);
    }
}
