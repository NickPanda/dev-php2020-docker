<?php

namespace App\Model;

/**
 * Class ChannelModel
 * @package App\Model
 */
class ChannelModel
{

    /**
     * @var string
     */
    private $title;

    /** 
     * @var string
     */
    private $channelId;
    
    /**
     * @var array
     */
    private $videos = [];

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * 
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }

    /**
     * @param string $channelId
     * 
     * @return void
     */
    public function setChannelId(string $channelId): void
    {
        $this->channelId = $channelId;
    }

    /**
     * @return array
     */
    public function getVideos(): array
    {
        return $this->videos;
    }

    /**
     * @param array $videos
     */
    public function setVideos(array $videos): void
    {
        $this->videos = $videos;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $channel = [
            'title' => $this->getTitle(),
            'channelId' => $this->getChannelId(),
        ];
        foreach ($this->getVideos() as $video) {
            $channel['videos'][] = $video->jsonSerialize();
        }

        return $channel;
    }
}
