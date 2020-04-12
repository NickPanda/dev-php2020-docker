<?php

namespace App;

class Movie {

    /**
     * @var string
     */
    private static $selectQuery = 'select * from movies';

    /**
     * @var string
     */
    private static $insertQuery = 'insert into movies (name, duration, age_rating) values (?, ?, ?)';

    /**
     * @var string
     */
    private static $updateQuery = 'update movies set {fields} where id = ?';

    /**
     * @var string
     */
    private static $deleteQuery = 'delete from movies where id = ?';

    /**
     * @param \PDO $pdo
     * @param int $id
     * @param string $field
     *
     * @return array
     */
    public static function getById(\PDO $pdo, int $id, $fields = '*'): array
    {
        if ($fields !== '*') {
            self::$selectQuery = str_replace('*', $fields, self::$selectQuery);
        }
        self::$selectQuery .= ' where id = ?';
        $selectStmt = $pdo->prepare(self::$selectQuery);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute([$id]);
        $result = $selectStmt->fetch();
        return !empty($result) ? $result : [];
    }

    /**
     * @param \PDO $pdo
     * @param int $id
     * @param string $fields
     *
     * @return array
     */
    public static function getAll(\PDO $pdo, $fields = '*'): array
    {
        if ($fields !== '*') {
            self::$selectQuery = str_replace('*', $fields, self::$selectQuery);
        }
        $selectStmt = $pdo->prepare(self::$selectQuery);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute();
        $result = $selectStmt->fetchAll();
        return !empty($result) ? $result : [];
    }

    /**
     * @param \PDO $pdo
     * @param array $fields
     * 
     * @return bool
     */
    public static function insert(\PDO $pdo, $fields): bool
    {     
        $insertStmt = $pdo->prepare(self::$insertQuery);
        return $insertStmt->execute($fields);
    }

    /**
     * @param array $fields
     */
    private static function getPrepareUpdateQueryById($fields) {
        $prepare_fileds = implode(', ',
            array_map(
                function($field) {
                    return $field . ' = ?';
                },
                array_keys($fields)
            ));

        self::$updateQuery = str_replace(
            '{fields}', 
            $prepare_fileds, 
            self::$updateQuery);
    }

    /**
     * @param \PDO $pdo
     * @param array $fields
     * @param int $id
     * 
     * @return bool
     */
    public static function updateById(\PDO $pdo, $fields, $id): bool
    {
        $updateQuery = self::getPrepareUpdateQueryById($fields);
        $updateStmt = $pdo->prepare(self::$updateQuery);

        return $updateStmt->execute(array_merge(array_values($fields), [$id]));
    }

    /**
     * @param \PDO $pdo
     * @param int $id
     * 
     * @return bool
     */
    public static function deleteById(\PDO $pdo, $id): bool
    {
        $deleteStmt = $pdo->prepare(self::$deleteQuery);
        return $deleteStmt->execute([$id]);
    }
}
