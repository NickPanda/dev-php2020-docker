<?php

namespace App\Database;

interface DatabaseInterface
{
    /**
     * @param string $key
     * @param array $data
     * 
     * @return mixed
     */
    public function save(string $key, array $data);

    /**
     * @param array $params
     * 
     * @return mixed
     */
    public function find(array $params);

    /**
     * @return mixed
     */
    public function deleteAll();
}
