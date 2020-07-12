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

            $count = $_GET['count'] ?? 6;

            for($i=0; $i<$count; $i++) {
                Message::writeOutput($_GET['string'].'<br>');
            }

            return;
        } catch(Exception $e) {
            http_response_code(400);
            Message::writeOutput($e->getMessage());

            return;
        }
    }
}