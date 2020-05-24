<?php

namespace App\Controller;

use App\Message\ResponseMessage;
use App\Repository\ChannelRepository;
use App\Api\YoutubeApi;
use GuzzleHttp\Client;
use Klein\Request;

/**
 * Class ChannelController
 * @package App\Controller
 */
class ChannelController
{

    /**
     * Главная страница с доступными методами.
     * 
     * /index
     */
    public function index() {

        $allowedMethods = [
                [
                    'method' => 'GET',
                    'uri' => '/spider',
                    'description' => '"Паук" для получения и сохранения данных с YouTube',
                ],
                [
                    'method' => 'GET',
                    'uri' => '/statistics-channel-videos',
                    'description' => 'Суммарное кол-во лайков и дизлайков всех видео на канале',
                ],
                [
                    'method' => 'GET',
                    'uri' => '/top-channels',
                    'description' => 'ТОП каналов с лучшим соотношением кол-во лайков/кол-во дизлайков',
                ],
                [
                    'method' => 'DELETE',
                    'uri' => '/channels',
                    'description' => 'Удаление каналов из БД',

                ],
        ];

        try {
            return ResponseMessage::success(json_encode($allowedMethods, JSON_THROW_ON_ERROR));
        } catch (\JsonException $e) {
            return ResponseMessage::error($e->getMessage());
        }    
    }

    /**
     * "Паук" для получения и сохранения данных с YouTube.
     * 
     * Сбор списка каналов, видео с каналов и кол-во лайков/дизлайков (статистика видео).
     * 
     * /spider
     */
    public function spider()
    {
        $client = new Client();

        $youtubeApi = new YoutubeApi($client);

        $channelRepository = new ChannelRepository();

        try {
            $channels = $youtubeApi->getJsonChannels('main', 'https://www.googleapis.com/youtube/v3/search');
            $channelRepository->insertMany($channels);

            return ResponseMessage::success(json_encode(['data' => 'Ok'], JSON_THROW_ON_ERROR));
        } catch (\Exception $e) {
            return ResponseMessage::error($e->getMessage());
        }
    }

    /**
     * Удаление каналов из БД.
     * 
     * /channels
     */
    public function deleteChannels()
    {
        $channelRepository = new ChannelRepository();

        $channelRepository->deleteAll();

        try {
            return ResponseMessage::success(json_encode(['data' => 'Ok'], JSON_THROW_ON_ERROR));
        } catch (\JsonException $e) {
            return ResponseMessage::error($e->getMessage());
        }
    }

    /**
     * ТОП каналов с лучшим соотношением кол-во лайков/кол-во дизлайков.
     * 
     * /top-channels
     * 
     * @param Request $request
     */
    public function topChannels(Request $request)
    {
        $channelRepository = new ChannelRepository();

        $limit = $request->param('limit_n') ?? 5;

        $data = $channelRepository->getTopChannels($limit);

        try {
            return ResponseMessage::success(json_encode($data, JSON_THROW_ON_ERROR));
        } catch (\JsonException $e) {
            return ResponseMessage::error($e->getMessage());
        }

    }

    /**
     * Суммарное кол-во лайков и дизлайков всех видео на канале.
     * 
     * /statistics-channel-videos
     */
    public function statisticsChannelVideos()
    {
        $channelRepository = new ChannelRepository();

        $data = $channelRepository->getStatisticsSum();

        try {
            return ResponseMessage::success(json_encode($data, JSON_THROW_ON_ERROR));
        } catch (\JsonException $e) {
            return ResponseMessage::error($e->getMessage());
        }
    }
}
