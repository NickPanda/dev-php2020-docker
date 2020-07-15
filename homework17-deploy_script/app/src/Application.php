<?php

namespace App;

use Exception;

/**
 * Класс Application
 *
 * @package App
 */
class Application
{

    /**
     * @return void
     */
    public function run(): void
    {
        try {
            if (!isset($_GET['string'])) {
                throw new Exception('Не передан параметр string!');
            }
            if (!$_GET['string']) {
                throw new Exception('Передана пустая строка!');
            }

            $count = $_GET['count'] ?? 111;


            for ($i = 0; $i < $count; $i++) {
                $msg = $this->generateString($i, $_GET['string']);
                Message::writeOutput($msg . '<br>');
            }

            return;
        } catch (Exception $e) {
            http_response_code(400);
            Message::writeOutput($e->getMessage());

            return;
        }
    }

    /**
     * Генерация строки.
     * @param int $num
     * @param string $string
     */
    public function generateString(int $num, string $string)
    {
        return '#' . $num . $string;
    }
}
