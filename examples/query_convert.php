<?php

namespace Examples;

require dirname(__DIR__) . '/vendor/autoload.php';

use MongoFriend\MongoFriend;
use PHPSQLParser;

$mongo = new MongoFriend([
    'host' => 'localhost',
    'dbname' => 'db_mihan_monitor',
    'uname' => '',
    'upass' => '',
]);

error_reporting(E_ALL ^ E_WARNING);

$sql1 = 'SELECT a,b,c
          from some_table an_alias
	  join `another` as `another table` using(id)
	where d > 5;';

$sql2 = 'SELECT a,b,c
          from some_table an_alias, table2
	  join (select d, max(f) max_f
                 from some_table
                where id = 37
                group by d) `subqry` on subqry.d = an_alias.d
	where d > 5;';

// $sql3 = "SELECT sum(a) S,b,c
//           from some_table an_alias
//         where d > 5 AND ('fname'='lname%' OR age > 34);";

$sql4 = "SELECT STRAIGHT_JOIN a, b, c
FROM some_table an_alias
WHERE d > 5;";

$sql = $sql4;
echo $sql . "\n";
$parser = new PHPSQLParser();
//print_r($parser->parsed);
$parsed = $parser->parse($sql, true);

$a = json_encode($parsed['FROM'], JSON_PRETTY_PRINT);
$a = json_encode($parsed, JSON_PRETTY_PRINT);
print $a;

error_reporting(E_ALL);
