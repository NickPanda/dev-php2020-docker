<?php

namespace Tests;

use App\Application;
use PHPUnit\Framework\TestCase;

class GenerateTest extends TestCase
{
    /**
     * @testdox Проверка корректной строки.
     */
    public function testCorrectString()
    {
        $string = 'Строка';
        $num = '1';
        $msg = '#' . $num . $string;
        $app = new Application();
        $genStr = $app->generateString($num, $string);

        $this->assertEquals($genStr, $msg);
    }

    /**
     * @testdox Проверка некорректной строки.
     */
    public function testNotCorrectString()
    {
        $string = 'Строка';
        $num = '1';
        $msg = '#' . $string . $num;
        $app = new Application();
        $genStr = $app->generateString($num, $string);

        $this->assertNotEquals($genStr, $msg);
    }
}
