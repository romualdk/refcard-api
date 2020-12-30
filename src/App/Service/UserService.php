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
      return new DefaultUser($credential, $this->getRoles($credential));
    }

    return null;
  }

  public function getPasswordHash($username) {
    $user = $this->store
      ->where('username', '=', $username)
      ->fetch();

      if (!$user) {
        return null;
      }

      return $user[0]['password'];
  }

  public function getRoles($username) {
    $user = $this->store
    ->where('username', '=', $username)
    ->fetch();

    if (!$user) {
      return [];
    }

    if (!array_key_exists('roles', $user[0])) {
      return [];
    }

    return $user[0]['roles'];
  }

  public function exists($username) {
    $user = $this->store
      ->where('username', '=', $username)
      ->fetch();

      if (!$user) {
        return false;
      }

      return count($user) > 0;
  }

  public function findOne($id) {
    $user = $this->store
      ->where('_id', '=', $id)
      ->fetch();

    if (!$user) {
      return null;
    }

    $user = $this->clear($user[0]);

    return $user;
  }

  public function findOneByUsername($username) {
    $user = $this->store
      ->where('username', '=', $username)
      ->fetch();

    if (!$user) {
      return null;
    }

    $user = $this->clear($user[0]);

    return $user;
  }

  public function findAll() {
    $users = $this->store
      ->fetch();
    
    foreach($users as &$user) {
      $user = $this->clear($user);
    }

    return $users;
  }

  public function create($user) {
    $user = $this->store->insert($user);
    
    if(!$user) {
      return null;
    }

    $user = $this->clear($user);

    return $user;
  }

  public function update($id, $user) {
    return $user = $this->store
      ->where('_id', '=', $id)
      ->update($user);
  }

  public function delete($id) {
    return $this->store->where('_id', '=', $id)->delete();
  }

  protected function clear($user) {
    $user['id'] = (string)$user['_id'];
    unset($user['_id']);
    unset($user['password']);

    return $user;
  }
}
