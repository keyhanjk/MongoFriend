### Simple MongoDB ORM for PHP
#### Features
>Create

```php

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
echo $users->add($user);


```
