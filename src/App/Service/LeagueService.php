<?php

declare(strict_types=1);

namespace App\Service;
use App\Service\SleekDBService;

class LeagueService
{
  private $store;

  public function __construct(SleekDBService $sleekDB) {
    $this->store = $sleekDB->getStore('leagues');
  }

  public function findOne($id) {
    $league = $this->store
      ->where('_id', '=', $id)
      ->fetch();

    if (!$league) {
      return null;
    }

    $league[0]['id'] = (string)$league[0]['_id'];
    unset($league[0]['_id']);

    return $league[0];
  }

  public function findAll() {
    $leagues = $this->store
      ->fetch();
    
    foreach($leagues as &$league) {
      $league['id'] = (string)$league['_id'];
      unset($league['_id']);
    }

    return $leagues;
  }

  public function create($league) {
    $league = $this->store->insert($league);
    
    if(!$league) {
      return null;
    }

    $league['id'] = (string)$league['_id'];
    unset($league['_id']);

    return $league;
  }

  public function update($id, $league) {
    unset($league['id']);
    $league = $this->store->where('_id', '=', $id)->update($league);

    if(!$league) {
      return null;
    }

    $league['id'] = (string)$league['_id'];
    unset($league['_id']);

    return $league;
  }

  public function delete($id) {
    $league = $this->store->where('_id', '=', $id)->delete();

    if(!$league) {
      return false;
    }

    $league['id'] = (string)$league['_id'];
    unset($league['_id']);

    return $league;
  }
}
