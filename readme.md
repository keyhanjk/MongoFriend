
### Simple MongoDB ORM for PHP
#### Features
 
> Connect to database

```php
use MongoFriend\MongoFriend;

$mongo = new MongoFriend([
    'host' => 'localhost',
    'dbname' => 'db_mihan_monitor',
    'uname' => '',
    'upass' => '',
]);

```

> Pick a table

```php

$users = $mongo->table("users");
```


>Create

```php
$user = [
    "firstname" => "rambod3",
    "lastname" => "javan",
    "position" => "host",
    "program" => "خندوانه",
];

echo $users->add($user); //returns last id
```

> Read

```php
$filters = ["age" => "27"];
/* 
-1 is descending = downward
 1 is ascending  = upward 
*/
$options = ['sort' => ['age' => -1], 'limit' => 2, 'skip' => 0];
$rows = $users->find($filters, $options);
foreach ($rows as $row) {
    printf("%s\n", $row['_id']);
}
```

> delete
```php
$filters = ["age" => "30"];
$rows = $users->delete($filters);
```

> update
```php
$filters = ["age" => "30"];
$changes = ["age" => "25"];
$users->update($filters, $changes);
```