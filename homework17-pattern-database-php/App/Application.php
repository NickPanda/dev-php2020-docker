<?php 

namespace App;

/**
 * Класс Application
 * 
 * @package App
 */
class Application {

    /**
     * @var array
     */
     private $options;

     public function run() {

        Config::checkEnv();

        $allowedPages = ['list', 'item', 'add', 'edit', 'delete'];

        $this->getOptions();
        $page =  $this->getPage();
        if (!$page) {
            throw new \Exception('не указана страница');
        }

        if (!in_array($page, $allowedPages)){
            throw new \Exception('Страница не найдена');

        }

        $pages = new Pages();
        $pages->$page($this);

     }

     private function getPage() {
         return $this->options['p'] ?? $this->options['page'] ?? '';
     }

     private function getOptions() {
        $shortopts  = "";
        $shortopts .= "p:";  // Обязательное значение

        $longopts  = array(
            "page:",
            "id:",
        );
        $this->options = getopt($shortopts, $longopts);
     }

     public function getId() {
         return $this->options['id'] ?? '';
     }
}
