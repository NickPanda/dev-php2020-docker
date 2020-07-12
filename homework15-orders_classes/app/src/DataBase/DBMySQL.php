<?php

declare(strict_types=1);

namespace App\DataBase;

use App\Interfaces\DB;
use \PDO;

/**
 * Class DBMySQL
 * @package App\DataBase
 */
class DBMySQL implements DB
{
    private $DB;

    /**
     * @return $this|DB
     */
    public function connect(): DB
    {
        if ($this->DB) {
            return $this->DB;
        }

        $username = getenv("MYSQL_USER");
        $password = getenv("MYSQL_PASSWORD");
        $host = getenv("MYSQL_HOST");
        $db = getenv("MYSQL_DB");

        try {
            $this->DB = new PDO(
                "mysql:dbname=$db;host=$host",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (\PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage());
        }

        return $this;
    }

    /**
     * @param string $table
     * @param array $rows
     * @return int
     */
    public function insert(string $table, array $rows): int
    {
        $sql_params = [];
        foreach ($rows as $key => $attr) {
            $sql_params[":$key"] = $attr;
        }
        $sql_rows = implode(',', array_keys($rows));
        $sql_params_name = implode(',', array_keys($sql_params));

        $query = $this->DB->prepare("INSERT INTO $table ($sql_rows) VALUES ($sql_params_name)");
        if (!$query->execute($sql_params)) {
            return 0;
        }

        return (int)$this->DB->lastInsertId();
    }

    /**
     * @param string $table
     * @param array $filter
     * @param array $rows
     * @return bool
     */
    public function update(string $table, array $filter, array $rows): bool
    {
        $sql_params = [];
        $sql_rows = [];
        foreach ($rows as $key => $attr) {
            $sql_params[":" . $key] = $attr;
            if ($key != 'id') {
                $sql_rows[] = $key . " = :" . $key;
            }
        }
        $sql_rows = implode(', ', $sql_rows);

        $filter = $this->parseAttributesForWhere($filter);
        $sql_params = array_merge($sql_params, $filter['rows']);

        $query = $this->DB->prepare("UPDATE $table SET $sql_rows " . $filter['where']);

        return $query->execute($sql_params);
    }

    /**
     * @param string $table
     * @param array $rows
     * @return object|null
     */
    public function findAll(string $table, array $rows): ?object
    {
        $where = $this->parseAttributesForSelect($rows);
        $query = $this->DB->prepare("SELECT * FROM $table" . $where['where']);
        $query->execute($where['rows']);

        return $query->fetchAll();
    }

    /**
     * @param $table
     * @param $rows
     * @return object|null
     */
    public function findOne(string $table, array $rows)
    {
        $where = $this->parseAttributesForSelect($rows);
        $query = $this->DB->prepare("SELECT * FROM $table" . $where['where']);
        $query->execute($where['rows']);

        return $query->fetch();
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function parseAttributesForSelect(array $attributes): array
    {
        $where = '';
        $sql_params = [];
        $sql_rows = [];
        foreach ($attributes as $key => $attr) {
            $sql_rows[':' . $key] = $attr;
            $sql_params[] = $key . " = :" . $key;
        }
        $sql_params = implode(' ', $sql_params);

        if (!empty($attributes)) {
            $where = ' WHERE ' . $sql_params;
        }

        return ['where' => $where, 'rows' => $sql_rows];
    }

    /**
     * @param array $attributes
     * @return array
     */
    public function parseAttributesForWhere(array $attributes): array
    {
        $where = '';
        $sql_params = [];
        $sql_rows = [];
        foreach ($attributes as $key => $attr) {
            $sql_rows[':where_' . $key] = $attr;
            $sql_params[] = $key . " = :where_" . $key;
        }
        $sql_params = implode(" AND ", $sql_params);

        if (!empty($attributes)) {
            $where = ' WHERE ' . $sql_params;
        }

        return ['where' => $where, 'rows' => $sql_rows];
    }
}
