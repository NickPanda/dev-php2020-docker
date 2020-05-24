<?php

namespace App\Config;

use MongoDB\Client;
use MongoDB\Collection;

/**
 * Class MongoDB
 * @package App\Config
 */
class MongoDB
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $database;

    /**
     * @var string
     */
    private $collectionName;

    public function __construct()
    {
        $dsn = 'mongodb://'
            .getenv('MONGO_USERNAME').':'
            .getenv('MONGO_PASSWORD').'@'
            .getenv('MONGO_HOST').':'
            .getenv('MONGO_PORT').'/';
        $this->client = new Client($dsn);
        $this->database = getenv('MONGO_DATABASE');
    }

    /**
     * @param string $collectionName
     * 
     * @return void
     */
    public function setCollectionName(string $collectionName): void
    {
        $this->collectionName = $collectionName;
    }

    /**
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->client->selectCollection($this->database, $this->collectionName);
    }
}
