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
$filter = ["age" => "27"];
$options = ['sort' => ['age' => -1], 'limit' => 2];
$rows = $users->find($filter, $options);
foreach ($rows as $row) {
    printf("%s\n", $row['_id']);
}
