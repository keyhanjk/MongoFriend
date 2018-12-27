<?php

namespace Examples;

require dirname(__DIR__) . '/vendor/autoload.php';
require 'common.php';

use MongoFriend\MongoFriend;

$users = $mongo->table("users");
$filters = [];
$changes = ["age" => 85]; // age is integer
$users->update($filters, $changes);
