<?php

require 'vendor/autoload.php';

use PhpDev2020HT7\EmailValidate;

$list = [
    'nick@badasspanda.ru',
    'badasspanda@yandex.ru',
    'qwerty@mail.ru',
    'поддержка@почта.рус',
    'qwerty.qwerty@qwerty.com',
    'qwerty-qwerty@qwerty.com',
    'qwerty-qwerty.qwerty@qwerty.com',
    'привет@россия.рф', // не существует MX
    'qwert@mx_rec.net', // не существует MX
    'qwerty', // не формат email
    'qwerty.com', // не формат email
    '@qwerty.com', // не формат email
    'qwerty@com', // не формат email
];

$EmailValidate = new EmailValidate();

$list_S = implode($list, ',');
$list_J = json_encode($list);

$res = $EmailValidate->verifyEmailList($list_J, ['format'=>'json']);

var_dump($res);
/*
array(13) {
  ["nick@badasspanda.ru"]=>
  bool(true)
  ["badasspanda@yandex.ru"]=>
  bool(true)
  ["qwerty@mail.ru"]=>
  bool(true)
  ["поддержка@почта.рус"]=>
  bool(true)
  ["qwerty.qwerty@qwerty.com"]=>
  bool(true)
  ["qwerty-qwerty@qwerty.com"]=>
  bool(true)
  ["qwerty-qwerty.qwerty@qwerty.com"]=>
  bool(true)
  ["привет@россия.рф"]=>
  bool(false)
  ["qwert@mx_rec.net"]=>
  bool(false)
  ["qwerty"]=>
  bool(false)
  ["qwerty.com"]=>
  bool(false)
  ["@qwerty.com"]=>
  bool(false)
  ["qwerty@com"]=>
  bool(false)
}
*/
