<?php 

namespace App;


class Application {

    /**
     * @var array
     */
     private $options;

     public function run() {

        $pages = ['list', 'item'];

        $this->getOptions();
        $page =  $this->getPage();
        if (!$page) {
            throw \Exception('не указана страница');
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
