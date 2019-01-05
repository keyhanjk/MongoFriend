## under construction 23

### Simple MongoDB ORM for PHP
#### How to install requirements of MongoDB on PHP?
- Install mongodb in linux debian base
http://zetcode.com/db/mongodbphp/

- Install php_mongodb extension on windows
find php_mongodb extension according to your system
>for example for thread-safe php 7 32 bit
https://windows.php.net/downloads/pecl/releases/mongodb/1.5.3/

- Put php_mongodb(dll/so) library in directory 'ext' of your php

- Update php.ini file
add extension=mongodb to php.ini file

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

> Delete
```php
$filters = ["age" => "30"];
$rows = $users->delete($filters);
```

> Update
```php
$filters = ["age" => "30"];
$changes = ["age" => "25"];
$users->update($filters, $changes);
```

> Generate fake user for testing
```php
$user = generateFakeUser();
var_dump($user);

array(5) {
  ["name"]=>
  string(6) "Lioara"
  ["surname"]=>
  string(7) "Livescu"
  ["gender"]=>
  string(6) "female"
  ["region"]=>
  string(7) "Romania"
  ["age"]=>
  int(16)
}
```
