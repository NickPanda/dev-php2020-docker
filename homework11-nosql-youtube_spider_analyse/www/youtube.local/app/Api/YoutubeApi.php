<?php

namespace App\Api;

use App\Model\ChannelModel;
use App\Model\VideoModel;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Class YoutubeApi
 * @package App\Api
 */
class YoutubeApi
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->apiKey = getenv('YOUTUBE_API_KEY');
        $this->client = $client;
    }

    /**
     * @param string $query 
     * @param string $url
     * 
     * @return array
     */
    public function getJsonChannels(string $query, string $url): array
    {
        $response = $this->client->get($url, [
            'query' => [
                'key' => $this->apiKey,
                'part' => 'snippet',
                'maxResults' => 10,
                'q' => $query,
                'regionCode' => 'ru',
                'type' => 'channel',
            ]
        ]);

        $channels = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

        $channelEntities = [];

        foreach ($channels['items']  as $channel) {
            $entityChannel = new ChannelModel();

            $entityChannel->setTitle($channel['snippet']['title']);
            $entityChannel->setChannelId($channel['id']['channelId']);

            $videos = $this->getVideos('https://www.googleapis.com/youtube/v3/search', $entityChannel->getChannelId());

            $entityChannel->setVideos($videos);

            $channelEntities[] = $entityChannel->jsonSerialize();

        }

        return $channelEntities;
    }

    /**
     * @param string $url 
     * @param string $channelId
     * 
     * @return array
     */
    public function getVideos(string $url, string $channelId): array
    {
        $response = $this->client->request('get', $url, [
            'query' => [
                'key' => $this->apiKey,
                'part' => 'snippet',
                'maxResults' => 5,
                'type' => 'video',
                'channelId' => $channelId,
            ]
        ]);

        $videos = json_decode($response->getBody()->getContents(), true);

        $videoEntities = [];

        foreach ($videos['items'] as $video) {
            $videoEntity = new VideoModel();

            $videoEntity->setTitle($video['snippet']['title']);
            $videoEntity->setVideoId($video['id']['videoId']);

            $statistics = $this->getVideoStatistics('https://www.googleapis.com/youtube/v3/videos',$videoEntity->getVideoId());

            $videoEntity->setVideoStatistics($statistics);

            $videoEntities[] = $videoEntity;
        }

        return $videoEntities;
    }

    /**
     * @param string $url 
     * @param string $videoId
     * 
     * @return array
     */
    public function getVideoStatistics(string $url, string $videoId): array
    {
        $response = $this->client->request('get', $url, [
            'query' => [
                'key' => $this->apiKey,
                'part' => 'statistics',
                'id' => $videoId,
            ]
        ]);
        $statistics = json_decode($response->getBody()->getContents(), true)['items'];

        $statistics = $statistics[0];

        $statisticEntity = [
            'likes' => 0,
            'dislikes' => 0
        ];
        if ($statistics !== null) {
            $statisticEntity['likes'] = (int)$statistics['statistics']['likeCount'];
            $statisticEntity['dislikes'] = (int)$statistics['statistics']['dislikeCount'];
        }

        return $statisticEntity;
    }
}
