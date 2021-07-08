<?php 

namespace App;

/**
 * Класс Pages
 * 
 * @package App
 */
class Pages {

    public function list(Application $app) {
        $dbh = DB::getDbh();
        $movies = Movie::getAll($dbh);

        if (empty($movies)) {
            Message::writeStdOut('Всего: '.count($movies).' фильмов');
            foreach($movies as $movie) {
                Message::writeStdOut(
                    sprintf('Название фильма (%s+): %s. Продолжительность: %s минут. ', 
                        $movie['age_rating'], 
                        $movie['name'],
                        $movie['duration']));
            }
        } else {
            Message::writeStdOut('Фильмов нет');
        }
    }

    public function item(Application $app) {
        $id = $app->getId();
        if (!$id || !ctype_digit($id)) {
            throw new \Exception('передан не верный id');
        }
        $dbh = DB::getDbh();
        $movie = Movie::getById($dbh, $id);
        if ($movie) {
            Message::writeStdOut(
                sprintf('Название фильма (%s+): %s. Продолжительность: %s минут.', 
                    $movie['age_rating'], 
                    $movie['name'],
                    $movie['duration']));
        } else {
             Message::writeStdOut('Фильм не найден');
        }
    }

    public function add(Application $app) {
        $dbh = DB::getDbh();

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
        $dbh = DB::getDbh();
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
        $dbh = DB::getDbh();
        if (!Movie::deleteById($dbh, $id)) {
            throw new \Exception('Запись не была удалена!');
        }
    }
}
