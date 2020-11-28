<?php

declare(strict_types=1);

namespace App\Service;

use \SleekDB\SleekDB;

class SleekDBService
{
    private string $dataDir;

    public function __construct(string $dataDir)
    {
        $this->dataDir = $dataDir;
    }

    public function getStore(string $storeName) {
      return \SleekDB\SleekDB::store($storeName, $this->dataDir);
    }
}
