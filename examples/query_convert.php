<?php

namespace Examples;

require dirname(__DIR__) . '/vendor/autoload.php';

use PHPSQLParser\PHPSQLParser;

error_reporting(E_ALL ^ E_WARNING);

$sql1 = "SELECT a,b,c
          FROM table1
          WHERE a > 5 AND b < 4;";

$sql2 = "DELETE FROM table1
          WHERE a > 5 AND b < 4;";

$sql3 = "UPDATE table1
          SET age = 4, grade = grade + 78
          WHERE a > 5 AND b < 4;";

$sql4 = "INSERT INTO table1
          (fname, lname, age)
          VALUES
          ('keyhan', 'jk', 30);";

$sql5 = "SELECT COUNT(id), fname, lname
          FROM table1
          WHERE a > 5 AND (b < 4 OR id = 5 AND age > 70);";

function selectPart($sqlPart)
{
    foreach ($sqlPart as $part) {
        if ($part['expr_type'] == 'colref') {
            print "|" . $part['no_quotes']['parts'][0] . "\n";
        } else if ($part['expr_type'] == 'aggregate_function') {
            $subTree = $part['sub_tree'][0]['base_expr'];
            print "|" . $part['base_expr'] . " " . $subTree . "\n";
        }
    }
}

function fromPart($sqlPart)
{
    foreach ($sqlPart as $part) {
        if ($part['expr_type'] == 'table') {
            print "|" . $part['table'] . "\n";
        }
    }
}

function deletePart($sqlPart)
{

}

function wherePart($sqlPart, $i = 1)
{
    foreach ($sqlPart as $part) {
        if ($part['expr_type'] == 'colref') {
            print str_repeat('|', $i) . $part['no_quotes']['parts'][0] . "\n";
        } else if ($part['expr_type'] == 'operator') {
            print str_repeat('|', $i) . $part['base_expr'] . "\n";
        } else if ($part['expr_type'] == 'const') {
            print str_repeat('|', $i) . $part['base_expr'] . "\n";
        } else if ($part['expr_type'] == 'bracket_expression') {
            wherePart($part['sub_tree'], $i + 1);
        }
    }
}

$sql = $sql5;
echo $sql . "\n";
$parser = new PHPSQLParser();
//print_r($parser->parsed);
$parsed = $parser->parse($sql, true);

foreach ($parsed as $type => $parts) {
    print "$type\n";
    if ($type == 'SELECT') {
        selectPart($parts);
    } else if ($type == 'FROM') {
        fromPart($parts);
    } else if ($type == 'DELETE') {
        deletePart($parts);
    } else if ($type == 'WHERE') {
        wherePart($parts);
    }
}

//where

//$a = json_encode($parsed['FROM'], JSON_PRETTY_PRINT);
$a = json_encode($parsed, JSON_PRETTY_PRINT);
print $a;

error_reporting(E_ALL);

// use MongoFriend\MongoFriend;
// $mongo = new MongoFriend([
//     'host' => 'localhost',
//     'dbname' => 'db_mihan_monitor',
//     'uname' => '',
//     'upass' => '',
// ]);
