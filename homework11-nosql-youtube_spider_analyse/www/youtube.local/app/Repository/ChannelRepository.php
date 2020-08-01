<?php

namespace App\Repository;

use App\Config\MongoDB;
use MongoDB\Collection;

class ChannelRepository
{
    /**
     * @var Collection
     */
    private $collection;

    public function __construct()
    {
        $database = new MongoDB();
        $database->setCollectionName('channels');
        $this->collection = $database->getCollection();
    }

    /**
     * Вставка массива данных.
     * 
     * @param array $channels
     * 
     * @return ChannelRepository
     */
    public function insertMany(array $channels): ChannelRepository
    {
        $this->collection->insertMany($channels);

        return $this;
    }

    /**
     * Удаление всех записей.
     * 
     * @return ChannelRepository
     */
    public function deleteAll(): ChannelRepository
    {
        $this->collection->deleteMany([]);

        return $this;
    }

    /**
     * Суммарные данные по лайкам/дизалайкам.
     * массив с агрегированными данными
     * 
     * @return array
     */
    public function getStatisticsSum(): array
    {
        $data = $this->collection->aggregate([
            [
                '$unwind' => '$videos'
            ],
            [
                '$group' => [
                    '_id' => '$_id',
                    'title' => [
                        '$first' => '$title'
                    ],
                    'likes' => [
                        '$sum' => '$videos.likes'
                    ],
                    'dislikes' => [
                        '$sum' => '$videos.dislikes'
                    ],
                ]
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'title' => 1,
                    'likes' => 1,
                    'dislikes' => 1,
                ]
            ],
            [
                '$sort' => [
                    'likes' => -1
                ]
            ]
        ]);

        return $data->toArray();
    }

    /**
     * ТОП каналов (лайкам/дизалайкам).
     * массив с агрегированными данными.
     * 
     * @param int $limit
     * 
     * @return array
     */
    public function getTopChannels(int $limit): array
    {

        $data = $this->collection->aggregate([
            [
                '$unwind' => '$videos'
            ],
            [
                '$group' => [
                    '_id' => '$_id',
                    'channelId' => [
                        '$first' => '$channelId'
                    ],
                    'title' => [
                        '$first' => '$title'
                    ],
                    'likes' => [
                        '$sum' => '$videos.likes'
                    ],
                    'dislikes' => [
                        '$sum' => '$videos.dislikes'
                    ]
                ]
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'title' => 1,
                    'channelId' => 1,
                    'ratio' => [
                        '$round' => [
                            [
                                '$divide' => ['$likes', '$dislikes']
                            ],
                            0
                        ]
                    ]
                ]
            ],
            [
                '$sort' => [
                    'ratio' => -1
                ]
            ],
            [
                '$limit' => $limit
            ]
        ]);

        return $data->toArray();
    }
}
