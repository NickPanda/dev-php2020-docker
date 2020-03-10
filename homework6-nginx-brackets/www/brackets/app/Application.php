<?php

namespace App;

use Exception;
use PhpDev2020HT6\BracketsValidate;

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
        $BracketsValidate = new BracketsValidate;

        try {
            if (!isset($_POST['string'])) {
                throw new Exception('Не передан параметр string!');
            }
            $string = $_POST['string'];
            if (!$string) {
                throw new Exception('Передана пустая строка!');
            }
            $result = BracketsValidate::checkingStringBrackets($string);

            if (!$result) {
                throw new Exception('Строка не валидная!');
            }
            Message::writeOutput('Строка валидная!');
            return;
        } catch(Exception $e) {
            http_response_code(400);
            Message::writeOutput($e->getMessage());
            return;
        }
    }
}
