<?php


namespace App\Model;

/**
 * Class VideoModel
 * @package App\Model
 */
class VideoModel
{

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var string $videoId
     */
    private $videoId;

    /**
     * @var int $likes
     */
    private $likes = 0;

    /**
     * @var int $dislikes
     */
    private $dislikes = 0;

    /**
     * @return string
     */
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
    public function getVideoId(): string
    {
        return $this->videoId;
    }

    /**
     * @param string $videoId
     * 
     * @return void
     */
    public function setVideoId(string $videoId): void
    {
        $this->videoId = $videoId;
    }

    /**
     * @return int
     */
    public function getLikes(): int
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     * 
     * @return void
     */
    public function setLikes(int $likes): void
    {
        $this->likes = $likes;
    }

    /**
     * @return int
     */
    public function getDislikes(): int
    {
        return $this->dislikes;
    }

    /**
     * @param int $dislikes
     * 
     * @return void
     */
    public function setDislikes(int $dislikes): void
    {
        $this->dislikes = $dislikes;
    }

    /**
     * @param array $statistics
     * 
     * @return void
     */
    public function setVideoStatistics(array $statistics): void
    {
        $this->setLikes($statistics['likes']);
        $this->setDislikes($statistics['dislikes']);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'title' => $this->getTitle(),
            'videoId' => $this->getVideoId(),
            'likes' => $this->getLikes(),
            'dislikes' => $this->getDislikes(),
        ];
    }
}
