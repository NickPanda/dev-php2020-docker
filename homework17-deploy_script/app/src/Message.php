<?php

namespace App;

/**
 * Класс Message
 *
 * @package App
 */
class Message
{
    /**
     * Вывод данных на экран.
     *
     * @param string $string
     *
     * @return void
     */
    public static function writeOutput(string $string): void
    {
        echo $string;
    }
}