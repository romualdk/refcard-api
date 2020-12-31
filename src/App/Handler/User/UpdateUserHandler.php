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

use App\Handler\User\RegisterHandler;
use App\Service\UserService;

class UpdateUserHandler implements RequestHandlerInterface
{
    private $userService;

    public function __construct(UserService $userService) {
      $this->userService = $userService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
      $id = $request->getAttribute('id');
      $user = $this->userService->findOne($id);

      if(is_null($user)) {
        return new JsonResponse(['error' => 'user does not exist'], 404);
      }

      $session  = $request->getAttribute('session');
      $currentUser = $session->get(UserInterface::class);

      $isAdmin = in_array('admin', $currentUser['roles']);
      $isSelf = $user['username'] == $currentUser['username'];

      if (!($isAdmin || $isSelf)) {
        return new JsonResponse(['error' => 'not authorized'], 404);
      }

      $updateable = [];
      $data = $request->getParsedBody();

      if (array_key_exists('password', $data)) {
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

        $updateable['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
      }

      if (array_key_exists('name', $data)
        && strlen($data['name']) >= RegisterHandler::MIN_STRING_LENGTH
        && strlen($data['name']) <= RegisterHandler::MAX_STRING_LENGTH) {
        $updateable['name'] = $data['name'];
      }

      if (array_key_exists('surname', $data)
        && strlen($data['surname']) >= RegisterHandler::MIN_STRING_LENGTH
        && strlen($data['surname']) < RegisterHandler::MAX_STRING_LENGTH) {
        $updateable['surname'] = $data['surname'];
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

        $dir = 'data/avatar/';

        if (!is_null($user['avatar'])) {
          $oldFilePath = $dir . $user['avatar'];

          if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
          }
        }
        
        $newFilename = $user['id'] . '_' . $filename;
        $newFilePath = $dir . $newFilename;
        $avatar->moveTo($newFilePath);
        $updateable['avatar'] = $newFilePath;
      }
      
      $result = $this->userService->update($id, $updateable);

      return $result ? new EmptyResponse(200) : new EmptyResponse(404);
    }
}
