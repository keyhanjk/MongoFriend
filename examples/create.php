<?php

namespace Examples;

require 'common.php';

use MongoFriend\MongoFriend;

$users = $mongo->table("users");

$user = generateFakeUser();
var_dump($user);
$userId = $users->add($user);
var_dump($userId);
