<?php

namespace App\Message;

/**
 * Class ResponseMessage
 * @package App\Message
 */
class ResponseMessage
{

    public const STATUS_OK = 200;
    public const STATUS_BAD_REQUEST = 400;

    /**
     * @param string $text
     * 
     * @return void
     */
    public static function success(string $text, string $contentType = 'application/json'): void
    {
        self::setContentType($contentType);
        self::setHeaderHttpStatus(self::STATUS_OK);
        print $text;
    }

    /**
     * @param string $text
     * @param string $contentType
     * 
     * @return void
     */
    public static function error(string $text, string $contentType = 'application/text'): void
    {
        self::setContentType($contentType);
        self::setHeaderHttpStatus(self::STATUS_BAD_REQUEST);
        print $text;
    }

    /**
     * Установка заголовка HttpStatus.
     * 
     * @param int $code
     */
    private static function setHeaderHttpStatus(int $code) {
        http_response_code($code);
    }

    /**
     * Установка заголовка Content-Type.
     * 
     * @param string $contentType
     */
    private static function setContentType(string $contentType) {
        header('Content-Type: '.$contentType);
    }
}
