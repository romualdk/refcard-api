<?php

declare(strict_types=1);

namespace App\Service;
use App\Service\SleekDBService;

use Mezzio\Authentication\UserRepositoryInterface;
use Mezzio\Authentication\UserInterface;
use Mezzio\Authentication\DefaultUser;

class UserService implements UserRepositoryInterface
{
  private $store;

  public function __construct(SleekDBService $sleekDB) {
    $this->store = $sleekDB->getStore('users');
  }

  public function authenticate(string $credential, ?string $password = null): ?UserInterface
  {
    $passwordHash = $this->getPasswordHash($credential);

    if (!$passwordHash) {
      return null;
    }

    if (password_verify($password ?? '', $passwordHash)) {
      return new DefaultUser($credential);
    }

    return null;
  }

  public function getPasswordHash($email) {
    $user = $this->store
      ->where('email', '=', $email)
      ->fetch();

      if (!$user) {
        return null;
      }

      return $user[0]['password'];
  }

  public function exists($email) {
    $user = $this->store
      ->where('email', '=', $email)
      ->fetch();

      if (!$user) {
        return false;
      }

      return count($user) > 0;
  }

  public function findOne($id) {
    
  }

  public function findAll() {
    $users = $this->store
      ->fetch();
    
    foreach($users as &$user) {
      $user['id'] = (string)$user['_id'];
      unset($user['_id']);
    }

    return $users;
  }

  public function create($user) {
    $user = $this->store->insert($user);
    
    if(!$user) {
      return null;
    }

    $user['id'] = (string)$user['_id'];
    unset($user['_id']);

    return $user;
  }

  public function update($id, $user) {
    
  }

  public function delete($id) {
    
  }
}
