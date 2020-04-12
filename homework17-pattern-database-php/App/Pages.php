<?php 

namespace App;

class Pages {

    public function list(Application $app) {
        $dbh = Config::getDbh();
        $movies = Movie::getAll($dbh);

        if (!empty($movies)) {
            print 'Всего: '.count($movies)." фильмов\n";
            foreach($movies as $movie) {
                print sprintf("Название фильма (%s+): %s. Продолжительность: %s минут. \n", 
                $movie['age_rating'], 
                $movie['name'],
                $movie['duration']);
            }
        } else {
            print "Фильмов нет";
        }
    }

    public function item(Application $app) {
        $id = $app->getId();
        if (!$id || !ctype_digit($id)) {
            throw new \Exception('передан не верный id');
        }
        $dbh = Config::getDbh();
        $movie = Movie::getById($dbh, $id);
        if ($movie) {
            print sprintf('Название фильма (%s+): %s. Продолжительность: %s минут.', 
            $movie['age_rating'], 
            $movie['name'],
            $movie['duration']);
        } else {
            print "Фильм не найден";
        }
    }

    public function add(Application $app) {
        $dbh = Config::getDbh();

        $fields = ['Белый клык', '123', '18'];
        if (!Movie::insert($dbh, $fields)) {
            throw new \Exception('Запись не была добавлена!');
        }
    }

    public function edit(Application $app) {
        $id = $app->getId();
        if (!$id || !ctype_digit($id)) {
            throw \Exception('передан не верный id');
        }
        $dbh = Config::getDbh();
        $fields = [
            'name' => 'Фильм'.$id, 
            'duration' => rand(45, 220),
            'age_rating' => rand(0,18)];

        if (!Movie::updateById($dbh, $fields, $id)) {
            throw new \Exception('Запись не была обновлена!');
        }
    }

    public function delete(Application $app) {
        $id = $app->getId();
        if (!$id || !ctype_digit($id)) {
            throw \Exception('передан не верный id');
        }
        $dbh = Config::getDbh();
        if (!Movie::deleteById($dbh, $id)) {
            throw new \Exception('Запись не была удалена!');
        }
    }
}
