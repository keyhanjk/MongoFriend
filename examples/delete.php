<?php

namespace Examples;

require 'common.php';

use MongoFriend\MongoFriend;

$users = $mongo->table("users");
$filter = ["age" => "30"];
$rows = $users->delete($filter);
