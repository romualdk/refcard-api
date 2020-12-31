<?php

declare(strict_types=1);

namespace App\Service;
use App\Service\SleekDBService;

use Mezzio\Authentication\UserRepositoryInterface;
use Mezzio\Authentication\UserInterface;
use Mezzio\Authentication\DefaultUser;

class UserService implements UserRepositoryInterface
{

  private $sleekDB;
  private $store;
  private $avatarDirectory;

  public function __construct(SleekDBService $sleekDB, $avatarDirectory) {
    $this->sleekDB = $sleekDB;
    $this->getStore();
    $this->avatarDirectory = $avatarDirectory;
  }

  protected function getStore() {
    $this->store = $this->sleekDB->getStore('users');
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

  public function resetService() {
    // Reset store
    $this->store->deleteStore();
    $this->getStore();

    // Create admin user
    $username = 'admin';
    $password = $this->randomPassword();

    $admin = [
      'username' => $username,
      'password' => password_hash($password, PASSWORD_DEFAULT),
      'name' => null,
      'surname' => null,
      'avatar' => null,
      'roles' => ['admin']
    ];

    $this->create($admin);

    // Reset avatars
    $dir = $this->avatarDirectory;

    if (is_dir($dir)) {
      $files = array_diff(scandir($dir), array('.','..'));

      foreach ($files as $file) {
        unlink($dir . '/' . $file);
      }
    }
    else {
      mkdir($dir);
    }

    return [
      'result' => true,
      'admin' => [
        'username' => $username,
        'password' => $password
      ]
    ];
  }

  protected function randomPassword($length = 10) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';

      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;

  }
}
