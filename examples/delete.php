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
$filter = ["age" => "30"];
$rows = $users->delete($filter);

