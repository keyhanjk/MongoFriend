<?php

namespace Examples;

require 'common.php';

use MongoFriend\MongoFriend;

$users = $mongo->table("users");
$filter = ["age" => "27"];
//$filter = ["firstname" => ['$regex' => 'm']];

$options = ['sort' => ['age' => -1], 'limit' => 2];
$rows = $users->find($filter, $options);
foreach ($rows as $row) {
    printf("%s\n", $row['_id']);
}
