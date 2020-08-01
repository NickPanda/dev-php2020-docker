<?php

namespace App\Database;

use Predis\Client;

class RedisDB implements DatabaseInterface
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'host' => getenv('REDIS_HOST'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function save(string $key, array $data): object
    {
        return $this->client->hmset($key, $data);
    }

    /**
     * @inheritDoc
     */
    public function find(array $params)
    {
        $names = $this->client->keys('events:*');

        $foundEvents = [];

        foreach ($names as $name) {
            
            $data = $this->client->hgetall($name);
            reset($data);

            $data = json_decode($data[0], true, 512, JSON_THROW_ON_ERROR);

            $matchedConditions = [];

            foreach ($data['conditions'] as $keyCondition => $condition) {
                foreach ($params as $param) {
                    if ($condition === $param) {
                        $matchedConditions[$keyCondition] = $condition;
                    }

                }
            }
            if ($matchedConditions === $params) {
                $foundEvents[] = $data;
            }
        }

        if (empty($foundEvents)) {
            return [];
        }

        $priority = 0;
        $foundEvents = array_filter($foundEvents, function ($el) use (&$priority) {
            if ($el['priority'] > $priority) {
                $priority = $el['priority'];
                return true;
            }
            return false;
        });

        return end($foundEvents);
    }

    /**
     * @inheritDoc
     */
    public function deleteAll()
    {
        return $this->client->flushall();
    }
}
