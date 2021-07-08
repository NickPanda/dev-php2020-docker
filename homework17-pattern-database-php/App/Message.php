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
     * Запись данных в стандартный вывод.
     * 
     * @param string $string
     * 
     * @return void
     */
    public static function writeStdOut(string $string): void
    {
        fwrite(\STDOUT, $string . PHP_EOL);
    }
}