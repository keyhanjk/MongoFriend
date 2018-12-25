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

$result = $users->find()->limit(1, 10)->sort(["id" => "asc"])->result();
$result->display();
// $result = $users->find()->where("id > 100")->either("created_dt < 200")->get();
// $result = $users->find()->where("id > 100")->also("created_dt < 200")->limit(1, 10)->get();
// $result = $users->find()->where("id > 100")->also("created_dt < 200")->limit(1, 10)->sort("id")->get();
