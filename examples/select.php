<?php

namespace Examples;

require dirname(__DIR__) . '/vendor/autoload.php';

use MongoFriend\MongoFriend;

$mongo = new MongoFriend([
    'host' => 'localhost',
    'dbname' => 'db_mihan_monitor',
    'uname' => '',
    'upass' => '',
]);

$users = $mongo->table("users");

$result = $users->find(["age" => "27"])->offset(1);
$result->display();
// $result = $users->find()->limit(1, 10)->sort(["id" => "asc"])->result(); 
