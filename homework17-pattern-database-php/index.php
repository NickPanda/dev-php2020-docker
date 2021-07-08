<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require 'vendor/autoload.php';

$app = new \App\Application();

try {
    $app->run();
} catch(\Exception $e) {
    \App\Message::writeStdOut($e->getMessage());
}

?>
