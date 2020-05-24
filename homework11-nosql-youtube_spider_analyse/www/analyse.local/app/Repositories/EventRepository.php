<?php

namespace App\Repositories;

use App\Database\DatabaseInterface;

/**
 * Class EventRepository
 * @package App\Repositories
 */
class EventRepository
{
    /**
     * @var DatabaseInterface $database
     */
    private $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    /**
     * @param string $key
     * @param array $data
     * 
     * @return mixed
     */
    public function save(string $key, array $data)
    {
        return $this->database->save($key, $data);
    }

    /**
     * @param array $params
     * 
     * @return mixed
     */
    public function find(array $params)
    {
        return $this->database->find($params);
    }


    /**
     * @return string
     */
    public function deleteAll(): string
    {
        return $this->database->deleteAll();
    }
}
