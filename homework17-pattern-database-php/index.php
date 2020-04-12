<?php

//var_dump($argv);

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require 'vendor/autoload.php';

$app = new \App\Application();

$app->run();

?>


<?php
try {
    $dbh = new PDO('pgsql:host=localhost;port=5432;dbname=cinema;user=postgres;password=postgres');
    foreach($dbh->query('SELECT * from movies') as $row) {
        //print_r($row);
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error1!: " . $e->getMessage() . "<br/>";
    die();
}
?>