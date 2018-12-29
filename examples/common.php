<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use MongoFriend\MongoFriend;

$mongo = new MongoFriend([
    'host' => 'localhost',
    'dbname' => 'db_mihan_monitor',
    'uname' => '',
    'upass' => '',
]);

function generateFakeUser()
{
    $genders = ['male', 'female'];
    $gender = $genders[rand(0, 1)];
    $fakeUser = file_get_contents("https://uinames.com/api/?gender=$gender");
    $user = json_decode($fakeUser, true);
    $user['age'] = rand(10, 40);
    return $user;
}
