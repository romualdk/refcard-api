<?php
// TO DO
declare(strict_types=1);

namespace App\Entity;

class UserEntity {
  private $id;
  private $username;
  private $password;
  private $name;
  private $surname;
  private $avatar;

  public function __construct($data) {
    $this->fromArray($data);
  }

  public function fromArray($data) {

  }

  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }

  public function __set($property, $value) {
    if (property_exists($this, $property)) {
      $this->$property = $value;
    }

    return $this;
  }
}