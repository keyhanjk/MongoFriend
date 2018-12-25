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

//insert
$user = [
    "firstname" => "rambod3",
    "lastname" => "javan",
    "position" => "host",
    "program" => "خندوانه",
];
print $users->add($user);
